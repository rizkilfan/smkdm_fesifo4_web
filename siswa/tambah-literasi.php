<?php
include '../config/database.php';

if ($_SESSION['role'] != 'siswa') {
    header("Location: ../auth/login.php");
    exit();
}

if (isset($_POST['simpan'])) {
    $id_user = $_SESSION['id_user'];
    $judul = $_POST['judul'];
     $penulis = $_POST['penulis'];
      $ringkasan = $_POST['ringkasan'];
}

if (isset($_POST['simpan'])) {
    $id_user = $_SESSION['id_user'];
    $judul = $_POST['judul'];
    $penulis = $_POST['ringkasan'];

    $sql = "INSERT INTO submissions (id_user, judul_buku, penulis, ringkasan) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if ($stmt->execute([$id_user, $judul, $penulis, $ringkasan])) {
        echo "<script>alert('BOOM! Data literasi kamu berhasil terkirim!'); window.location='index.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loterasi - AKSARA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,700;0,900;1,400&display=swap" rel="stylesheet"> 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" rel="stylesheet">
    <link href="../assets/style.css" rel="stylesheet">

</head>
<body class="form-section">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                                <a href="index.php" class="text-dark fw-black text-decoration-none mb-3 d-inline-block">
                    ← KEMBALI KE DASHBOARD
                </a>
                 <div class="comic-border bg-white p-4 p-md-5">
                    <div class="text-center mb-4">
                  <h2 class="fw-black uppercase m-0" style="letter-spacing: -1px;">CATAT BACAANMU! <i class="fa-solid fa-pen-nib"></i></h2>
                  <div class="badge badge-comic mt-2">CERITAKAN APA YANG KAMU DAPAT</div>
                    </div>

                    <form method="POST">
                    <div class="mb-3">
                     <label class="fw-bold mb-1">JUDUL BUKU</label>
                    <input type="text" name="judul" class="form-control comic-input" placeholder="Contoh: Laskar Pelangi..." required>
                        </div>

                                                    <label class="fw-bold mb-1">RINGKASAN & HIKMAH</label>
                            <textarea name="ringkasan" class="form-control comic-input" rows="6" placeholder="Tuliskan intisari atau pelajaran berharga yang kamu petik..." required></textarea>
                            <!-- kata kata na bisi rek diubah.. urang teu bisa ngarang kata2.. --rangga -->
                            <div class="form-text fw-bold text-dark mt-2 small">
                                * Berikan ulasan terbaikmu
                            </div>
                        </div>

                        <div class="row g-2">
                            <div class="col-8">
                                <button type="submit" name="simpan" class="btn btn-warning comic-btn w-100 py-3">
                                    KIRIM SEKARANG! <i class="fa-solid fa-paper-plane"></i>
                                </button>
                            </div>
                            <div class="col-4">
                                <a href="index.php" class="btn btn-light comic-border w-100 py-3 fw-bold text-center text-decoration-none d-block">
                                    BATAL
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                                <p class="text-center mt-4 small fw-black opacity-50 uppercase">PASTIKAN DATA SUDAH BENAR SEBELUM MENGIRIM</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>