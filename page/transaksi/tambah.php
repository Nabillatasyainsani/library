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
                            <option value="">Pilih Buku</option>
                            <?php
                            // Ambil data buku dari database
                            $sql_buku = $koneksi->query("SELECT id, judul FROM tb_buku WHERE jumlah_buku > 0");
                            while ($data_buku = $sql_buku->fetch_assoc()) {
                                echo "<option value='" . $data_buku['id'] . "'>" . $data_buku['judul'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Peminjam</label>
                        <select class="form-control" name="id_anggota" required>
                            <option value="">Pilih anggota</option>
                            <?php
                            // Ambil data buku dari database
                            $sql_anggota = $koneksi->query("SELECT id, nama FROM tb_anggota");
                            while ($data_anggota = $sql_anggota->fetch_assoc()) {
                                echo "<option value='" . $data_anggota['id'] . "'>" . $data_anggota['nama'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tanggal Pinjam</label>
                        <input class="form-control" name="tgl_pinjam" type="date" value="<?php echo date('Y-m-d'); ?>" readonly />
                    </div>

                    <div class="form-group">
                        <label>Tanggal Kembali</label>
                        <input class="form-control" name="tgl_kembali" value="<?php echo date('Y-m-d', strtotime('+7 days')); ?>" type="date" readonly />
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

    // Validasi ID User
    // $id_user = isset($_SESSION['user']) ? $_SESSION['user'] : $_SESSION['admin'];

    // Cek jumlah buku yang tersedia
    $sql_cek_buku = $koneksi->query("SELECT jumlah_buku FROM tb_buku WHERE id = '$id_buku'");
    $data_buku = $sql_cek_buku->fetch_assoc();

    if ($data_buku['jumlah_buku'] <= 0) {
        echo "<script>alert('Buku tidak tersedia!');</script>";
    } else {
        // Tambah data transaksi
        try {
            $sql_transaksi = $koneksi->query("INSERT INTO tb_transaksi (id_user, id_buku, tgl_pinjam, tgl_kembali, status)
                                          VALUES ('$id_anggota', '$id_buku', STR_TO_DATE('$tgl_pinjam', '%Y-%m-%d'), STR_TO_DATE('$tgl_kembali', '%Y-%m-%d'), 'Dipinjam')");
        if ($sql_transaksi) {
            // Kurangi jumlah buku
            $koneksi->query("UPDATE tb_buku SET jumlah_buku = jumlah_buku - 1 WHERE id = '$id_buku'");
            echo "<script>alert('Transaksi berhasil disimpan!'); window.location.href='?page=transaksi';</script>";
        } else {
            echo "<script>alert('Transaksi gagal disimpan!');</script>";
        }
        } catch (\Throwable $th) {
            echo "<script>alert('Transaksi gagal disimpan!');</script>";
        }
    }
}
?>
