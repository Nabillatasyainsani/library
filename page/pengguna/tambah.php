<div class="panel panel-default">
    <div class="panel-heading">
        Tambah Pengguna
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <form method="POST">
                    <div class="form-group">
                        <label>Username</label>
                        <input class="form-control" name="username" required />
                    </div>


                    <div class="form-group">
                        <label>ID Anggota</label>
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
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" required />
                    </div>

                    <div class="form-group">
                        <label>Level</label>
                        <select class="form-control" name="level" required>
                            <option value="">-- Pilih Level --</option>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
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
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash password
    $level = $_POST['level'];
    $id_anggota = $_POST['id_anggota'];

    // Cek apakah username sudah ada di database
    $sql_check = $koneksi->query("SELECT * FROM tb_user WHERE username = '$username'");
    $exists = $sql_check->num_rows;

    if ($exists > 0) {
        // Jika username sudah ada
        echo "<script>alert('Username tersebut sudah ada!'); window.location.href='?page=pengguna&aksi=tambah';</script>";
    } else {
        // Jika username belum ada, simpan data
        $sql = $koneksi->query("INSERT INTO tb_user (username, password, level, id_anggota) 
                                VALUES ('$username', '$password', '$level', '$id_anggota')");
        if ($sql) {
            echo "<script>alert('Pengguna Berhasil Ditambahkan'); window.location.href='?page=pengguna';</script>";
        } else {
            echo "<script>alert('Pengguna Gagal Ditambahkan');</script>";
        }
    }
}
?>

