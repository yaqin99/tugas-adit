<?php
include 'koneksi.php';
$persiapan_query = mysqli_prepare($koneksi,
"DELETE FROM penjualan WHERE PenjualanId=?");
mysqli_stmt_bind_param($persiapan_query,"i",
$_GET["idnya"]);
$eksekusi_query = mysqli_stmt_execute($persiapan_query);
if($eksekusi_query == false){
?>
<script language="javascript">
alert("<?php echo mysqli_stmt_error($persiapan_query);?>");
history.go(-1)
</script>
<?php }?>

<?php
exit();
header('location:homekasir.php?pg=riwayatpenjualan');
?>