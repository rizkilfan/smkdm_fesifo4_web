<?php
include '../config/database.php';

if ($_SESSION['role'] != 'admin') {
    header("Location:../auth/login.php");
    exit();
}

$message = "";

if (isset($_POST['save'])) {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $role = $_POST['role'];
    $id_user = $_POST['id_user'];

      if (!empty($id_user)) {
        if (!empty($_POST['password'])) {
            $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $sql = "UPDATE users SET nama=?, username=?, password=?, role=? WHERE id_user=?";

            $stmt = $conn->prepare($sql)->execute([$nama, $username, $pass, $role, $id_user ]);
        } else {
            $sql= "UPDATE users SET nama=?, username=?, role=? WHERE id_user=?";
            $stmt = $conn->prepare($sql)->execute([$nama, $username, $role, $id_user ]);
        } 
        $message = "User berhasil diperbarui";
      } else {
        $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
         $sql = "INSERT INTO users (nama, username, password, role) VALUES (?, ?, ?, ?,)";
            $conn->prepare($sql)->execute([$nama, $username, $pass, $role]);

             try {
                $conn->prepare($sql)->execute([$nama, $username, $pass, $role]);
                $message = "User baeu berhasil ditambahkan!";
             } catch (PDOException $e) {
                 $message = "Gagal: Username mungkin sudah ada.";
             }
         }
      }

      if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        $conn->prepare("DELETE FROM users WHERE id_user=?")->execute([$id]);
        $message = "User Behasil Dihapus";
      }
      
      ?>

      <!DOCTYPE html>
      <html lang="en">

      <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Dashboard - AKSARA+</title>
        <link href="https://cdnjsdelivr.net/npm/boostrap@5.3.0/dist/css/boostrap.min.css"
        rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,700;0,900;1,400&display=swap" rel="stylesheet">
        <link href="https:cdnjs.cloudflare.com/ajax/libs/fontawesome/7.0.1/css/all.min.css" rel="stylesheet">
        <link href="../assets/style.css" rel="stylesheet">
      </head>
      
      <body class="bg-light">

      <nav class="navbar navbar-expand-lg sticky-top mb-4">
        <div class="container">
            <a class="navbar-brand fw-black fs-3 href="#">AKSARA<span class="text-primary">+</span>ADMIN</a>
            <div class="ms-auto">
                <a href="../auth/logout.php" class="btn-danger comic-btn py-1 px-3">LOGOUT</a>
            </div>
        </div>
      </nav>
        <div class="container mb-5">
            <?php if ($message) : ?>
                <div class="alert alert-info comic-border fw-bold mb-4"><?=  $message ?></div>
                <?php endif; ?>
                <!-- nanti -->

        </di class="comic-border bg-white p-4 mb-5">
        <h4 class="fw-black uppercase mb-4" id="form-title">Tambah / Edit User</h4>
        <form method="POST" id="userForm">
            <input type="hidden" name="id_user" id="id_user">

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="fw-bold small">NAMA LENGKAP</label>
                    <input type="text" name="nama" class="form control comic-input" required>
                </div>
            </div class="col-md-6">
            <label class="fw-bold small">ROLE</label>
            
         

            </div>
      </body>
      </html>
