<?php
	require_once("../lib/connection.php");
	session_start();
	include("phan-quyen.php");

	$id= $password= $repassword= "";
	$passwordErr= $repasswordErr= "";

	if (isset($_GET["id"])) {
		$id= $_GET["id"];
	}

	//Bắt sự kiện vào nút ĐỔI MẬT KHẨU
	if (isset($_POST["btn_doimk"])) {
		$id_user= $_POST["id_user"];
		$password= $_POST["password"];
		$repassword= $_POST["repassword"];

		//Kiểm tra trường MẬT KHẨU
		if (empty($_POST["password"])) {
			$passwordErr= "Bạn chưa điền MẬT KHẨU.";
		}else{
			$password= test_input($_POST["password"]);
		}

		//Kiểm tra trường XÁC NHẬN MẬT KHẨU
		if (empty($_POST["repassword"])) {
			$repasswordErr= "Bạn chưa điền XÁC NHẬN MẬT KHẨU.";
		}else{
			$repassword= test_input($_POST["repassword"]);
			if ($repassword!= $password) {
				$repasswordErr= "XÁC NHẬN MẬT KHẨU không đúng.";
			}
		}

		//Cập nhật MẬT KHẨU vào DATABASE
		if ($passwordErr== "" && $repasswordErr== "") {
			$password= md5($password);
			$sql= "UPDATE users SET password= '$password' WHERE id= '$id_user'";
			mysqli_query($conn, $sql);
			echo "Thay đổi mật khẩu thành công.";
		}	
	}
	
	function test_input($data) {
	  $data= trim($data);
	  $data= stripslashes($data);
	  $data= htmlspecialchars($data);
	  return $data;
	}

?>





<!DOCTYPE html>
<html>
<head>
	<title>Thay đổi mật khẩu thành viên</title>
	<meta charset="utf-8">
	<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
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
			<h1>Thay đổi mật khẩu thành viên</h1>
			<form method="post" name="fr_update">
				<table class="table">
					<input type="hidden" name="id_user" value="<?php echo $id; ?>">
					<tr>
						<td>Mật khẩu mới: </td>
						<td>
							<input type="password" name="password" size="40">
							<span class="error"> * <?php echo $passwordErr; ?></span>
						</td>
					</tr>
					<tr>
						<td>Xác nhận mật khẩu: </td>
						<td>
							<input type="password" name="repassword" size="40">
							<span class="error"> * <?php echo $repasswordErr; ?></span>
						</td>

					</tr>
					<tr>
						<td></td>
						<td><input type="submit" name="btn_doimk" value="ĐỔI MẬT KHẨU"></td>
					</tr>
				</table>
			</form>
			<a href="../trang-chu.php">Trang chủ</a> | 
			<a href="ql-thanh-vien.php">Quản lý thành viên</a> | 
			<a href="../dang-xuat.php">Đăng xuất</a>
		</div>
	</div>
</body>
</html>