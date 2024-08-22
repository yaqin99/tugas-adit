<?php
include 'koneksi.php'; 
$id=$_POST["PelangganId"];
$nama=$_POST['nama'];
$alamat=$_POST['alamat']; 
$telepon=$_POST['telepon'];
$jeniskelamin=$_POST['jeniskelamin'];

$persiapan_query = mysqli_prepare($koneksi, "UPDATE pelanggan SET NamaPelanggan=?, Alamat=?, NomorTelepon=?, JenisKelamin=? WHERE PelangganId=?");

mysqli_stmt_bind_param($persiapan_query, "ssssi", $nama,$alamat,$telepon,$jeniskelamin,$id);

$eksekusi_query= mysqli_stmt_execute ($persiapan_query); 
if($eksekusi_query == false) {
	?>
	<script language="javascript">
		alert("<?php echo mysqli_stmt_error($persiapan_query); ?>");
		history.go(-1)
	</script>
	<?php
	exit();
}
header('location:homekasir.php?pg=forminputpelanggan');
?>