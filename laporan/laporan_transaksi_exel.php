<?php
include '../function.php';
require_once('../config/database.php');
$koneksi = Database::getInstance()->getConnection();

// Koneksi ke database
$koneksi = new mysqli("localhost:8889", "root", "root", "db_perpustakaan");

// Periksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Nama file Excel
$filename = "transaksi_excel-(" . date('d-m-Y') . ").xls";

// Header untuk mendownload file Excel
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: application/vnd.ms-excel");

?>

<!DOCTYPE html>
<html>

<head>
    <title>Laporan Transaksi</title>
</head>

<body>
    <h2>Laporan Transaksi</h2>

    <table border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Peminjam</th>
                <th>NISN</th>
                <th>Judul</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Terlambat</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $sql;

            $id_user = $_GET['id_user'];
            $id_admin = $_GET['id_admin'];
            $user = $koneksi->query("SELECT * FROM tb_user WHERE id='$id_user'")->fetch_assoc();
            $id_anggota = $user['id_anggota'];

            if ($id_admin) {
                $sql = $koneksi->query("SELECT tb_transaksi.id as id, tb_buku.id as id_buku, tgl_pinjam, judul, tgl_kembali, status, nama, nisn FROM tb_transaksi
        JOIN tb_buku ON tb_transaksi.id_buku = tb_buku.id
        JOIN tb_anggota ON tb_anggota.id = tb_transaksi.id_user
        WHERE status='Dipinjam'
        ");
            } else {
                $sql = $koneksi->query("SELECT tb_transaksi.id as id, tb_buku.id as id_buku, tgl_pinjam, judul, tgl_kembali, status, nama, nisn FROM tb_transaksi 
        JOIN tb_buku ON tb_transaksi.id_buku = tb_buku.id
        JOIN tb_anggota ON tb_anggota.id = tb_transaksi.id_user
        WHERE status='Dipinjam' AND id_user='$id_anggota'
        ");
            }

            $data = $sql->fetch_assoc();

            try {
                while ($data = $sql->fetch_assoc()) {
            ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $data["nama"]; ?></td>
                        <td><?php echo $data["nisn"]; ?></td>
                        <td><?php echo $data["judul"]; ?></td>
                        <td><?php echo $data['tgl_pinjam']; ?></td>
                        <td><?php echo $data['tgl_kembali']; ?></td>
                        <td>
                            <?php
                            $denda = 1000;
                            $tgl_dateline2 = $data['tgl_kembali'];
                            $tgl_kembali = date('Y-m-d');
                            $lambat = terlambat($tgl_dateline2, $tgl_kembali);
                            $denda1 = $lambat * $denda;

                            if ($lambat > 0) {
                                echo "<font color='red'>$lambat hari (Rp " . number_format($denda1, 0, ',', '.') . ")</font>";
                            } else {
                                echo $lambat . " Hari";
                            }
                            ?>
                        </td>
                        <td><?php echo $data['status']; ?></td>
                    </tr>
            <?php
                }
            } catch (Error $e) {
                var_dump($e);
            }
            ?>
        </tbody>
    </table>
</body>

</html>