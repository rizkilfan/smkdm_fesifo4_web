<?php
include '../config/database.php';

if ($_SESSION['role'] != 'guru') {
    header("Location: ../auth/login.php");
    exit();
}

// ke catatan alasan penolakan dari guru pakai modal aja ga --ranti
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $status = ($_GET['action'] == 'setuju') ? 'disetujui' : 'ditolak';
    $catatan = ($_GET['catat'] == null) ? null : $_GET['catat'];

    $stmt = $conn->prepare("UPDATE submissions SET status = ?, catatan_guru = ? WHERE id_sub = ?");
    if ($stmt->execute([$status, $catatan, $id])) {
        echo "<script>alert('STATUS TERUPDATE! Dashboard sedang diperbarui.'); window.location='validasi.php';</script>";
    }
}

// ini query ke data pending yaa --ranti
$query = $conn->query("SELECT s.*, u.nama FROM submissions s JOIN users u ON s.id_user = u.id_user WHERE s.status = 'pending' ORDER BY s.tanggal_input ASC");
$submissions = $query->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validasi Tugas - AKSARA+</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,700;0,900;1,400&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" rel="stylesheet">
    <link href="../assets/style.css" rel="stylesheet">
</head>

<body class="bg-light">

    <header class="page-header">
        <div class="container d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-black uppercase m-0">Validasi Literasi Siswa <i class="fa-solid fa-magnifying-glass"></i></h2>
                <p class="m-0 fw-bold small uppercase">Tinjau ulasan!</p>
            </div>
            <a href="index.php" class="btn btn-dark comic-btn">DASHBOARD</a>
        </div>
    </header>
    
    <div class="container mb-5">
        <?php if (empty($submissions)): ?>
            <div class="comic-border bg-white p-5 text-center">
                <h1 style="font-size: 4rem;"><i class="fa-solid fa-satellite-dish"></i></h1>
                <h3 class="fw-black uppercase">SEMUA BERES!</h3>
                <p class="fw-bold text-muted">Tidak ada tugas yang tertunda. Saatnya istirahat sejenak.</p>
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($submissions as $s): ?>
                    <div class="col-12 mb-4">
                        <div class="comic-border bg-white p-0 overflow-hidden">
                            <div class="bg-dark text-white p-2 px-4 d-inline-block fw-black uppercase small" style="border-bottom-right-radius: 0; border-right: 3px solid var(--dark); border-bottom: 3px solid var(--dark);">
                                Siswa: <?= htmlspecialchars($s['nama']) ?>
                            </div>

                            <div class="p-4">
                                <div class="row align-items-center">
                                    <div class="col-lg-8">
                                        <h3 class="fw-black text-primary uppercase mb-1"><?= htmlspecialchars($s['judul_buku']) ?></h3>
                                        <p class="fw-bold mb-3 small">KARYA: <span class="text-danger"><?= htmlspecialchars($s['penulis']) ?></span> | TANGGAL: <?= date('d/m/Y', strtotime($s['tanggal_input'])) ?></p>

                                        <div class="ringkasan-box mt-3">
                                            <p class="mb-0 small"><?= nl2br(htmlspecialchars($s['ringkasan'])) ?></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mt-4 mt-lg-0">
                                        <div class="d-grid gap-3">
                                            <a href="?action=setuju&id=<?= $s['id_sub'] ?>"
                                                class="btn comic-btn"
                                                style="background-color: var(--success-comic); color: black;"
                                                onclick="return confirm('Setujui litersi ini?!')">
                                                TERIMA & APPROVE <i class="fa-solid fa-circle-check"></i>
                                            </a>
                                            <a href="?action=tolak&id=<?= $s['id_sub'] ?>"
                                                class="btn comic-btn"
                                                style="background-color: var(--danger-comic); color: white;"
                                                onclick="return tolakliterasi(this)">
                                                TOLAK TUGAS <i class="fa-solid fa-circle-xmark"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // pake modal js bawaan weh nya... males nyieun modal cutom... --ranti
        function tolakliterasi(el) {
            let alasan = prompt("Tolak literasi ini?\nMasukkan alasan:");

            if (alasan === null) return false;

            if (alasan.trim() === "") {
                alert("Alasan Penolakan wajib diisi!");
                return false;
            }

            alasan = encodeURIComponent(alasan);

            let baseUrl = el.getAttribute("href");
            el.setAttribute("href", baseUrl + "&catat=" + alasan);

            return true;
        }
    </script>
</body>

</html>
