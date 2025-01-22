<?php
require_once('../config/database.php');
$koneksi = Database::getInstance()->getConnection();

// Periksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Nama file Excel
$filename = "pengguna_excel-(" . date('d-m-Y') . ").xls";

// Header untuk mendownload file Excel
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: application/vnd.ms-excel");

?>

<!DOCTYPE html>
<html>

<head>
    <title>Laporan Pengguna</title>
</head>

<body>
    <h2>Laporan Pengguna</h2>

    <table border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Nama Lengkap</th>
                <th>Level</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;

            $sql = $koneksi->query("SELECT * FROM tb_user");

            while ($data = $sql->fetch_assoc()) {
            ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $data['username']; ?></td>
                    <td><?php echo $data['nama']; ?></td>
                    <td><?php echo $data['level']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>

</html>