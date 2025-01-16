<div class="row">
    <div class="col-md-12">
        <!-- Advanced Tables -->
        <div class="panel panel-default">
            <div class="panel-heading">
                Data Pengguna
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" style="width: 100%;" id="dataTables-example">
                        <thead>
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th style="width: 20%;">Username</th>
                                <th style="width: 30%;">Nama</th>
                                <th style="width: 20%;">Level</th>
                                <th style="width: 25%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $sql = $koneksi->query("SELECT * FROM tb_user");
                            while ($data = $sql->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $data['username']; ?></td>
                                    <td>
                                        <?php
                                        $sql_anggota = $koneksi->query("SELECT nama FROM tb_anggota WHERE id = '{$data['id_anggota']}'");
                                        $data_buku = $sql_anggota->fetch_assoc();
                                        echo $data_buku['nama'];
                                        ?>
                                    </td>
                                    <td><?php echo $data['level']; ?></td>
                                    <td>
                                        <a href="?page=pengguna&aksi=ubah&id=<?php echo $data['id']; ?>" class="btn btn-info"><i class="fa fa-edit"></i> Edit</a>
                                        <a href="?page=pengguna&aksi=hapus&id=<?php echo $data['id']; ?>" class="btn btn-danger" onclick="return confirm('Anda Yakin Akan Menghapus Data Ini...???')"><i class="fa fa-trash"></i> Hapus</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <a href="?page=pengguna&aksi=tambah" class="btn btn-primary" style="margin-top: 8px;">Tambah Data</a>
                <a href="./laporan/laporan_pengguna_exel.php" target="blank" class="btn btn-default" style="margin-top: 8px;"><i class="fa fa-print"></i> ExportToExcel</a>
            </div>
        </div>
    </div>
</div>