<!-- made by :

Ranti Tri Aulianti | XI RPL 1
Ade Rangga Asyani | XI RPL 1

@ SMKS DARUL MUKMININ

for LOMBA FESIFO 4.0 -->

<?php
include 'config/database.php';

//queryna tong diubah deui.... kie gs cukup... paling limit tambahan bisierek... --rantii
$query = $conn->query("SELECT  u.nama, COUNT(s.id_sub) as jumlah 
FROM users u JOIN submissions s ON u.id_user = s.id_user
WHERE s.status = 'disetujui' GROUP BY u.id_user ORDER BY jumlah DESC LIMIT 5");
$leaderboard = $query->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale-1.0">
    <title> AKSARA+ - Literasi Digital </title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css"
        rel="stylesheet">
    <link href="https://fonts.googlepis.com/css2?family=public+Sans:ital,wght@0,700;0,900;1,400&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" rel="stylesheet">
    <link href="assets/style.css" rel="stylesheet">

</head>

<body>
    <nav class="navbar navbar-expand-ig sticky-top">
        <div class="container">
            <a class="navbar-brand fw-black fs-3" href="#">AKSARA<span class="text=primary">+</span></a>
            <div class="ms-auto">
                <a href="auth/login.php" class="btn btn-warning comic-btn">LOGIN</a>
            </div>
        </div>
    </nav>
    <header class="hero-section text-center">
        <div class="container position-relative">
            <h1 class="hero-title mb-3"> TRANSFORMASI LITERASI!</h1>
            <p class="lead fw-bold mb-4 bg-white d-inline-block px-3 border border-darl"> ayo catat bacaanmu dan jadilah juara literasi sekolah.</p>
            <div class="mt-4">
                <a href="#leaderboard" class=btn btn-info comic-btn"> LIHAT RANKING </a>
            </div>
        </div>
    </header>

    <main class="container my-5">
        <div class="row g-5">
            <div class="col-lg-7">
                <h2 class="fw-black mb-4 uppercase" style="letter-spacing: -1px;"> MENGAPA HARUS DIGITAL?</h2>
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="comic-border info-card">
                            <h5 class="fw-bold"><i class=fa-solid fa-bolt-lightning"></i>CEPAT</h5>
                            <p class="small m-0">input ulasan buku dalam hitungan detik tanpa kertas.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- kagok cssna didieu --titiww -->
                        <div class="comic-border info-card" style="background-color: var(--accent);">
                            <h5 class="fw-bold"><i class="fa-solid fa-chart-simple"></i>EFISIEN</h5>
                            <p class="small m-0"> proses jadi jauh lebih cepat dan praktis untuk mencatat bacaanmu.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="comic-border info-card" style="background-color: var(--primary-bg);">
                            <h5 class="fw-bold"><i class="fa-solid fa-bars-progress"></i>SKALABILITAS</h5>
                            <p class="small m-0">Ruang pendataan akan terekspansi otomatis sesuai kebutuhan.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="comic-border info-card">
                            <h5 class="fw-bold"><i classfa-solid fa-flag-checkered"></i>KOMPETISI</h5>
                            <p class="small m-0">jadilah peringkat pertama di papan skor sekolah!</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- gaa.. ke ieu container na rada di scrol keun mu bisa mah --tiww -->
            <div class="col-lg-5" id="leaderboard">
                <div class="leaderboard-title text-center mb-4 shadow">
                    <h4 class="mb-0 fw-black"> TOP PEMBACA! <i class="fa=solid fa=trophy"></i></h4>
                </div>
                <div class="comic-border bg-white p-0 overflow-hidden">
                    <table class="table table-striped mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th class="ps-4">Siswa</th>
                                <th class-"text-center">Skor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($leaderboard)): ?>
                                <tr>
                                    <td colspan="2" class="test-center py-4"> Belum ada pahlawan literasi.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($leaderboard as $l): ?>
                                    <tr class="align-middle">
                                        <td class="ps-4 fw-bold"><?= strtoupper(htmlspecialchars($l['nama'])) ?></td>
                                        <td class="text-center">
                                            <span class="bagde bagde-comic px-3 py-2"><?= $l['jumlah'] ?> BUKU</span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <footer class="py-5 mt-5">
        <div class="container text-center">
            <h5 class="fw-bold mb-3"> AKSARA+</h5>
            <p class="small text-secondary mb-0"> SMKS DARIL MUKMININ - 2026 FESIFO 4.0</p>
        </div>
    </footer>
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>