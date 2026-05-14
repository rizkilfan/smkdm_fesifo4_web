<?php
include '../config/database.php';

if ($_SESSION['role'] != 'siswa') {
    header("Location: ../auth/login.php");
    exit();
}

$id_user = $_SESSION['id_user'];

$stmt = $conn->prepare("SELECT COUNT(*) as total, SUM(CASE WHEN status= 'disetujui' THEN 1 ELSE 0 END) as approved, SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending FROM submissions WHERE id_user = ?");
$stmt->execute([$id_user]);
$stat = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa - AKSARA</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,700;0,900;1,400&display=swap" rel="stylesheet">
            <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" rel="stylesheet">
            <link href="../assets/style.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg sticky-top mb-4">
    <div class="container">
        <a class="navbar-brand fw-black fs-3" href="#">AKSARA<span class="text-primary">+</span> SISWA</a>
        <div class="ms-auto">
            <span class="fw-bold me-3 d-none d-md-inline">Halo, <?= $_SESSION['nama'] ?>! <i class="fa-solid fa-hand-spock"></i></span>
                            <a href="../auth/logout.php" class="btn btn-danger comic-btn py-1 px-3" style="font-size: 0.8rem;">LOGOUT</a>
        </div>
    </div>
</nav>
    
<div class="container">
<!--  nanti ah isinya-->
  <div class="row g-4 mb-5">
    <div class="col-md-4">
        <div class="comic-border info-card text-center" style="background-color: var(--white);">
        <h6 class="fw-black text-uppercase small">Total Kirim</h6>
        <h1 class="fw-black m-0" style="font-size: 3.5rem;"><?= $stat['total'] ?? 0 ?></h1>
    </div>
</div>
<div class="col-md-4">
                    <div class="comic-border info-card text-center" style="background-color: var(--success-comic);">
                        <h6 class="fw-black text-uppercase small">Disetujui</h6>
                        <h1 class="fw-black m-0" style="font-size: 3.5rem;"><?=  $stat['approved'] ?? 0 ?></h1>
                    </div>
</div>
<div class="col-md-4">
                <div class="comic-border info-card text-center" style="background-color: var(--primary-bg);">
                    <h6 class="fw-black text-uppercase small">Menunggu</h6>
                    <h1 class="fw-black m-0" style="font-size: 3.5rem;"><?= $stat['pending'] ?? 0 ?></h1>
                </div>
            </div>
        </div>

        <div class="comic-border bg-white overflow-hidden mb-5">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-4 py-3 text-center">JUDUL BUKU</th>
                            <th class="ps-3 text-center">TANGGAL</th>
                            <th class="ps-3 text-center">STATUS</th>
                            <th class="ps-3 text-center">CATATAN GURU</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- -->
                    <?php
                    $query = $conn->prepare("SELECT * FROM submissions WHERE id_user = ? ORDER BY tanggal_input DESC");
                    $query->execute([$id_user]);
                    $has_data = false;
                    while($row = $query->fetch()):
                    $has_data = true;
                    ?>
                    <tr class="align-middle">
                        <td class="ps-4 py-3">
                         <div class="fw-black text-uppercase"><?= htmlspecialchars($row['judul_buku']) ?></div>
                         <div class="small fw-bold text-muted"><?=  htmlspecialchars($row['penulis']) ?></div>
                        </td>
                        <td class="fw-bold"><?= date('d/m/y', strtotime($row['tanggal_input'])) ?></td>
                        <td class="text-center">
                             <?php if($row['status'] == 'pending'): ?>
                              <span class="badge badge-status" style="background-color: var(--warning-comic); color: black;">PENDING</span>
                              <?php elseif($row['status'] == 'disetujui'): ?>
                                  <span class="badge badge-status" style="background-color: var(--success-comic); color: black;">DISETUJUI</span>
                                  <?php else: ?>
                                    <span class="badge badge-status" style="background-color: var(--danger-comic); color: white;">DITOLAK</span>
                                    <?php endif; ?>
                        </td>
                        <td class="ps-4 py-3"><div class="small fw-bold text-muted" style="white-space: normal; word-break: break-word;"><?=  $row['catatan_guru'] ? htmlspecialchars($row['catatan_guru']) : "-" ?></div>
                    </td>
                    </tr>
                    <?php endwhile; ?>
                    <?php if(!$has_data): ?>
                        <tr>
                            <td colspan="3" class="text-center py-5">
                                <h5 class="fw-bold text-muted">Belum ada data. Ayo Mulai Membaca! </h5>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
</div>

<footer class="py-4">
    <div class="container text-center">
        <p class="small fw-black m-0 text-white">AKSARA + SISWA PANEL</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>