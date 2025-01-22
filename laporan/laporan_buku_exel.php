<?php
require_once('../config/database.php');
$koneksi = Database::getInstance()->getConnection();

// Nama file Excel
$filename = "anggota_excel-(" . date('d-m-Y') . ").xls";

// Header untuk mendownload file Excel
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: application/vnd.ms-excel");

?>

<!DOCTYPE html>
<html>

<head>
    <title>Laporan Buku</title>
</head>

<body>
    <h2>Laporan Buku</h2>

    <table border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Pengarang</th>
                <th>Penerbit</th>
                <th>ISBN</th>
                <th>Tahun Terbit</th>
                <th>Jumlah Buku</th>
                <th>Lokasi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;

            $sql = $koneksi->query("select * from tb_buku");

            while ($data = $sql->fetch_assoc()) {

            ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $data['judul']; ?></td>
                    <td><?php echo $data['pengarang']; ?></td>
                    <td><?php echo $data['penerbit']; ?></td>
                    <td><?php echo $data['isbn']; ?></td>
                    <td><?php echo $data['tahun_terbit']; ?></td>
                    <td><?php echo $data['jumlah_buku']; ?></td>
                    <td><?php echo $data['lokasi']; ?></td>
                    <td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>

</html>