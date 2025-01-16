<?php

$id = $_GET['id'];
$judul = $_GET['judul'];
$tgl_kembali = $_GET['tgl_kembali'];
$lambat = $_GET['lambat'];

if ($lambat > 7) {
    ?>
    <script type="text/javascript">
        alert("Pinjam Buku Tidak Dapat Diperpanjang, Karena lebih Dari 7 Hari. Kembalikan Dahulu Kemudian Pinjam Kembali!");
        window.location.href="?page=transaksi";
    </script>
    <?php
} else {
    // Mengonversi tanggal kembali ke format Y-m-d untuk manipulasi tanggal
    $pecah_tgl_kembali = explode("-", $tgl_kembali);
    if (count($pecah_tgl_kembali) == 3) {
        $next_7_hari = mktime(0, 0, 0, $pecah_tgl_kembali[1], $pecah_tgl_kembali[2] + 7, $pecah_tgl_kembali[0]);
        $hari_next = date("Y-m-d", $next_7_hari);

        // Update data transaksi dengan tanggal kembali baru
        $sql = $koneksi->query("UPDATE tb_transaksi SET tgl_kembali= '$hari_next' WHERE id='$id'");

        if ($sql) {
            ?>
            <script type="text/javascript">
                alert("Perpanjangan Berhasil");
                window.location.href="?page=transaksi";
            </script>
            <?php
        } else {
            ?>
            <script type="text/javascript">
                alert("Perpanjangan Gagal");
                window.location.href="?page=transaksi";
            </script>
            <?php
        }
    } else {
        ?>
        <script type="text/javascript">
            alert("Format tanggal kembali tidak valid.");
            window.location.href="?page=transaksi";
        </script>
        <?php
    }
}
?>
