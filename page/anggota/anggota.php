<div class="row">
    <div class="col-md-12">
        <!-- Advanced Tables -->
        <div class="panel panel-default">
            <div class="panel-heading">
                Data Anggota
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NISN</th>
                                <th>Nama</th>
                                <th>Tempat Lahir</th>
                                <th>Tanggal Lahir</th>
                                <th>Jenis Kelamin</th>
                                <th>Kelas</th>
                                <?php if ($_SESSION['level'] == 'admin') : ?>

                                <?php endif; ?>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $sql = $koneksi->query("SELECT * FROM tb_anggota");
                            while ($data = $sql->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $data['nisn']; ?></td>
                                    <td><?php echo $data['nama']; ?></td>
                                    <td><?php echo $data['tempat_lahir']; ?></td>
                                    <td><?php echo $data['tgl_lahir']; ?></td>
                                    <td><?php echo $data['jk']; ?></td>
                                    <td><?php echo $data['kelas']; ?></td>
                                    <?php if ($isAdmin) { ?>
                                        <td>

                                            <a href="?page=anggota&aksi=ubah&id=<?php echo $data['nisn']; ?>" class="btn btn-info"><i class="fa fa-edit"></i> Edit</a>
                                            <a onclick="return confirm('Anda Yakin Akan Menghapus Data Ini...???')" href="?page=anggota&aksi=hapus&id=<?php echo $data['nisn']; ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</a>

                                        </td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($isAdmin) { ?>
                    <a href="?page=anggota&aksi=tambah" class="btn btn-primary" style="margin-top: 8px;">Tambah Data</a>
                    <a href="./laporan/laporan_anggota_exel.php" target="blank" class="btn btn-default" style="margin-top: 8px;"><i class="fa fa-print"></i> ExportToExcel</a>
                <?php } ?>
            </div>
        </div>
    </div>
</div>