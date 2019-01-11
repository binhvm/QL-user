<?php
session_start();
require_once("lib/connection.php");

$username= $password= "";
$usernameErr= $passwordErr= "";

if ($_SERVER["REQUEST_METHOD"]== "POST") {
	//Làm sạch thông tin
	$username= strip_tags($username);
	$username= addslashes($username);
	$password= strip_tags($password);
	$password= addslashes($password);

	//Kiểm tra trường TÊN ĐĂNG NHẬP
	if (empty($_POST["username"])) {
		$usernameErr= "Bạn chưa điền TÊN ĐĂNG NHẬP.";
	}else{
		$username= test_input($_POST["username"]);
	}

	//Kiểm tra trường MẬT KHẨU
	if (empty($_POST["password"])) {
		$passwordErr= "Bạn chưa điền MẬT KHẨU.";
	}else{
		$password= test_input($_POST["password"]);
	}
	if ($usernameErr== "" && $passwordErr== "") {
		$password= md5($password);
		$sql= "SELECT * FROM users WHERE username= '$username' AND password = '$password'";
		$query= mysqli_query($conn, $sql);
		$num_rows= mysqli_num_rows($query);
		if ($num_rows==0) {
			echo "TÊN ĐĂNG NHẬP hoặc MẬT KHẨU không đúng.";
		}else{
			while ($data= mysqli_fetch_array($query)) {
				$_SESSION["id_user"]= $data["id"];
				$_SESSION['username']= $data["username"];
				$_SESSION["email"]= $data["email"];
				$_SESSION["name"]= $data["name"];
				$_SESSION["level"]= $data["level"];
				header('Location: trang-chu.php');
			}
		}
	}
}

	function test_input($data) {
	  $data = trim($data);
	  return $data;
	}
?>





<!DOCTYPE html>
<html>
<head>
	<title>Đăng nhập</title>
	<meta charset="utf-8">
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <style type="text/css">
    	a:hover{
    		text-decoration: none;
    	}
    	.error{
    		color: #FF0000;
    	}
    	td{
    		width: 75%;
    	}
    	td:first-child{
    		width: 25%;
    	}
    </style>
</head>
<body>
	<div class="container">
		<div class="row">
			<form action="dang-nhap.php" method="post">
				<h1>ĐĂNG NHẬP</h1>
				<p><span class="error"> * Thông tin bắt buộc</span></p>
				<table class="table">
					<tr>
						<td>Tên đăng nhập: </td>
						<td>
							<input type="text" name="username" id="username" size="40" value="<?php echo $username; ?>">
							<span class="error"> * <?php echo $usernameErr; ?></span>
						</td>
					</tr>
					<tr>
						<td>Mật khẩu: </td>
						<td>
							<input type="password" name="password" id="password" size="40" value="<?php echo $password; ?>">
							<span class="error"> * <?php echo $passwordErr; ?></span>
						</td>
					</tr>
					<tr>
						<td></td>
						<td><input type="submit" name="btn_dnhap" value="ĐĂNG NHẬP"></td>
					</tr>
				</table>
			</form>
			<a href="trang-chu.php">Trang chủ</a> | 
			<a href="dang-ky.php">Đăng ký</a> |
			<a href="#">Quên mật khẩu</a>
		</div>
	</div>
</body>
</html>