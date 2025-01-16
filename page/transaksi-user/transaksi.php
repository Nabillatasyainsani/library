<div class="row">
    <div class="col-md-12">
        <!-- Advanced Tables -->
        <div class="panel panel-default">
            <div class="panel-heading">
                Data Transaksi Semua
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Terlambat</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $no = 1;
                            $id_user = $_SESSION['user']; // Get the current user's ID
                            $sql = $koneksi->query("SELECT * FROM tb_transaksi WHERE status='pinjam' AND id_user='$id_user'");

                            while ($data = $sql->fetch_assoc()) {
                            ?>

                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td>
                                        <?php
                                        $sql_buku = $koneksi->query("SELECT judul FROM tb_buku WHERE id = '{$data['id_buku']}'");
                                        $data_buku = $sql_buku->fetch_assoc();
                                        echo $data_buku['judul'];
                                        ?>
                                    </td>

                                    <td><?php echo $data['tgl_pinjam']; ?></td>
                                    <td><?php echo $data['tgl_kembali']; ?></td>
                                    <td>
                                        <?php
                                        $denda = 1000;
                                        $tgl_dateline2 = $data['tgl_kembali'];
                                        $tgl_kembali = date('Y-m-d');
                                        $lambat = terlambat($tgl_dateline2, $tgl_kembali);
                                        $denda1 = $lambat * $denda;

                                        if ($lambat > 0) {
                                            echo "<font color='red'>$lambat hari (Rp " . number_format($denda1, 0, ',', '.') . ")</font>";
                                        } else {
                                            echo $lambat . " Hari";
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $data['status']; ?></td>
                                    <?php if ($isAdmin) { ?>
                                        <td>
                                            <a href="?page=transaksi-user&aksi=kembali&id=<?php echo $data['id']; ?>&judul=<?php echo $data['judul']; ?>" class="btn btn-info">Kembali</a>
                                            <a href="?page=transaksi-user&aksi=perpanjang&id=<?php echo $data['id']; ?>&judul=<?php echo $data['judul']; ?>&lambat=<?php echo $lambat; ?>&tgl_kembali=<?php echo $data['tgl_kembali']; ?>" class="btn btn-danger">Perpanjang</a>
                                        </td>
                                    <?php } ?>
                                </tr>

                            <?php } ?>

                        </tbody>
                    </table>
                </div>

                <?php if ($isAdmin) { ?>
                    <a href="?page=buku&aksi=tambah" class="btn btn-primary" style="margin-top: 8px;">Tambah Data</a>
                    <a href="./laporan/laporan_buku_exel.php" target="blank" class="btn btn-default" style="margin-top: 8px;"><i class="fa fa-print"></i> ExportToExel</a>
                <?php } ?>
            </div>
        </div>
    </div>
</div>