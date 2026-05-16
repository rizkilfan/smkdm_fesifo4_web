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
         $sql = "INSERT INTO users (nama, username, password, role) VALUES (?, ?, ?, ?)";
            

             try {
                $conn->prepare($sql)->execute([$nama, $username, $pass, $role]);
                $message = "User baru berhasil ditambahkan!";
             } catch (PDOException $e) {
                 $message = "Gagal: Username mungkin sudah ada.";
             }
         }
      }

      if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        $conn->prepare("DELETE FROM users WHERE id_user=?")->execute([$id]);
        $message = "User Berhasil Dihapus";
      }
      
      ?>

      <!DOCTYPE html>
      <html lang="id">

      <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Dashboard - AKSARA+</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,700;0,900;1,400&display=swap" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" rel="stylesheet">
        <link href="../assets/style.css" rel="stylesheet">
      </head>
      
      <body class="bg-light">

      <nav class="navbar navbar-expand-lg sticky-top mb-4">
        <div class="container">
            <a class="navbar-brand fw-black fs-3" href ="#">AKSARA<span class="text-primary">+</span>ADMIN</a>
            <div class="ms-auto">
                <a href="../auth/logout.php" class="btn btn-danger comic-btn py-1 px-3">LOGOUT</a>
            </div>
        </div>
      </nav>
        <div class="container mb-5">
            <?php if ($message) : ?>
                <div class="alert alert-info comic-border fw-bold mb-4"><?=  $message ?></div>
                <?php endif; ?>
                <!-- huuuuuuuuuuuuu almak bingungggggggg -->

        <div class="comic-border bg-white p-4 mb-5">
        <h4 class="fw-black uppercase mb-4" id="form-title">Tambah / Edit User</h4>
        <form method="POST" id="userForm">
            <input type="hidden" name="id_user" id="id_user">

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="fw-bold small">NAMA LENGKAP</label>
                    <input type="text" name="nama" id="nama" class="form-control comic-input" required>
                </div>
            <div class="col-md-6">
            <label class="fw-bold small">ROLE</label>
            <select name="role" id="role" class="form-select comic-input" required>
                <option value="siswa">SISWA</option>
                <option value="guru">GURU</option>
                <option value="admin">ADMIN</option>  
            </select>
            </div>
            <div class="col-md-6">
            <label class="fw-bold small">USERNAME</label>
            <input type="text" name="username" id="username" class="form-control comic-input" required>
            </div>
            <div class="col-md-6">
                <label class="fw-bold small">PASSWORD (isi jika ingin)</label>
                <input type="password" name="password" id="password" class="form-control comic-input">
            </div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button type="submit" name="save" class="btn btn-warning comic-btn px-4">SIMPAN DATA</button>
                <button type="button" onclick="resetForm()" class="btn btn-light comic-border px-4 fw-bold">RESET</button>
            </div>
            </form>
            </div>
            <h4 class="fw-black uppercase mb-3">Daftar Pengguna</h4>
            <div class="comic-border bg-white overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th class="ps-4">NAMA</th>
                                <th>USERNAME</th>
                                <th>ROLE</th>
                                <th class="text-center">AKSI</th>
                            </tr>
            </thead>
            <tbody>
                <?php
                $users = $conn->query("SELECT * FROM users ORDER BY role ASC, nama ASC");
                while ($u = $users->fetch()):
                    ?>
                    <tr class="align-middle">
                        <td class="ps-4 fw-bold"><?=htmlspecialchars($u['nama']) ?></td>
                        <td><code><?= htmlspecialchars($u['username']) ?></code></td>
                        <td>
                            <span class="badge badge-status bg-info text-dark" style="font-size: 0.7rem;">
                                <?=  strtoupper($u['role']) ?>
                            </span>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-dark fw-black me-2"
                            onclick="fillForm('<?= $u['id_user'] ?>','<?= $u['nama'] ?>','<?= $u['username'] ?>','<?= $u['role'] ?>')">
                            EDIT</button>
                            <a href="?delete=<?=  $u['id_user'] ?>"
                            class="btn btn-sm btn-danger comic-btn py-0"
                            onclick="return confirm('Hapus user ini?')">HAPUS</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
            </tbody>
                    </table>
                </div>
                </div>
                </div>

                <footer class="py-4">
                    <div class="container text-center text-white small fw-black uppercase">
                        AKSARA+ ADMIN PANEL
                    </div>
                </footer>

                <!-- GTW KM LIAT SNDRI AJA INI -->
                 <script>
                    function fillForm(id, nama, username, role) {
                        document.getElementById('id_user').value = id;
                        document.getElementById('nama').value = nama;
                        document.getElementById('username').value = username;
                        document.getElementById('role').value = role;
                        document.getElementById('form-title').innerText = "Edit User: " + nama;
                        document.getElementById('password').placeholder = "Kosongkan jika tidak ganti ";
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                    }

                    function resetForm() {
                        document.getElementById('userForm').reset();
                        document.getElementById('id_user').value = "";
                        document.getElementById('form-title').innerText = "Tambah / Edit User";
                        document.getElementById('password').placeholder = "";
                    }
                    </script>
                    </body>
      </html>

                
            
