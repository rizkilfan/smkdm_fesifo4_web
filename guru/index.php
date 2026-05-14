<?php
include '../config/database.php';

if ($_SESSION['role'] != 'guru') {
    header("Location: ../auth/login.php");
    exit();
}

$countPending = $conn->query("SELECT COUNT(*) FROM submissions WHERE status = 'pending'")->fetchColumn();
$countTotal = $conn->query("SELECT COUNT(*) FROM submissions ")->fetchColumn();
$countSiswa = $conn->query("SELECT COUNT(*) FROM users WHERE role = 'siswa'")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Guru - AKSARA+</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,700;0,900;1,400&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" rel="stylesheet">
    <link href="../assets/style.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg sticky-top mb-4">
        <div class="container">
            <a class="navbar-brand fw-black fs-3" href="#">AKSARA<span class="text-primary">+</span> GURU</a>
            <div class="ms-auto">
                <span class="fw-bold me-3 d-none d-md-inline">Halo, <?= $_SESSION['nama'] ?>! <i class="fa-solid fa-chalkboard-user"></i></span>
                <a href="../auth/logout.php" class="btn btn-danger comic-btn py-1 px-3" style="font-size: 0.8rem;">LOGOUT</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="mb-5">
            <h2 class="fw-black uppercase">Ringkasan Literasi Sekolah</h2>
            <p class="fw-bold text-muted">Pantau dan validasi perkembangan baca siswa di sini.</p>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="comic-border info-card text-center" style="background-color: var(--secondary-bg); color: white;">
                    <h6 class="fw-black text-uppercase small">Perlu Validasi</h6>
                    <h1 class="fw-black m-0" style="font-size: 3.5rem;"><?= $countPending ?></h1>
                    <div class="mt-2">
                        <a href="validasi.php" class="btn btn-dark comic-btn py-1 px-3 mt-2" style="font-size: 0.7rem;">GAS VALIDASI &rarr;</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="comic-border info-card text-center" style="background-color: var(--primary-bg);">
                    <h6 class="fw-black text-uppercase small">Total Literasi</h6>
                    <h1 class="fw-black m-0" style="font-size: 3.5rem;"><?= $countTotal ?></h1>
                    <p class="small fw-bold mt-2 mb-0">Laporan Masuk</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="comic-border info-card text-center" style="background-color: var(--accent);">
                    <h6 class="fw-black text-uppercase small">Siswa Aktif</h6>
                    <h1 class="fw-black m-0" style="font-size: 3.5rem;"><?= $countSiswa ?></h1>
                    <p class="small fw-bold mt-2 mb-0">Pembaca Terdaftar</p>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <h4 class="fw-black uppercase m-0">Aktivitas Terbaru</h4>
            </div>
        </div>

        <div class="comic-border bg-white overflow-hidden mb-5">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-4 py-3">SISWA</th>
                            <th class="py-3">JUDUL BUKU</th>
                            <th class="py-3 text-center">STATUS</th>
                            <th class="py-3 text-center">CATATAN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Logic ini sama gue ga hehe... --ranti -->
                        <?php
                        $latest = $conn->query("SELECT s.*, u.nama FROM submissions s JOIN users u ON s.id_user = u.id_user 
                        ORDER BY s.tanggal_input DESC LIMIT 5");
                        while($row = $latest->fetch()):
                        ?>
                        <tr class="align-middle">
                            <td class="ps-4 py-3">
                                <div class="fw-black text-primary uppercase small"><?= htmlspecialchars($row['nama']) ?></div>
                            </td>
                            <td>
                                <div class="fw-bold"><?= htmlspecialchars($row['judul_buku']) ?></div>
                            </td>
                            <td class="text-center">
                                <?php if($row['status'] == 'pending'): ?>
                                    <span class="badge badge-status" style="background-color: var(--warning-comic); color: black;">PENDING</span>
                                <?php elseif($row['status'] == 'disetujui'): ?>
                                    <span class="badge badge-status" style="background-color: var(--success-comic); color: black;">DISETUJUI</span>
                                <?php else: ?>
                                    <span class="badge badge-status" style="background-color: var(--danger-comic); color: white;">DITOLAK</span>
                                <?php endif; ?>
                            </td>
                            <td class="ps-4 py-3">
                                <div class="small fw-bold text-muted" style="white-space: normal; word-break: break-word;"><?= $row['catatan_guru'] ? htmlspecialchars($row['catatan_guru']) : "-" ?></div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <div class="p-3 border-top border-3 border-dark text-center bg-light">
                <a href="rekap.php" class="text-dark fw-black small text-decoration-none uppercase">Lihat Seluruh Rekapitulasi Data &rarr;</a>
            </div>
        </div>
    </div>

    <footer class="py-4">
        <div class="container text-center text-white small fw-black uppercase">
            AKSARA+ GURU PANEL
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>