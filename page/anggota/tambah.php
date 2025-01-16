<div class="panel panel-default">
    <div class="panel-heading">
        Tambah Data
    </div> 
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <form method="POST">
                    <div class="form-group">
                        <label>NISN</label>
                        <input class="form-control" name="nisn" required/>
                    </div>

                    <div class="form-group">
                        <label>Nama</label>
                        <input class="form-control" name="nama" required/>
                    </div>

                    <div class="form-group">
                        <label>Tempat Lahir</label>
                        <input class="form-control" name="tempat_lahir" required/>
                    </div>

                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input class="form-control" type="date" name="tgl_lahir" required/>
                    </div>

                    <div class="form-group" required>
                        <label>Jenis Kelamin</label><br/>
                        <label class="radio-inline">
                            <input type="radio" value="Laki-laki" name="jk"/> Laki-laki
                        </label>
                        <label class="radio-inline">
                            <input type="radio" value="Perempuan" name="jk"/> Perempuan
                        </label>
                    </div>

                    <div class="form-group">
                        <label>Kelas</label>
                        <input class="form-control" name="kelas" required/>
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
    $nisn = $_POST['nisn'];
    $nama = $_POST['nama'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $jk = $_POST['jk'];
    $kelas = $_POST['kelas'];

    // Cek apakah NISN sudah ada di database
    $sql_check = $koneksi->query("SELECT * FROM tb_anggota WHERE nisn = '$nisn'");
    $exists = $sql_check->num_rows;

    if ($exists > 0) {
        // Jika NISN sudah ada
        echo "<script>alert('Data dengan NISN tersebut sudah ada!'); window.location.href='?page=anggota&aksi=tambah';</script>";
    } else {
        // Jika NISN belum ada, simpan data
        $sql = $koneksi->query("INSERT INTO tb_anggota (nisn, nama, tempat_lahir, tgl_lahir, jk, kelas)
                                VALUES('$nisn', '$nama', '$tempat_lahir', '$tgl_lahir', '$jk', '$kelas')");
        if ($sql) {
            echo "<script>alert('Data Berhasil Disimpan'); window.location.href='?page=anggota';</script>";
        } else {
            echo "<script>alert('Data Gagal Disimpan');</script>";
        }
    }
}
?>
