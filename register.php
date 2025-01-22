<?php
session_start();

require_once('config/database.php');
$koneksi = Database::getInstance()->getConnection();

// Proses Registrasi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Enkripsi password
    $nama = $_POST['nama'];
    $level = $_POST['level'];

    // Menyimpan data ke database
    $sql = "INSERT INTO tb_user (username, password, nama, level) VALUES ('$username', '$password', '$nama', '$level')";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = 'Pendaftaran berhasil!';
        header('Location: login.php');
        exit;
    } else {
        echo "<script>alert('Gagal mendaftar. Silakan coba lagi.');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Registrasi</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }

        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="card-header text-center">Registrasi Akun</div>
        <div class="card-body">
            <form action="register.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="username">Nama Pengguna:</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Kata Sandi:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="nama">Nama Lengkap:</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
                <div class="form-group">
                    <label for="level">Level:</label>
                    <select class="form-control" id="level" name="level" required>
                        <option value="user">User</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Daftar</button>
            </form>
            <?php if (isset($_SESSION['message'])) {
                echo "<p class='text-center mt-3'>" . $_SESSION['message'] . "</p>";
                unset($_SESSION['message']);
            } ?>
        </div>
    </div>
</body>

</html>