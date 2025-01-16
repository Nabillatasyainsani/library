<?php

    $nisn = $_GET['id'];    

    $sql = $koneksi->query("select * from tb_anggota where nisn = '$nisn'");

    $tampil = $sql->fetch_assoc();

    $jkl = $tampil['jk'];
    $kelas = $tampil['kelas'];
    

?>

<div class="panel panel-default">
<div class="panel-heading">
        Ubah Data
  </div> 
<div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                  
                                    <form method="POST" >
                                        <div class="form-group">
                                            <label>NISN</label>
                                            <input class="form-control" name="nisn" value="<?php echo $tampil['nisn']?>" readonly required/>
                                           
                                        </div>

                                        <div class="form-group">
                                            <label>Nama</label>
                                            <input class="form-control" name="nama" value="<?php echo $tampil['nama']?>" required/>
                                           
                                        </div>

                                        <div class="form-group">
                                            <label>Tempat Lahir</label>
                                            <input class="form-control" name="tempat_lahir" value="<?php echo $tampil['tempat_lahir']?>" required/>
                                           
                                        </div>

                                        <div class="form-group">
                                            <label>Tanggal Lahir</label>
                                            <input class="form-control" type="date" name="tgl_lahir" value="<?php echo $tampil['tgl_lahir']?>" required/>
                                           
                                        </div>

                                        <div class="form-group" required>
                                            <label>Jenis Kelamin</label><br/>
                                            <label class="radio-inline">
                                                <input type="radio" value="Laki-laki" name="jk" <?php echo ($jkl == 'Laki-laki') ? "checked" : ""; ?>/> Laki-laki
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" value="Perempuan" name="jk" <?php echo ($jkl == 'Perempuan') ? "checked" : ""; ?>/> Perempuan
                                            </label>
                                        </div>



                                        <div class="form-group">
                                            <label>Kelas</label>
                                            <input class="form-control" name="kelas" value="<?php echo $tampil['kelas']?>" required/>
                                           
                                        </div>

                                       
                                        <div>

                                            <input type="submit" name="simpan" value="Ubah" class="btn btn-primary">
                                        </div>
                                </div>

                                </form>
                              </div>
 </div>
 </div>
 </div>



 <?php
 
    $nisn = $_POST ['nisn'];
    $nama = $_POST ['nama'];
    $tempat_lahir = $_POST ['tempat_lahir'];
    $tgl_lahir = $_POST ['tgl_lahir'];
    $jk = $_POST ['jk'];
    $kelas = $_POST ['kelas'];
   
    $simpan = $_POST ['simpan'];


    if ($simpan) {
       
        $sql = $koneksi->query("update tb_anggota set nama='$nama', tempat_lahir='$tempat_lahir', tgl_lahir='$tgl_lahir', jk='$jk', kelas='$kelas' where nisn='$nisn' ");

        if ($sql) {
            ?>
                <script type="text/javascript">

                    alert ("Data Berhasil Disimpan");
                    window.location.href="?page=anggota";

                </script>
            <?php
        }
    }

 ?>