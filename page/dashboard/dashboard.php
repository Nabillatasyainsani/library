<?php
// Pastikan session sudah dimulai sebelumnya
if (!isset($_SESSION['admin']) && !isset($_SESSION['user'])) {
    header("location:login.php");
    exit;
}

$level = isset($_SESSION['admin']) ? 'admin' : 'user';

// Query data untuk admin
if ($level === 'admin') {
    // Query jumlah anggota
    $sql_anggota = $koneksi->query("SELECT * FROM tb_anggota");
    $jml_anggota = $sql_anggota->num_rows;

    // Query jumlah buku
    $sql_buku = $koneksi->query("SELECT * FROM tb_buku");
    $jml_buku = $sql_buku->num_rows;

    // Query jumlah transaksi (status = Dipinjam)
    $sql_transaksi = $koneksi->query("SELECT * FROM tb_transaksi WHERE status='Dipinjam'");
    $jml_transaksi = $sql_transaksi->num_rows;

    // Query jumlah pengguna
    $sql_user = $koneksi->query("SELECT * FROM tb_user");
    $jml_user = $sql_user->num_rows;
} else {
    // Untuk user biasa, hanya tampilkan transaksi mereka sendiri
    $id_user = $_SESSION['user']; // Ambil ID pengguna yang sedang login
    $user = $koneksi->query("SELECT id_anggota FROM tb_user WHERE id='$id_user'")->fetch_assoc();
    $id_anggota = $user['id_anggota'];
    $sql_transaksi_user = $koneksi->query("SELECT * FROM tb_transaksi WHERE status='Dipinjam' AND id_user='$id_anggota'");
    $jml_transaksi = $sql_transaksi_user->num_rows;

    // Query jumlah buku yang tersedia (buku yang tidak dipinjam)
    $sql_buku_tersedia = $koneksi->query("SELECT * FROM tb_buku WHERE id NOT IN (SELECT id_buku FROM tb_transaksi WHERE status='pinjam')");
    $jml_buku = $sql_buku_tersedia->num_rows;

    // Jangan tampilkan jumlah anggota dan pengguna untuk user
    $jml_anggota = null;
    $jml_user = null;
}
?>
<link rel="stylesheet" href="assets/css/font-awesome.min.css" />
<div class="row">
    <?php if ($level === 'admin'): ?>
    <div class="col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading" style="height: 100px;">
                <i class="fa fa-user fa-5x pull-left" style="font-size: 5em;width: 30%;"></i>
                <div style="margin-left: 30%;">Jumlah Anggota</div>
            </div>
            <div class="panel-body">
                <h1><?php echo $jml_anggota; ?></h1>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="col-md-6">
        <div class="panel panel-success">
            <div class="panel-heading" style="height: 100px;">
                <i class="fa fa-book fa-5x pull-left" style="font-size: 5em;width: 30%;"></i>
                <div style="margin-left: 30%;">Jumlah Buku Tersedia</div>
            </div>
            <div class="panel-body">
                <h1><?php echo $jml_buku; ?></h1>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel panel-info">
            <div class="panel-heading" style="height: 100px;">
                <i class="fa fa-exchange fa-5x pull-left" style="font-size: 5em;width: 30%;"></i>
                <div style="margin-left: 30%;">Jumlah Transaksi</div>
            </div>
            <div class="panel-body">
                <h1><?php echo $jml_transaksi; ?></h1>
            </div>
        </div>
    </div>

    <?php if ($level === 'admin'): ?>
    <div class="col-md-6">
        <div class="panel panel-danger">
            <div class="panel-heading" style="height: 100px;">
                <i class="fa fa-users fa-5x pull-left" style="font-size: 5em;width: 30%;"></i>
                <div style="margin-left: 30%;">Jumlah Pengguna</div>
            </div>
            <div class="panel-body">
                <h1><?php echo $jml_user; ?></h1>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
