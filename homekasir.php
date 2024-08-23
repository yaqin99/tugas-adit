<!DOCTYPE html>
<?php
include "koneksi.php";
session_start();
if(isset($_SESSION['LoginId']))
    {
        echo "<p align=center><font face=cambria color=white> ANDA LOGIN SEBAGAI $_SESSION[Username]</font><p>";
    }
    else
    {
?>
    <script language="javascript">
    alert("ANDA HARUS LOGIN UNTUK MENGAKSES HALAMAN INI"); document.location="index.php";
    </script>
    <?php
    }
?>

<html>
    <head>
        <title>home guru</title>
        <link href="homekasir.css" rel="stylesheet" type="text/css"/>
        <style>
            body {
            background-image:url(gambar/bg5.jpg);
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            height: 100%;
            }
        </style>
    </head>
    <body background="header.jpg" text="brown" link="brown" vlink="brown" font face="Cambria">
        <div id="halamanutama">
            <div id="header"></div>
                <div id="menu">
                    <table cellspacing="0" cellpadding="10">
                    <tr>
                        <td>
                            <a href="homekasir.php">HOME</a>
                        </td>
                        <td>
                            <a href="homekasir.php?pg=forminputpelanggan">INPUT DATA PELANGGAN</a>
                        </td>
                        <td>
                            <a href="homekasir.php?pg=forminputproduk">INPUT DATA PRODUK</a>
                        </td>
                        <td>
                            <a href="homekasir.php?pg=formpenjualan">TRANSAKSI PENJUALAN</a>
                        </td>
                        <td>
                            <a href="homekasir.php?pg=riwayatpenjualan">RIWAYAT TRANSAKSI PENJUALAN</a>
                        </td>
                        <td>
                            <a href="logout.php">LOGOUT</a>
                        </td>
                    </tr>
                    </table>
                </div>

                <div id="isi">
                    <p>
                        <?php
                        if(isset($_GET['pg'])){
                        include "". $_GET['pg'] . ".php";
                        }
                        ?>
                    </p>
                </div>
                <div id="footer"></div>
        </div>
    </body>
</html>
