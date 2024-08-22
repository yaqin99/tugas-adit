<?php
include "koneksi.php";
session_start();
// jika belum login redirect ke formpenjualan
if (!isset($_SESSION['LoginId'])) {
	header('location: homekasir.php?pg=formpenjualan');
	exit;
}

$produk_id = $_GET['idnya'];

// hapus data sesi produk
/* untuk menggunakan variabel $_SESSION pastikan session_start()
sudah dijalankan sebelumnya */
unset($_SESSION['keranjang'] [$produk_id]);
header ('location: homekasir.php?pg=formpenjualan');