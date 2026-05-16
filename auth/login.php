<?php
include '../config/database.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['id_user'] = $user['id_user'];
         $_SESSION['nama'] = $user['nama'];
          $_SESSION['role'] = $user['role'];

          if ($user['role'] == 'admin') {
            header("Location: ../admin/index.php");
          } else if ($user['role'] == 'guru') {
            header("Location: ../guru/index.php");
          } else {
            header("Location: ../siswa/index.php");
          }
    } else {
        $error = "username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> AKSARA+ - Literasi Digital </title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=public+Sans:ital,wght@0,700;0,900;1,400&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" rel="stylesheet">
    <link href="../assets/style.css" rel="stylesheet">
</head>

<body class="login-container">
    <div class="container">
        <div class="row justify-content-center">
        <div class="col-md-5 col-lg-6">

            <div class="text-center mb-4">
                <!-- css didie hoream muka css --rantiw -->
                <h1 class="fw-black" style="font-size: 3rem; -webkit-text-stroke: 1px black; color: white; text-shadow: 5px 5px 0px var(--dark);">AKSARA+</h1>
                <span class="badge-comic">Aksi kritis saring ragam informasi digital</span>
            </div>

            <div class="comic-border bg-white p-4 p-md-5">
                <h3 class="fw-black text-center mb-4 uppercase"> MASUK SEKARANG</h3>
                <?php if (isset($error)): ?>
                <div class="alert alert-comic mb-4 py-2 small text-center">
                    <?=  $error ?>
                </div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="fw-bold mb-1">USERNAME</label>
                        <input type="text" name="username" class="form-control comic-input" placeholder="masukkan username..." required>
                    </div>
                    <div class="mb-4">
                        <label class="fw-bold mb-1">PASSWORD</label>
                        <input type="password" name="password" class="form-control comic-input" placeholder="******" required>
                    </div>
                    <button type="submit" name="login" class="btn btn-warning comic-btn w-100 py-3">
                        GAS MASUK! <i class="fa-brands fa-space-awesome"></i>
                    </button>
                </form>

                <div class="text-center mt-4">
                    <a href="../index.php" class="text-dark small fw-bold texr-decoration-none">← Kembali ke beranda</a>
            </div>
            </div>
            <p class="text-center mt-4 small fw-bold opacity-75">@ 2026 AKSARA+ SMKDM</p>
        </div>
    </div>
    </div>
</body>
</html>