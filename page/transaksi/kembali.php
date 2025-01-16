<?php

$id_transaksi = $_GET['id_transaksi'];
$id_buku = $_GET['id_buku'];

$koneksi->query("UPDATE tb_transaksi SET status='kembali' WHERE id='$id_transaksi'");
$koneksi->query("UPDATE tb_buku SET jumlah_buku = (jumlah_buku + 1) WHERE id='$id_buku'");

// Tidak langsung menggunakan header untuk redirect
echo '<script type="text/javascript">
    alert("Proses Kembalikan Buku Berhasil");
    window.location.href = "?page=transaksi";
</script>';
exit();
