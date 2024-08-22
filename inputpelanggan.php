<?php
include 'koneksi.php';
$nama=$_POST['nama'];
$alamat=$_POST['alamat'];
$telepon=$_POST['telepon'];
$jeniskelamin=$_POST['jeniskelamin'];

$persiapan_query=mysqli_prepare($koneksi, "INSERT INTO pelanggan (NamaPelanggan,Alamat,NomorTelepon,JenisKelamin)  VALUES (?, ?, ?, ?)");
mysqli_stmt_bind_param($persiapan_query,"ssss",$nama,$alamat,$telepon,$jeniskelamin);
$eksekusi_query = mysqli_stmt_execute($persiapan_query);

if($eksekusi_query == false) {
	?>
	<script language="javascript">
		alert("<?php echo mysqli_stmt_error ($persiapan_query); ?>");
		history.go(-1) 
	</script>
	<?php
	exit();
}
header ('location:homekasir.php?pg=forminputpelanggan');
?>