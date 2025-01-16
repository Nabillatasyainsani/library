<div class="panel panel-default">
    <div class="panel-heading">
        Tambah Data
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <form method="POST">
                    <div class="form-group">
                        <label>Judul</label>
                        <input class="form-control" name="judul" required maxlength="500" />
                    </div>

                    <div class="form-group">
                        <label>Pengarang</label>
                        <input class="form-control" name="pengarang" required maxlength="200" />
                    </div>

                    <div class="form-group">
                        <label>Penerbit</label>
                        <input class="form-control" name="penerbit" required maxlength="200" />
                    </div>

                    <div class="form-group">
                        <label>Tahun Terbit</label>
                        <input class="form-control" name="tahun" required type="number" max="<?= date("Y"); ?>" />
                    </div>

                    <div class="form-group">
                        <label>ISBN</label>
                        <input class="form-control" name="isbn" required maxlength="50" pattern="[0-9]{1,50}" />
                    </div>

                    <div class="form-group">
                        <label>Jumlah Buku</label>
                        <input class="form-control" type="number" name="jumlah" required min="1" max="50" />
                    </div>

                    <div class="form-group">
                        <label>Lokasi</label>
                        <select class="form-control" name="lokasi" required>
                            <option value="rak 1">Rak 1</option>
                            <option value="rak 2">Rak 2</option>
                            <option value="rak 3">Rak 3</option>
                            <option value="rak 4">Rak 4</option>
                            <option value="rak 5">Rak 5</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tanggal Input</label>
                        <input class="form-control" name="tanggal" type="date" required />
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
    $judul = $_POST['judul'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];
    $tahun = $_POST['tahun'];
    $isbn = $_POST['isbn'];
    $jumlah = $_POST['jumlah'];
    $lokasi = $_POST['lokasi'];
    $tanggal = $_POST['tanggal'];

    // Cek apakah ISBN sudah ada di database
    $sql_check = $koneksi->query("SELECT * FROM tb_buku WHERE isbn = '$isbn'");
    $exists = $sql_check->num_rows;

    if ($exists > 0) {
        // Jika ISBN sudah ada
        echo "<script>alert('Data dengan ISBN tersebut sudah ada!'); window.location.href='?page=buku&aksi=tambah';</script>";
    } else {
        // Jika ISBN belum ada, simpan data
        $sql = $koneksi->query("INSERT INTO tb_buku (judul, pengarang, penerbit, tahun_terbit, isbn, jumlah_buku, lokasi, tgl_input)
                                VALUES ('$judul', '$pengarang', '$penerbit', '$tahun', '$isbn', '$jumlah', '$lokasi', '$tanggal')");
        if ($sql) {
            echo "<script>alert('Data Berhasil Disimpan'); window.location.href='?page=buku';</script>";
        } else {
            echo "<script>alert('Data Gagal Disimpan');</script>";
        }
    }
}
?>