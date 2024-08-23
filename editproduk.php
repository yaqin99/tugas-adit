<?php
include 'koneksi.php';
$id=$_POST["ProdukId"];
$produk=$_POST["produk"];
$gb=$_FILES['foto'] ['type'];
$type_gambar=$FILES['foto'] ['type'];
$lokasi=$_FILES['foto'] ['tmp_name'];
$harga=$_POST["harga"];
$stok=$_POST['stok'];

if(empty($lokasi))
{
$persiapan_query = mysqli_prepare($koneksi, "UPDATE produk SET NamaProduk=?, Harga=?, Stok=? WHERE ProdukId=?");
mysqli_stmt_bind_param($persiapan_query,"sdii",$produk,$harga,$stok,$id);
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
header('location:homekasir.php?pg=forminputproduk');
exit();
}
else{
    if($type_gambar !="image/gif" AND
        $type_gambar !="image/jpeg" AND
        $type_gambar !="image/jpg" AND
        $type_gambar !="image/png")
{
    echo "upload gagal !!<br>
    Tipe file <b>$gb</b>:$type_gambar <br>
    Tipe file yang boleh di upload jpeg,gif,jpg,png<br>
	pastikan semua field di isi
	<p><a href='forminputproduk.php' kembali ke awal</a></p>";
	exit();
}
    $persiapan_query=mysqli_prepare($koneksi,"UPDATE produk SET namaproduk=?,foto=? ,harga?, stok=? WHERE idproduk=?");
    mysqli_stmt_bind_param($persiapan_query,"ssdii",
    $produk,$gb,$harga,$stok,$id);

    $eksekusi_query=mysqli_stmt_execute($persiapan_query);
    if($eksekusi_query-false){
    ?>
    <script language="javascript">
        alert("<?php echo mysqli_stmt_error($persiapan_query);?>");
        history.go(-1)
    </script>
    <?php
    exit();
    }
$simpan_ke="gambar/" .$gb;
move_uploaded_file($lokasi_file, $simpan_ke);
header('location:homekasir.php?pg=forminputproduk');
}
?>