<?php
if(basename($_SERVER["PHP_SELF"]) != "homekasir.php") {
    ?>
    <script language="javascript">
        alert("FILE HARUS DIAKSES OLEH HOMEKASIR.PHP");
        document.location = "homekasir.php";
    </script>
    <?php
    exit();
}

// Cek apakah pengguna sudah login
if (isset($_SESSION['LoginId'])) {
    echo "<h2 align=center><B><font face=cambria color=white size=5>PELANGGAN</font></B></h2><p>";
} else {
    ?>
    <script language="javascript">
        alert("ANDA HARUS LOGIN DULU UNTUK BISA MENGAKSES HALAMAN INI");
        document.location = "index.php";
    </script>
    <?php
    exit();
}

// Hapus data jika parameter 'delete' ada
if (isset($_GET['delete'])) {
    $idToDelete = intval($_GET['delete']);
    $deleteQuery = "DELETE FROM penjualan WHERE PenjualanId = $idToDelete";
    if (mysqli_query($koneksi, $deleteQuery)) {
        echo "<script>alert('Data berhasil dihapus.'); window.location.href='homekasir.php?pg=riwayatpenjualan';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat menghapus data.'); window.location.href='homekasir.php?pg=riwayatpenjualan';</script>";
    }
}
?>
<html>
<head>
    <title>FORM DATA RIWAYAT PENJUALAN</title>
    <link href="index.css" rel="stylesheet" type="text/css">
</head>
<body>
<div align="center">
    <fieldset>
        <legend>DATA RIWAYAT PENJUALAN</legend>
        <table border="1" cellspacing="0" cellpadding="10">
            <tr>
                <td><div align="center"><strong>NO</strong></div></td>
                <td><div align="center"><strong>TANGGAL PENJUALAN</strong></div></td>
                <td><div align="center"><strong>PELANGGAN</strong></div></td>
                <td><div align="center"><strong>TOTAL HARGA</strong></div></td>
                <td><div align="center"><strong>PEMBAYARAN</strong></div></td>
                <td><div align="center"><strong>KEMBALIAN</strong></div></td>
                <td><div align="center"><strong>RIWAYAT</strong></div></td>
                <td><div align="center"><strong>ACTION</strong></div></td>
            </tr>

            <?php
            $no = 1;
            $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
            // Jumlah data per halaman
            $limit = 5;
            $limitStart = ($page - 1) * $limit;
            $ambil = mysqli_query($koneksi, "SELECT * FROM penjualan
            LEFT JOIN pelanggan ON pelanggan.PelangganId =
            penjualan.PelangganId LIMIT ".$limitStart.",".$limit);
            $no = $limitStart + 1;
            while ($array = mysqli_fetch_array($ambil,MYSQLI_ASSOC)) {
                ?>
                <tr>
                <td><div align="center"><?php echo "$no"; $no++; ?></div></td>
						<td><div align="center"><?php echo "$array[Tanggalpenjualan]"; ?></div></td>
						<td><div align="center"><?php echo "$array[NamaPelanggan]"; ?></div></td>
						<td><div align="center"><?php echo 'Rp.'.number_format("$array[Totalharga]"); ?></div></td>
						<td><div align="center"><?php echo 'Rp.'.number_format("$array[Pembayaran]"); ?></div></td>
						<td><div align="center"><?= 'Rp.'.number_format($array['Pembayaran'] - $array['Totalharga'])  ?></div></td>
                        <td><div align="center">
                        <a href="homekasir.php?pg=detailpenjualan&idnya=<?php echo $array['PenjualanId']; ?>">DETAIL</a> </div></td><td><div align="center">
                        <a href="homekasir.php?pg=riwayatpenjualan&delete=<?php echo $array['PenjualanId']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">HAPUS</a></div></td>
                </tr>
                <?php
            }
            ?>
        </table>
        <p><p>
        <?php
        $no = 1;
        function rupiah($angka){
            $hasil_rupiah = "Rp. ". number_format($angka,0,',','.');
            return $hasil_rupiah;
        }
        // Jika page = 1, maka LinkPrev disable
        if ($page == 1) {
            ?>
            <!-- link Previous Page disable -->
            <a href="#">Kembali</a>
            <?php
        } else {
            $LinkPrev = ($page > 1) ? $page - 1 : 1;
            ?>
            <!-- link Previous Page -->
            <a href="homekasir.php?pg=riwayatpenjualan&page=<?php echo $LinkPrev; ?>">Kembali</a>&nbsp; &nbsp; &nbsp; &nbsp;
            <?php
        }
        $SqlQuery = mysqli_query($koneksi, "SELECT * FROM penjualan
        LEFT JOIN pelanggan ON pelanggan.PelangganId =
        penjualan.PelangganId");
        // Hitung semua jumlah data yang berada pada riwayat penjualan
        $JumlahData = mysqli_num_rows($SqlQuery);
        // Hitung jumlah halaman yang tersedia
        $jumlahPage = ceil($JumlahData / $limit);
        // Jumlah link number
        $jumlahNumber = 1;
        // Untuk awal link number
        $startNumber = ($page > $jumlahNumber) ? $page - $jumlahNumber : 1;
        // Untuk akhir link number
        $endNumber = ($page < ($jumlahPage - $jumlahNumber)) ? $page + $jumlahNumber : $jumlahPage;
        for ($i = $startNumber; $i <= $endNumber; $i++) {
            $linkActive = ($page == $i) ? '' : '';
            ?>
            <?php echo $linkActive; ?>
            <a href="homekasir.php?pg=riwayatpenjualan&page=<?php echo $i; ?>">&nbsp; &nbsp; &nbsp; <?php echo $i; ?>&nbsp; &nbsp; &nbsp;</a>
            <?php
        }
        ?>
        <!-- link Next Page -->
        <?php
        if ($page == $jumlahPage) {
            ?>
            <a href="#">Lanjut</a>
            <?php
        } else {
            $linkNext = ($page < $jumlahPage) ? $page + 1 : $jumlahPage;
            ?>
            <a href="homekasir.php?pg=riwayatpenjualan&page=<?php echo $linkNext; ?>">Lanjut</a>
            <?php
        }
        ?>
    </fieldset>
</div>
</body>
</html>