<?php
include "koneksi.php";
session_start();
// jika belum login redirect ke formpenjualan
if (!isset($_SESSION['LoginId'])) {
    header('location: homekasir.php?pg=formpenjualan');
    exit;
}

// cek pelanggan
$pelanggan_id = $_POST['pelanggan'];
$persiapan_query = mysqli_prepare($koneksi, "SELECT * FROM pelanggan WHERE PelangganId = ?");
mysqli_stmt_bind_param($persiapan_query, "i", $pelanggan_id);
$eksekusi_query = mysqli_stmt_execute($persiapan_query);
$ambil_hasil = mysqli_stmt_get_result($persiapan_query);

// jika datanya tidak ditemukan
if (mysqli_num_rows($ambil_hasil) != 1) :
?>
    <script>
        alert('Pelanggan tidak ditemukan');
        document.location = "homekasir.php?pg=formpenjualan";
    </script>
<?php
    exit;
endif;

// buat variabel keranjang dari sesi['keranjang'], jika tidak ada gunakan nilai array kosong
$keranjang = $_SESSION['keranjang'] ?? [];
// ambil semua index $keranjang
$semua_produk_id = array_keys($keranjang);
// pastikan $semua_produk_id tidak kosong
if (empty($semua_produk_id)) :
?>
    <script>
        alert('Keranjang kosong');
        document.location = "homekasir.php?pg=formpenjualan";
    </script>
<?php
    exit;
endif;

// buat string kriteria produk, cth: 1,2,3
$where_produk_ids = join(',', $semua_produk_id);
$persiapan_query = mysqli_prepare($koneksi, "SELECT * FROM produk WHERE ProdukId IN ($where_produk_ids)");
$eksekusi_query = mysqli_stmt_execute($persiapan_query);
$ambil_hasil = mysqli_stmt_get_result($persiapan_query);
// jadikan array
$array_produk = mysqli_fetch_all($ambil_hasil, MYSQLI_ASSOC);

// jika ada data yang tidak ditemukan (jumlah data produk tidak sama dengan data keranjang)
if (mysqli_num_rows($ambil_hasil) != count($semua_produk_id)) :
    // hapus produk di keranjang yang tidak ditemukan
    $semua_produk_tidak_ditemukan = array_diff($semua_produk_id, array_column($array_produk, 'ProdukId'));
    foreach($semua_produk_tidak_ditemukan as $id_produk_tidak_ditemukan){
        unset($_SESSION['keranjang'][$id_produk_tidak_ditemukan]);
    }
?>
    <script>
        alert('Ada Produk dalam Keranjang yang tidak ditemukan dan sudah dihapus');
        document.location = "homekasir.php?pg=formpenjualan";
    </script>
<?php
    exit;
endif;

$persiapan_data_detail = [];
$total_harga = 0;
$pembayaran = $_POST['Pembayaran'];
// loop semua data keranjang, $_SESSION['keranjang'][$produk_id] = $jumlah
foreach ($keranjang as $produk_id => $jumlah) :
    // filter/saring produk berdasarkan id
    $filter_produk = array_filter($array_produk, function($produknya_array) use ($produk_id){
      return $produknya_array['ProdukId'] == $produk_id;
    });
    // jika tidak ada produk yang ditemukan, lompati data ini dan lanjut data berikutnya
    if(empty($filter_produk)){
      continue;
    }
    // ambil nama produk yang ditemukan
    $produk_ditemukan = array_pop($filter_produk);

    // ditemukan stok kurang
    if ($produk_ditemukan['Stok'] < $jumlah) :
    ?>
        <script>
            alert('Stok Produk <?=$produk_ditemukan['NamaProduk']?> kurang dari jumlah');
            document.location = "homekasir.php?pg=formpenjualan";
        </script>
    <?php
        exit;
    endif;

    // tambah persiapkan data detail untuk dimasukkan ke database nantinya
    array_push($persiapan_data_detail, [
        'ProdukId' => $produk_ditemukan['ProdukId'],
        'JumlahProduk' => $jumlah,
        'SubTotal' => $jumlah * $produk_ditemukan['Harga'],
    ]);

    // totalkan harga
    $total_harga += $jumlah * $produk_ditemukan['Harga'];
endforeach;

if($pembayaran < $total_harga):
    ?>
        <script>
            alert('Pembayaran anda kurang dari harga total barang');
           
        </script>
    <?php
    exit;
endif;


// buat transaksi database (dalam cakupan transaksi, jika ditemukan gagal pada salah satu query maka query lainnya dalam cakupan transaksi bisa dibatalkan (kecuali query tertentu))
// https://medium.com/gits-apps-insight/mengenal-konsep-database-transaction-bagian-1-54e66789f75e
mysqli_begin_transaction($koneksi);
// tangkap semua error throwable
try {
    $tanggal_penjualan = date('Y-m-d'); //Y = 4 digit tahun, m = 2 digit bulan, d = 2 digit hari. ex: 2024-03-24
    $persiapan_query = mysqli_prepare($koneksi, "INSERT INTO penjualan(PelangganId, TanggalPenjualan, TotalHarga, Pembayaran) VALUES(?, ?, ?, ?)"
    );
    mysqli_stmt_bind_param($persiapan_query,"isdd",$pelanggan_id,$tanggal_penjualan,$total_harga, $pembayaran);
    $eksekusi_query = mysqli_stmt_execute($persiapan_query);
    if( ! $eksekusi_query){
        throw new Exception($message = 'Gagal menambah penjualan');
    }

    $id_penjualan_baru = mysqli_insert_id($koneksi);
    foreach($persiapan_data_detail as $index => $data_detail){
        // tambah detail penjualan
        $persiapan_query = mysqli_prepare($koneksi, "INSERT INTO detailpenjualan(PenjualanId, ProdukId, JumlahProduk, SubTotal) VALUES(?, ?, ?, ?)"
        );
        mysqli_stmt_bind_param($persiapan_query,"iiid",$id_penjualan_baru,$data_detail['ProdukId'],$data_detail['JumlahProduk'], $data_detail['SubTotal']);
        $eksekusi_query = mysqli_stmt_execute($persiapan_query);
        if( ! $eksekusi_query){
            throw new Exception($message = "Gagal menambah detail penjualan ke " . ($index + 1));
        }
        // kurangi stok produk
        $persiapan_query = mysqli_prepare($koneksi, "UPDATE produk SET Stok = Stok - ? WHERE ProdukId = ?");
        mysqli_stmt_bind_param($persiapan_query,"ii",$data_detail['JumlahProduk'],$data_detail['ProdukId']);
        $eksekusi_query = mysqli_stmt_execute($persiapan_query);
        if( ! $eksekusi_query){
            throw new Exception($message = "Gagal menambah detail penjualan ke " . ($index + 1));
        }
    }

    // simpan jika tidak ada yang error
    mysqli_commit($koneksi);
    // kosongkan keranjang
    unset($_SESSION['keranjang']);

} catch (\Throwable $th) {
    // batalkan transaksi database jika ada error
    mysqli_rollback($koneksi);
    ?>
        <script>
            alert(`<?=$th->getMessage()?>`);
            document.location = "homekasir.php?pg=formpenjualan";
        </script>
    <?php
    exit;
}

?>
<script>
    alert('Penjualan Berhasil');
    document.location = "homekasir.php?pg=detailpenjualan&idnya=<?=$id_penjualan_baru?>";
</script>