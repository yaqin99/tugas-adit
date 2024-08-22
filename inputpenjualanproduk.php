<?php
include "koneksi.php";
session_start();
// jika belum login redirect ke formpenjualan
if (!isset($_SESSION['LoginId'])) {
  header('location: homekasir.php?pg=formpenjualan');
  exit;
}

$produk_id = $_POST['produk'];
$jumlah = $_POST['jumlah'];
// pastikan data jumlah berisi angka dan lebih besar dari 0
if ( ! is_numeric($jumlah) || $jumlah <= 0):
  ?>
  <script>
   alert('Jumlah tidak valid');
   document.location = "homekasir.php?pg=formpenjualan";
 </script>
 <?php
 exit;
endif;


$persiapan_query = mysqli_prepare (
  $koneksi,
  "SELECT * FROM produk WHERE ProdukId = ?"
);
mysqli_stmt_bind_param($persiapan_query, "i", $produk_id); 
$eksekusi_query = mysqli_stmt_execute ($persiapan_query);
$ambil_hasil = mysqli_stmt_get_result ($persiapan_query);

// jika datanya tidak ditemukan
if (mysqli_num_rows($ambil_hasil) != 1):
  ?>
  <script>
    alert('Produk tidak ditemukan');
    document.location = "homekasir.php?pg=formpenjualan";
  </script>
  <?php
  exit;
endif;

// jadikan array
$array = mysqli_fetch_assoc($ambil_hasil);
// stok kurang
if ($array['Stok'] < $jumlah):
  ?>
  <script>
    alert('Stok Produk kurang dari jumlah');
    document.location = "homekasir.php?pg=formpenjualan";
  </script>
  <?php
  exit;
endif;

 // simpan data kedalam sesi
/* untuk menggunakan variabel $_SESSION pastikan session_start()
sudah dijalankan sebelumnya*/
$_SESSION['keranjang'] [$produk_id] = $jumlah;
header ('location: homekasir.php?pg=formpenjualan');