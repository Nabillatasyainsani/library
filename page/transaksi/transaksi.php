<?php
session_start();
$koneksi = new mysqli("localhost", "root", "", "db_perpustakaan");

// Check if the user is logged in and the session exists
if (!isset($_SESSION['user']) && !isset($_SESSION['admin'])) {
    echo "<script>alert('You must be logged in to access this page.'); window.location.href='login.php';</script>";
    exit;
}

$is_admin = isset($_SESSION['admin']);
$id_user = isset($_SESSION['user']) ? $_SESSION['user'] : $_SESSION['admin'];
$user = $koneksi->query("SELECT * FROM tb_user WHERE id='$id_user'")->fetch_assoc();
$id_anggota = $user['id_anggota'];


$no = 1;

// Query to fetch all transactions
$sql;

if ($is_admin) {
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

?>

<div class="row">
    <div class="col-md-12">
        <!-- Advanced Tables -->
        <div class="panel panel-default">
            <div class="panel-heading">
                Data Transaksi
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
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
                                <?php if ($isAdmin) { ?>
                                    <th>Aksi</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($data = $sql->fetch_assoc()) {
                                // Calculate late days and penalty
                                $denda = 1000;
                                $tgl_kembali = date('Y-m-d');
                                $lambat = terlambat($data['tgl_kembali'], $tgl_kembali);
                                $denda1 = $lambat * $denda;
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
                                    <?php if ($isAdmin) { ?>
                                        <td>
                                            <a href="?page=transaksi&aksi=kembali&id_transaksi=<?= $data['id']; ?>&id_buku=<?= $data['id_buku']; ?>" class="btn btn-info">Kembali</a>
                                            <a href="?page=transaksi&aksi=perpanjang&id=<?= $data['id']; ?>&judul=<?= $data['judul']; ?>&lambat=<?= $lambat; ?>&tgl_kembali=<?= $data['tgl_kembali']; ?>" class="btn btn-danger">Perpanjang</a>
                                        </td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($isAdmin) { ?>
                    <a href="?page=transaksi&aksi=tambah" class="btn btn-primary" style="margin-top: 8px;">Tambah Data</a>
                    <a href="./laporan/laporan_transaksi_exel.php" target="blank" class="btn btn-default" style="margin-top: 8px;"><i class="fa fa-print"></i> ExportToExcel</a>
                <?php } ?>


            </div>
        </div>
    </div>
</div>