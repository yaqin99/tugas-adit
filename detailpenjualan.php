<?php
if (basename ($_SERVER ["PHP_SELF"]) != "homekasir.php") {
    ?>
    <script language="javascript">
        alert("FILE HARUS DIAKSES OLEH HOMEKASIR.PHP");
        document.location = "homekasir.php";
    </script>
    <?php
    exit();
}
if (isset($_SESSION['LoginId'])) {
    echo "<h2 align=center><B><font face= cambria color=black size=5>PELANGGAN</font></B></h2><p>";
} else {
    ?>
    <script language="javascript">
        alert("ANDA HARUS LOGIN DULU UNTUK BISA MENGAKSES HALAMAN INI");
        document.location = "index.php";
    </script>
    <?php
    exit();
}

// cek penjualan
$penjualan_id = $_GET['idnya'];
$persiapan_query = mysqli_prepare($koneksi, "SELECT * FROM penjualan LEFT JOIN pelanggan ON pelanggan.PelangganId = penjualan.PelangganId WHERE penjualanID = ?");
    mysqli_stmt_bind_param($persiapan_query, "i", $penjualan_id);
    $eksekusi_query = mysqli_stmt_execute ($persiapan_query);
    $ambil_hasil = mysqli_stmt_get_result ($persiapan_query);

// jadikan array
$array_penjualan = mysqli_fetch_assoc($ambil_hasil);

// jika datanya tidak ditemukan
if (mysqli_num_rows($ambil_hasil) != 1) :
    ?>
        <script>
            alert('Penjualan tidak ditemukan');
            document.location = "homekasir.php?pg=riwayatpenjualan";
        </script>
    <?php
        exit;
    endif;
    ?>

<html>
    <head>
        <title>FORM DATA DETAIL PENJUALAN</title>
        <link href="index.css" rel="stylesheet" type="text/css">
    </head>
    <div align="center"> 
    <body>
        <fieldset>
            <legend>PENJUALAN</legend>
            <form method="post" action="inputproduk.php">
                <table border="0" cellspacing="0" cellpadding="10">
                    <tr>
                        <td>Kasir</td>
                        <td><?=$_SESSION["Username"] ?></td>
                    </tr>
                    <tr>
                        <td>Pelanggan</td>
                        <td><?=$array_penjualan['NamaPelanggan']?></td>
                    </tr>
                    <tr>
                        <td>Tanggal penjualan</td>
                        <td><?=$array_penjualan['Tanggalpenjualan']?></td>
                    </tr>
                    <tr>
                        <td>Total Harga</td>
                        <td><?= 'Rp.'.number_format($array_penjualan['Totalharga']);?></td>
                    </tr>
                    <tr>
                        <td>Pembayaran</td>
                        <td><?='Rp.'.number_format($array_penjualan['Pembayaran']);?></td>
                    </tr>
                    <tr>
                        <td>Kembalian</td>
                        <td><?=$array_penjualan['Pembayaran'] - $array_penjualan ['Totalharga']?></td>
                    </tr>
                </table>
            </form>

                <table border="1" cellspacing="0" cellpadding="10">
                    <tr>
                        <td>
                            <div align="center"><strong>NO</strong></div>
                        </td>
                        <td>
                            <div align="center"><strong>NAMA PRODUK</strong></div>
                        </td>
                        <td>
                            <div align="center"><strong>HARGA</strong></div>
                        </td>
                        <td>
                            <div align="center"><strong>JUMLAH</strong></div>
                        </td>
                        <td colspan="2">
                            <div align="center"><strong>SUB TOTAL</strong></div>
                        </td>
                    </tr>

                    <?php
                    $no = 1;
                    function rupiah($angka){
                        $hasil_rupiah="Rp". number_format($angka,2,',','.');
                        return $hasil_rupiah;
                    }
                    $persiapan_query = mysqli_prepare ($koneksi, "SELECT * FROM detailpenjualan LEFT JOIN
                    produk ON produk.ProdukId = detailpenjualan.ProdukId WHERE penjualanID = ?");
                    mysqli_stmt_bind_param($persiapan_query, "i", $penjualan_id);
                    $eksekusi_query = mysqli_stmt_execute ($persiapan_query);
                    $ambil_hasil = mysqli_stmt_get_result ($persiapan_query);

                    // jadikan array
                    $array_detail_penjualan = mysqli_fetch_all($ambil_hasil, MYSQLI_ASSOC);
                    foreach ($array_detail_penjualan as $detail_produk):
                    ?>
                    <tr>
                        <td>
                            <div align="center"><?php echo "$no"; $no++; ?></div>
                        </td>
                        <td>
                            <div align="center"><?php echo "$detail_produk[NamaProduk]"; ?></div>
                        </td>
                        <td>
                            <div align="center"><?php echo 'Rp.'.number_format($detail_produk['SubTotal'] / $detail_produk['JumlahProduk']); ?></div>
                        </td>
                        <td>
                            <div align="center"><?php echo "$detail_produk[JumlahProduk]"; ?></div>
                        </td>
                        <td colspan="2">
                            <div align="center"><?php echo 'Rp.'.number_format("$detail_produk[SubTotal]"); ?></div>
                        </td>
                    </tr>

                    <?php
                    endforeach;
                    ?>
                    
                    <tr>
                    <td colspan="4">
                        <div align="right"><strong>TOTAL</strong></div>
                    </td>
                    <td>
                        <div align="center"><strong><?= 'Rp.'.number_format($array_penjualan ['Totalharga']);?></strong></div>
                    </td>
                    </tr>
                </table>
        </fieldset>
    </div>
    </body>
</html>