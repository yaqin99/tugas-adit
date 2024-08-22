<?php
if(basename($_SERVER["PHP_SELF"]) != "homekasir.php"){
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
    <title>FORM DATA PELANGGAN</title>
    <link href="index.css" rel="stylesheet" type="text/css">
  </head>
  <div align="center">
  <body>
    <fieldset>
      <legend>INPUT DATA PELANGGAN</legend>
        <form method="post" action="inputpelanggan.php">
          <table border="0" cellspacing="0" cellpadding="10">
            <tr>
              <td>Nama Pelanggan</td>
              <td><input type="text" name="nama"></td>
            </tr>
            <tr>
              <td>Alamat</td>
              <td><input type="text" name="alamat"></td>
            </tr>
            <tr>
              <td>Nomor Telepon</td>
              <td><input type="tel" name="telepon" pattern="[0-9]+"minlngth="10" maxlength="12" required></td>
           </tr>
            <tr>
              <td>JenisKelamin</td>
              <td>
              <input type="radio" name="jeniskelamin"value="laki-laki">laki-laki
              <input type="radio" name="jeniskelamin"value="perempuan">perempuan
            </td>
            </tr>
            <tr>
              <td colspan="2" align="right"><input type="submit" value="SIMPAN">
            </tr>
          </table>
        </form>
    </fieldset>
    <p><p>
                
    <fieldset>
      <legend>DATA PELANGGAN</legend>
        <table border="1" cellspacing="0" cellpadding="10">
          <tr>
            <td><div align="center"><strong>NO</strong></div></td>
            <td><div align="center"><strong>NAMA PELANGGAN</strong></div></td>
            <td><div align="center"><strong>ALAMAT</strong></div></td> 
            <td><div align="center"><strong>NOMOR TELEPON</strong></div></td>
            <td><div align="center"><strong>JENISKELAMIN</strong></div></td>
            <td><div align="center"><strong>EDIT</strong></div></td>
            <td><div align="center"><strong>DELETE</strong></div></td>
          </tr>
                    
          <?php
          $no=1;
          $ambil=mysqli_query($koneksi,"SELECT * FROM pelanggan ORDER BY NamaPelanggan asc");
          while ($array=mysqli_fetch_array($ambil, MYSQLI_ASSOC))
          {
          ?>
          <tr>
            <td><div align="center"><?php echo"$no"; $no++; ?></div></td>
            <td><div align="center"><?php echo"$array[NamaPelanggan]"; ?></div></td>
            <td><div align="center"><?php echo"$array[Alamat]"; ?></div></td>
            <td><div align="center"><?php echo"$array[NomorTelepon]"; ?></div></td> 
            <td><div align="center"><?php echo"$array[JenisKelamin]"; ?></div></td> 
            <td><div align="center"><a href="homekasir.php?pg=formeditpelanggan&idnya=<?php echo $array['PelangganId'];?>">EDIT</a></div></td>
            <td><div align="center"><a href="deletepelanggan.php?idnya=<?php echo $array['PelangganId'];?>" onclick="return confirm('yakin akan dihapus?')">HAPUS</a></div></td></tr>
          <?php
          }
          ?>
        </table>
    </fieldset>
  </body>
  </div>
</html>