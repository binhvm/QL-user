<?php
	session_start();
	require_once("lib/connection.php");
?>





<!DOCTYPE html>
<html>
<head>
	<title>Trang chủ</title>
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
			<?php 	
				if (isset($_SESSION['username'])== false) {
					echo "Chào mừng: Khách";
					echo "<br>";
					echo '<a href="dang-ky.php">Đăng ký</a> | ';
					echo '<a href="dang-nhap.php">Đăng nhập</a>';
				}else{
					if (isset($_SESSION['username'])== true) {
						$level= $_SESSION['level'];
						if ($level!= 1) {
							echo "Chào mừng: ".$_SESSION['name'];
							echo "<br>";
							echo '<a href="thong-tin-tai-khoan.php">Thông tin tài khoản</a> | ';
							echo '<a href="dang-xuat.php">Đăng xuất</a>';
						}else{
							echo "Chào mừng: ".$_SESSION['name'];
							echo "<br>";
							echo '<a href="admin/ql-thanh-vien.php">Quản lý thành viên</a> | ';
							echo '<a href="thong-tin-tai-khoan.php">Thông tin tài khoản</a> | ';
							echo '<a href="dang-xuat.php">Đăng xuất</a>';
						}
					}
				}
			?>
		</div>
	</div>
</body>
</html>