<?php
if (basename($_SERVER ["PHP_SELF"]) != "homekasir.php") {
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
	echo "<h2 align=center><B><font face=cambria color=black size=5>PELANGGAN</font></B></h2><p>";
}
else
{
	?>
	<script language="javascript">
		alert("ANDA HARUS LOGIN DULU UNTUK BISA MENGAKSES HALAMAN INI"); 
		document.location="index.php";
	</script>
	<?php
	exit();
}
?>
<html>
	<head>
		<title>FORM DATA PRODUK</title>
		<link href="index.css" rel="stylesheet" type="text/css">
	</head>
	<div align="center"> 
	<body>
		<fieldset>
			<legend>INPUT DATA PRODUK</legend>
			<form method="post" action="inputproduk.php" enctype='multipart/form-data'>
				<table border="0" cellspacing="0" cellpadding="10">
					<tr>
						<td>Nama Produk</td>
						<td><input type="text" name="produk"></td>
					</tr>
					<tr>
					<tr>
						<td>Gambar</td>
						<td><input type="file" name="foto"></td>
					</tr>
					<tr>
						<td>Harga</td>
						<td><input type="text" name="harga"></td>
					</tr>
					<tr>
						<td>Stok</td>
						<td><input type="text" name="stok"></td>
					</tr>
					<tr>
						<td colspan="2" align="right"><input type="submit" value="SIMPAN"></td>
					</tr>
				</table>
			</form>
		</fieldset>
						
		<p><p>
		<fieldset>
			<legend>DATA PRODUK</legend>
				<table border="1" cellspacing="0" cellpadding="10">
					<tr>
						<td><div align="center"><strong>NO</strong></div></td>
						<td><div align="center"><strong>NAMA PRODUK</strong></div></td>
						<td><div align="center"><strong>Gambar</strong></div></td>
						<td><div align="center"><strong>HARGA</strong></div></td>
						<td><div align="center"><strong>STOK</strong></div></td>
						<td><div align="center"><strong>EDIT</strong></div></td>
						<td><div align="center"><strong>DELETE</strong></div></td>
					</tr>
					
					<?php
					$no=1;
						function rupiah($angka){
							$hasil_rupiah="Rp ". number_format($angka,2,',','.');
							return $hasil_rupiah;
						}
					$ambil = mysqli_query($koneksi,"SELECT * FROM produk ORDER BY NamaProduk asc");
					while ($array=mysqli_fetch_array($ambil, MYSQLI_ASSOC))
					{
					?>
						<tr>
							<td><div align="center"><?php echo"$no"; $no++; ?></div></td>
							<td><div align="center"><?php echo"$array[NamaProduk]"; ?></div></td>
							<td><div align="center"><img src="gambar/<?php echo $array['foto'];?>" width="50" height="50"></div></td>
							<td><div align="center"><?php echo rupiah($array['Harga']); ?></div></td>
							<td><div align="center"><?php echo"$array[Stok]"; ?></div></td>
							<td><div align="center"><a href="homekasir.php?pg=formeditproduk&idnya=<?php echo $array['ProdukId'];?>">EDIT</a></div></td>
							<td><div align="center"><a href="deleteproduk.php?idnya=<?php echo $array['ProdukId'];?>" onclick="return confirm('Yakin akan dihapus?')">HAPUS</a></div></td>
						</tr>
					<?php
					}
					?>
				</table>
		</fieldset>
	</body>
	</div>
</html>