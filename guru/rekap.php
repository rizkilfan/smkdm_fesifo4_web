<?php
include '../config/database.php';

if ($_SESSION['role'] != 'guru') {
    header ("Location: ../auth/login.php");
    exit();

}

$query = $conn->query("SELECT s.*, u.nama FROM submissions s JOIN users u ON s.id_user = u.id_user ORDER BY s.tanggal_input DESC");
?>

<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Rekapitulasi Data - Aksara+</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,700;0,900;1,400&display=swap" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" rel="stylesheet">
        <link href="../assets/style.css" rel="stylesheet">
    </head>
    <body class="bg-light">

    <nav class="navbar navbar-expand-lg sticky-top mb-4">
        <div class="container">
        
<a class="navbar-brand fw-black fs-3" href="index.php">AKSARA<span class="text-primary">+</span> REKAP</a>
<div class="ms-auto">
    <a href="index.php" class="btn btn-dark comic-btn py-1 px-3" style="font-size: 0.8rem;"> KEMBALI</a>
</div>
</div>
    </nav>

    <div class="container mb-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div>
        <h2 class="fw-black uppercase m-0">Seluruh Data Literasi</h2>
                <p class="fw-bold text-muted mb-0">Total arsip: <?= $query->rowCount() ?> laporan ditemukan.</p>
            </div>
            <div class="mt-3 mt-md-0">
<!-- kita pake cetak aja yaa ga..... biar langsung di print nya lewat browser.. jadi ga perlu pake library mpdf... males hehe --titiww-->

                <button onclick="window.print()" class="btn btn-info comic-btn fw-black">PRINT REKAP <i class="fa-solid fa-print"></i>
            </button>
            </div>
        </div>

        <div class="comic-border bg-white overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-4 py-3">TANGGAL</th>
                            <th class="py-3">NAMA SISWA</th>
                            <th class="py-3">JUDUL BUKU / PENULIS</th>
                            <th class="py-3 text-center">STATUS</th>
                            <th class="py-3">CATATAN GURU</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $query->fetch()): ?>
                        <tr class="align-middle">
                            <td class="ps-4 fw-bold small">
                                <?= date('d M Y', strtotime($row['tanggal_input'])) ?>
                            </td>
                            <td>
                                <div class="fw-black text-primary uppercase"><?= htmlspecialchars($row['nama']) ?></div>
                            </td>
                            <td>
                                <div class="fw-bold m-0"><?= htmlspecialchars($row['judul_buku']) ?></div>
                                <div class="small text-muted font-italic"><?= htmlspecialchars($row['penulis']) ?></div>
                            </td>
                            <td class="text-center">
                                <?php if($row['status'] == 'pending'): ?>
                                    <span class="badge badge-status" style="background-color: var(--warning-comic); color: black;">PENDING</span>
                                <?php elseif($row['status'] == 'disetujui'): ?>
                                    <span class="badge badge-status" style="background-color: var(--success-comic); color: black;">SETUJU</span>
                                <?php else: ?>
                                    <span class="badge badge-status" style="background-color: var(--danger-comic); color: white;">TOLAK</span>
                                <?php endif; ?>
                            </td>
                            <td class="pe-4">
                                <div class="small fw-bold text-muted" style="max-width: 200px; word-wrap: break-word;">
                                    <?= $row['catatan_guru'] ? htmlspecialchars($row['catatan_guru']) : "-" ?>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>

                        <?php if($query->rowCount() == 0): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <h4 class="fw-black text-muted">BELUM ADA DATA UNTUK DIREKAP 📁</h4>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            <a href="index.php" class="text-dark fw-black text-decoration-none uppercase">
                ← Kembali ke Dashboard Utama
            </a>
        </div>
    </div>

    <footer class="py-4 mt-5">
        <div class="container text-center text-white small fw-black uppercase">
            AKSARA+ ARSIP
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
