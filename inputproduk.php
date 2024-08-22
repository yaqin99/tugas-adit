<?php
include 'koneksi.php'; 
$produk=$_POST['produk']; 
$gb=$_FILES['foto']['name'];
$type_gambar=$_FILES['foto']['type'];
$lokasi_file=$_FILES['foto']['tmp_name'];
if($type_gambar !="image/gif" AND
	$type_gambar !="image/jpeg" AND
	$type_gambar !="image/jpg" AND
	$type_gambar !="image/png")
{
	echo "upload gagal !!<br>
	Tipe file <b>$gb</b>:$type_gambar<br>
	Tipe file yang boleh di upload jpeg,gif,jpg,png<br>
	pastikan semua field di isi
	<p><a href='forminputproduk.php' kembali ke awal</a></p>";
	exit();
}
$harga=$_POST['harga'];
$stok=$_POST['stok'];

$persiapan_query= mysqli_prepare(
	$koneksi,
	"INSERT INTO produk (NamaProduk,foto,harga,stok)
	VALUES (?, ?, ?, ?)"
); 
mysqli_stmt_bind_param($persiapan_query,"ssdi",
	$produk,$gb,$harga,$stok);
$eksekusi_query = mysqli_stmt_execute($persiapan_query);

if($eksekusi_query == false) {
	?>
	<script language="javascript">
		alert("<?php echo mysqli_stmt_error($persiapan_query); ?>");
		history.go(-1)
	</script>
	<?php
	exit();
}
$simpan_ke="gambar/" .$gb;
move_uploaded_file($lokasi_file, $simpan_ke);
header('location:homekasir.php?pg=forminputproduk');
?>