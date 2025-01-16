<?php

// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "db_perpustakaan");

// Periksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Nama file Excel
$filename = "anggota_excel-(" . date('d-m-Y') . ").xls";

// Header untuk mendownload file Excel
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: application/vnd.ms-excel");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Anggota</title>
</head>
<body>
    <h2>Laporan Anggota</h2>

    <table border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>NISN</th>
                <th>Nama</th>
                <th>Tempat Lahir</th>
                <th>Tanggal Lahir</th>
                <th>Jenis Kelamin</th>
                <th>Kelas</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $sql = $koneksi->query("SELECT * FROM tb_anggota");
            while ($data = $sql->fetch_assoc()) {
                // Tentukan jenis kelamin
                $jk = ($data['jk'] == "L") ? "Laki-laki" : "Perempuan";
            ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $data['nisn']; ?></td>
                <td><?php echo $data['nama']; ?></td>
                <td><?php echo $data['tempat_lahir']; ?></td>
                <td><?php echo $data['tgl_lahir']; ?></td>
                <td><?php echo $jk; ?></td>
                <td><?php echo $data['kelas']; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
