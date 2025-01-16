<div class="row">
    <div class="col-md-12">
        <!-- Advanced Tables -->
        <div class="panel panel-default">
            <div class="panel-heading">
                Data Buku
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Pengarang</th>
                                <th>Penerbit</th>
                                <th>ISBN</th>
                                <th>Tahun Terbit</th>
                                <th>Jumlah Buku</th>
                                <th>Lokasi</th>
                                <?php if ($isAdmin) : ?>
                                    <th>Aksi</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>

                            <?php

                            $no = 1;
                            $sql = $koneksi->query("select * from tb_buku");

                            while ($data = $sql->fetch_assoc()) {
                            ?>

                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $data['judul']; ?></td>
                                    <td><?php echo $data['pengarang']; ?></td>
                                    <td><?php echo $data['penerbit']; ?></td>
                                    <td><?php echo $data['isbn']; ?></td>
                                    <td><?php echo $data['tahun_terbit']; ?></td>
                                    <td><?php echo $data['jumlah_buku']; ?></td>
                                    <td><?php echo $data['lokasi']; ?></td>
                                    <?php if ($isAdmin) { ?>

                                        <td>
                                            <a href="?page=buku&aksi=ubah&id=<?php echo $data['id']; ?>" class="btn btn-info"><i class="fa fa-edit"></i> Edit</a>
                                            <a onclick="return confirm('Anda Yakin Akan Menghapus Data Ini...???')" href="?page=buku&aksi=hapus&id=<?php echo $data['id']; ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</a>
                                        </td>
                                    <?php } ?>
                                </tr>

                            <?php } ?>

                        </tbody>
                    </table>
                </div>

                <?php if ($isAdmin) { ?>
                    <a href="?page=buku&aksi=tambah" class="btn btn-primary" style="margin-top: 8px;">Tambah Data</a>
                    <a href="./laporan/laporan_buku_exel.php" target="blank" class="btn btn-default" style="margin-top: 8px;"><i class="fa fa-print"></i> ExportToExcel</a>
                <?php } ?>
            </div>
        </div>
    </div>
</div>