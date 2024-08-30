<?php
if(basename ($_SERVER["PHP_SELF"]) != "homekasir.php") {
	?>
	<script language="javascript">
		alert("FILE HARUS DIAKSES OLEH HOMEKASIR.PHP");
		document.location = "homekasir.php";
	</script>
	<?php
	exit();
}
if (isset($_SESSION['LoginId'])) {
	echo "<h2 align=center><B><font face=cambria color=black
	size=5>PELANGGAN</font></B></h2><p>";
} else {
	?>
	<script language="javascript">
		alert("ANDA HARUS LOGIN DULU UNTUK BISA MENGAKSES HALAMAN INI");
		document.location = "index.php";
	</script>
	<?php
	exit();
}
?>
<html><head><title>FORM DATA PENJUALAN</title>
	<link href="index.css" rel="stylesheet" type="text/css">
</head>
<div align="center"><body>
	<fieldset><legend>TAMBAH PRODUK KE KERANJANG</legend>
		<form method="post" action="./inputpenjualanproduk.php">
			<table border="0" cellspacing="0" cellpadding="10">
				<tr>
					<td>Pilih Produk</td>
					<td><select name="produk">
						<?php
						$ambil = mysqli_query($koneksi, "SELECT * FROM produk
							ORDER BY NamaProduk asc");
						$array_semua_produk = mysqli_fetch_all ($ambil, MYSQLI_ASSOC);
						foreach ($array_semua_produk as $array_produk):
							?>
							<option value="<?=$array_produk['ProdukId']?>">
								<?=$array_produk['NamaProduk']?> |
								Harga <?=$array_produk['Harga']?> |
								Stok <?=$array_produk['Stok']?>
							</option>
						<?php endforeach;?>
					</select></td>
					<td>Jumlah</td>
					<td><input type="text" name="jumlah"></td>
					<td colspan="2" align="right"><input type="submit"
						value="SIMPAN">
					</tr></table></form></fieldset><p><p>
						<fieldset><legend>KERANJANG PRODUK</legend>
							<form method="post" action="./inputpenjualan.php">
								<table border="1" cellspacing="0" cellpadding="10">
									<tr>
										<td><div align="center"><strong>NO</strong></div></td>
										<td><div align="center"><strong>NAMA PRODUK</strong></div></td>
										<td><div align="center"><strong>HARGA</strong></div></td>
										<td><div align="center"><strong>JUMLAH</strong></div></td>
										<td><div align="center"><strong>SUB TOTAL</strong></div></td>
										<td><div align="center"><strong>AKSI</strong></div></td>
									</tr>
									<?php
									$no=1;
									function rupiah($angka){
										$hasil_rupiah="Rp". number_format($angka,2,',','.');
										return $hasil_rupiah;
									}
									$total_harga = 0;
									/* buat variabel keranjang dari sesi['keranjang'], 
									jika tidak ada gunakan nilai array kosong*/
									$keranjang = $_SESSION['keranjang'] ?? []; 
/* loop semua data keranjang, $_SESSION['keranjang'] [$produk_id]
=$jumlah */
	foreach ($keranjang as $produk_id => $jumlah):
// filter/saring produk berdasarkan id
		$filter_produk =  array_filter ($array_semua_produk, 
			function ($produknya_array) use ($produk_id){
				return $produknya_array['ProdukId'] == $produk_id;
	});
/* jika tidak ada produk yang ditemukan, lompati data ini
dan lanjut data berikutnya */
if (empty($filter_produk)) {
	continue;
}
// ambil nama produk yang ditemukan
$produk_ditemukan = array_pop($filter_produk);

//totalkan harga
$total_harga += $jumlah * $produk_ditemukan ['Harga'];
?>
<tr><td><div align="center"><?php echo "$no"; $no++; ?>
</div></td>
<td><div align="center"><?php echo
"$produk_ditemukan[NamaProduk]"; ?></div></td>
<td><div align="center"><?= 'Rp.'. number_format($produk_ditemukan["Harga"]); ?>
</div></td>
<td><div align="center"><?php echo "$jumlah"; ?></div></td>
<td><div align="center"><?='Rp.'. number_format($jumlah * $produk_ditemukan ['Harga'])?>
</div></td>
<td><div align="center"><a href="deletepenjualanproduk.php?idnya=
<?php echo $produk_ditemukan ['ProdukId']; ?>">HAPUS</a></div></td>
</tr>
<?php
endforeach;
?>
<tr><td colspan="4"><div align="right"><strong>TOTAL
</strong></div></td>
<td><div align="center"><strong><?='Rp.'. number_format($total_harga);?>
</strong></div></td>
<td></td>
</tr>
<tr>
	<td colspan="6"><div align="right">Pelanggan:
		<select name="pelanggan">
			<?php
			$ambil = mysqli_query($koneksi, "SELECT * FROM pelanggan"); 
			$array_semua_pelanggan = mysqli_fetch_all($ambil, MYSQLI_ASSOC);
			foreach ($array_semua_pelanggan as $array_pelanggan):
				?>
				<option value="<?=$array_pelanggan ['PelangganId']?>">
					<?=$array_pelanggan ['NamaPelanggan']?> |
					<?=$array_pelanggan ['Alamat']?> |
					<?=$array_pelanggan ['NomorTelepon']?>
				</option>
			<?php endforeach;?>
		</select>
		Pembayaran:
		<input type="number" name="Pembayaran" min="1"></div></td>
	</tr></table>
	<input type="submit" value="SIMPAN">
</form></fieldset></div></body></html>