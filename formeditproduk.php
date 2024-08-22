<?php
if (basename ($_SERVER["PHP_SELF"]) != "homekasir.php") {
	?>
	<script language="javascript">
		alert("FILE HARUS DIAKSES OLEH HOMEKASIR.PHP");
		document.location="homekasir.php";
	</script>
	<?php
	exit();
}
if (isset($_SESSION['LoginId']))
{
	echo "<h2 align=center><B><font face=cambria
	color=black size=5>PELANGGAN</font></B></h2><p>";
}
else
{
	?>
	<script language="javascript">
		alert("ANDA HARUS LOGIN DULU UNTUK BISA MENGAKSES HALAMAN INI"); 
		document.location="index.php";
	</script>
	<?php
}
?>
<html><head><title>FORM EDIT PRODUK</title>
	<link href="index.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<?php
	$produk=$_GET['idnya'];
	$persiapan_query = mysqli_prepare ($koneksi,
		"SELECT * FROM produk WHERE ProdukId=?");
	mysqli_stmt_bind_param($persiapan_query, "i", $produk);
	$eksekusi_query = mysqli_stmt_execute($persiapan_query);
	if ($eksekusi_query == false) {
		?>
		<script language="javascript">
			alert("<?php echo mysqli_stmt_error($persiapan_query); ?>");
			history.go(-1)
		</script>
		<?php
		exit();
	}
	$ambil = mysqli_stmt_get_result($persiapan_query); 
	$array = mysqli_fetch_array($ambil, MYSQLI_ASSOC);
	?>
	<div align="center"><fieldset><legend>EDIT DATA PRODUK</legend>
		<form action="editproduk.php" method="post"
		name="form1" id="form1">
		<table><tr>
			<td>NAMA PRODUK</td>
			<td>
				<input type="hidden" value="<?php echo"$_GET[idnya]"?>"
				name="ProdukId">
				<input type="text" name="produk" id="produk"
				value="<?php echo"$array[NamaProduk]" ?>"></td></tr>
				<td>Gambar</td>
				<td><img src="<?php echo "./gambar/$array[foto]";?>"
				width="50" height="50"/>
				<input type="file" name="foto" id="gambar"></td>
				<tr>
					<td>HARGA</td>
					<td><input type="text" name="harga" id="harga"
						value="<?php echo"$array[Harga]" ?>"></td></tr>
						<tr>
							<td>STOK</td>
							<td><input type="text" name="stok" id="stok"
								value="<?php echo"$array[Stok]" ?>"></td></tr>
								<tr><td colspan="2" align="right">
									<input type="submit" value="UPDATE"></td></tr>
								</table></form></fieldset></div>
								<a href="homekasir.php?pg=forminputproduk">
									<input type="submit" value="KEMBALI"></a></div>
								</body></html>