<div class="panel panel-default">
    <div class="panel-heading">
        Tambah Transaksi
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <form method="POST">
                    <div class="form-group">
                        <label>Judul Buku</label>
                        <select class="form-control" name="id_buku" required>
                            <option value="">-- Pilih Buku --</option>
                            <?php
                                $sql_buku = $koneksi->query("SELECT * FROM tb_buku WHERE jumlah_buku > 0");
                                while ($buku = $sql_buku->fetch_assoc()) {
                                    echo "<option value='{$buku['id']}'>{$buku['judul']}</option>";
                                }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Nama Anggota</label>
                        <select class="form-control" name="id_anggota" required>
                            <option value="">-- Pilih Anggota --</option>
                            <?php
                                $sql_anggota = $koneksi->query("SELECT * FROM tb_anggota");
                                while ($anggota = $sql_anggota->fetch_assoc()) {
                                    echo "<option value='{$anggota['id']}'>{$anggota['nisn']} - {$anggota['nama']}</option>";
                                }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tanggal Pinjam</label>
                        <input type="date" class="form-control" name="tgl_pinjam" value="<?php echo date('Y-m-d'); ?>" readonly required>
                    </div>

                    <div class="form-group">
                        <label>Tanggal Kembali</label>
                        <input type="date" class="form-control" name="tgl_kembali" value="<?php echo date('Y-m-d', strtotime('+7 days')); ?>" readonly required>
                    </div>

                    <div>
                        <input type="submit" name="simpan" value="Simpan" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['simpan'])) {
    $id_buku = $_POST['id_buku'];
    $id_anggota = $_POST['id_anggota'];
    $tgl_pinjam = $_POST['tgl_pinjam'];
    $tgl_kembali = $_POST['tgl_kembali'];
    $status = "pinjam";

    // Kurangi jumlah buku
    $sql_update_buku = $koneksi->query("UPDATE tb_buku SET jumlah_buku = jumlah_buku - 1 WHERE id = '$id_buku'");

    if ($sql_update_buku) {
        // Simpan transaksi
        $sql_transaksi = $koneksi->query("INSERT INTO tb_transaksi (id_buku, id_anggota, tgl_pinjam, tgl_kembali, status)
                                          VALUES ('$id_buku', '$id_anggota', '$tgl_pinjam', '$tgl_kembali', '$status')");
        if ($sql_transaksi) {
            echo "<script>alert('Transaksi Berhasil Disimpan'); window.location.href='?page=transaksi';</script>";
        } else {
            echo "<script>alert('Transaksi Gagal Disimpan');</script>";
        }
    } else {
        echo "<script>alert('Gagal Mengupdate Jumlah Buku');</script>";
    }
}
?>
