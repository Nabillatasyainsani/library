<?php
$id = $_GET['id'];
$sql = $koneksi->query("DELETE FROM tb_user WHERE id='$id'");
if ($sql) {
    echo "<script>alert('Data Berhasil Dihapus'); window.location.href='?page=pengguna';</script>";
} else {
    echo "<script>alert('Data Gagal Dihapus');</script>";
}
