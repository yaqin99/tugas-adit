<?php
if(basename($_SERVER["PHP_SELF"]) != "homekasir.php") {
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
}
?>
<html>
	<head>
		<title>FORM EDIT PELANGGAN</title>
		<link href="index.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<?php
		$pelanggan=$_GET['idnya'];
		$persiapan_query=mysqli_prepare($koneksi, "SELECT*FROM pelanggan WHERE PelangganId=?");
		mysqli_stmt_bind_param($persiapan_query,"i",$pelanggan);
		$eksekusi_query=mysqli_stmt_execute($persiapan_query);
		if($eksekusi_query == false){
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
		<div align="center">
		<fieldset>
			<legend>EDIT DATA PELANGGAN</legend>
				<form action="editpelanggan.php" method="post" name="form1" id="form1">
					<table> 
						<tr>
							<td>NAMA PELANGGAN</td>
							<td>
								<input type="hidden" value="<?php echo"$_GET[idnya]"?>"name="PelangganId">
								<input type="text" name="nama" id="nama" value="<?php echo"$array[NamaPelanggan]"?>">
							</td>
						</tr>
						<tr>
							<td>ALAMAT</td>
							<td>
								<input type="text" name="alamat" id="alamat" value="<?php echo"$array[Alamat]"?>">
							
							</td>
						</tr>
						<tr>
							<td>NOMOR TELEPON</td>
							<td>
								<input type="tel" name="telepon" pattern="[0-9]+"minlngth="10" maxlength="12" required></td>
							</td>
						</tr>
						<tr>
							<td>Jenis Kelamin</td>
							<td>
							<input type="radio" name="jeniskelamin"value="laki-laki">laki-laki
							<input type="radio" name="jeniskelamin"value="perempuan">perempuan
							</td>
						</tr>
						<tr>
							<td colspan="2" align="right">
								<input type="submit" value="UPDATE">
							</td>
						</tr>
					</table>
				</form>
		</fieldset>
		</div>
												
		<p>
		<div align="center">
			<a href="homekasir.php?pg=forminputpelanggan">
			<input type="submit" value="KEMBALI"></a>
		</div>
	</body>
</html>