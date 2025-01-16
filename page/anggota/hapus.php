<?php

$nisn = $_GET['id'];
$koneksi->query("delete from tb_anggota where nisn = '$nisn'");
?>


<script type="text/javascript">
    window.location.href = "?page=anggota";
</script>