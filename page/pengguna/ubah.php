<?php

$id = $_GET['id'];

$sql = $koneksi->query("SELECT * FROM tb_user WHERE id = '$id'");

$tampil = $sql->fetch_assoc();

$level = $tampil['level'];
$id_anggota = $tampil['id_anggota'];

?>

<div class="panel panel-default">
    <div class="panel-heading">
        Edit Data Pengguna
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <form method="POST">
                    <div class="form-group">
                        <label>Username</label>
                        <input class="form-control" name="username" value="<?php echo $tampil['username']; ?>" required />
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input class="form-control" type="password" name="password" placeholder="Kosongkan jika tidak ingin diubah" />
                    </div>

                    <div class="form-group">
                        <label>Level</label>
                        <select class="form-control" name="level" required>
                            <option value="Admin" <?php echo ($level == 'Admin') ? 'selected' : ''; ?>>Admin</option>
                            <option value="User" <?php echo ($level == 'User') ? 'selected' : ''; ?>>User</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Nama Anggota</label>
                        <select class="form-control" name="id_anggota" required>
                            <option value="">-- Pilih Anggota --</option>
                            <?php
                            $sql_anggota = $koneksi->query("SELECT * FROM tb_anggota");
                            while ($data_anggota = $sql_anggota->fetch_assoc()) {
                                $selected = ($data_anggota['id'] == $id_anggota) ? 'selected' : '';
                                echo "<option value='{$data_anggota['id']}' {$selected}>{$data_anggota['nama']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div>
                        <input type="submit" name="simpan" value="Edit" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php

$username = $_POST['username'];
$password = $_POST['password'];
$level = $_POST['level'];
$id_anggota = $_POST['id_anggota'];
$simpan = $_POST['simpan'];

if ($simpan) {
    if (!empty($password)) {
        // Update dengan password baru
        $sql = $koneksi->query("UPDATE tb_user SET username='$username', password=MD5('$password'), level='$level', id_anggota='$id_anggota' WHERE id='$id'");
    } else {
        // Update tanpa mengubah password
        $sql = $koneksi->query("UPDATE tb_user SET username='$username', level='$level', id_anggota='$id_anggota' WHERE id='$id'");
    }

    if ($sql) {
?>
        <script type="text/javascript">
            alert("Data Berhasil Diubah");
            window.location.href = "?page=pengguna";
        </script>
<?php
    }
}

?>