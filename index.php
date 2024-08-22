<html>
    <head>
        <title>FORM LOGIN</title>
        <link href="index.css" rel="stlesheet" type="text/css">
        <style>
            body{
                background-image: url(gambar/bglogin.jpeg);
                background-size: cover;
                background-repeat: no-repeat
                background-position: center;
                background-attachment: fixed;
                height: 100%;
            }
            .title{
                text-align: center;
                font-size: 2.5em;
                color: black;
                background-color: none;
            }
            .container{
                width: 100px;
                height: 200px;
                position: absolute;
                left: 60%;
                top: 40%;
            }
        </style>
    </head>
    <body>
        <h1 class="title"> APLIKASI KASIR FADHLAN</h1>
        <div class="container">
        <fieldset>
            <legend>LOGIN ADMIN KASIR</legend>
                <form method="post" action="login2.php">
                    <table border="0" cellspacing="5" cellpadding="10">
                        <tr>
                            <td>
                            <input type="text" name="Username" style="width: 400; height: 50; font-size: 20px; text-align: center; background-color: white;" placeholder="Username">
                            </td>
                        </tr>
                        <tr>
                            <td>
                            <input type="password" name="Password" style="width: 400; height: 50; font-size:20px; text-align: center; background-color: white;" placeholder="Password">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" align="right">
                            <input type="submit" value="LOGIN" style="width: 100; height: 30; color: white; background: black;">
                            </td>
                        </tr>
                    </table>
                </form>
        </fieldset>
        </div>
    </body>
</html>

