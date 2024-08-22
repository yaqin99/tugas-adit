<?php 
session_start();
include "koneksi.php";
if (isset($_POST['Username']) &&
isset($_POST['Password'])) {
		function validate($data){
		$data = trim($data);
				$data = stripslashes($data);
				$data = htmlspecialchars ($data);
				return $data;
		}
		$uname = validate($_POST['Username']);
		$pass = validate($_POST['Password']);
		
		if (empty($uname)) {
		header("Location: index.php?
		error=Username is required");
		exit();}
	else if(empty($pass)){
	header("Location: index.php?error=Password is required");
		exit();}
		else{
		$sql = "SELECT * FROM login WHERE
		Username='$uname' AND Password='$pass'";
		$result = mysqli_query($koneksi,$sql);
		
		if (mysqli_num_rows($result) === 1) {
			$row = mysqli_fetch_assoc($result);
			if ($row['Username']=== $uname &&
			$row['Password'] === $pass) {
			echo "Anda berhasil login!";
			
			$_SESSION['LoginId'] = $row['LoginId'];
			
			$_SESSION['Username']= $row['Username'];
			
			$_SESSION['Password']= $row['password'];
			header("Location: homekasir.php");
			exit();
		}else{
			header("Location: index.php?error=Incorect
			username or password");
			exit();
		}
		}else{
			header("Location: index.php?error=Incorect username or password");
		exit();
		}
}
}else{
	header("Location: index.php");
	exit();}
	?>
			