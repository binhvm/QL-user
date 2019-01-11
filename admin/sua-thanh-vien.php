<?php
	require_once("../lib/connection.php");
	session_start();
	include("phan-quyen.php");

	$id= $username= $name= $email= $birth= $sex= $level= "";
	$usernameErr= $nameErr= $birthErr= $sexErr= $emailErr= "";
	
	if (isset($_GET["id"])) {
		
		//Hiển thị thông tin để thay đổi
		$id= $_GET["id"];
		$sql= "SELECT * FROM users WHERE id= $id";
		$query= mysqli_query($conn, $sql);
		while ($data= mysqli_fetch_array($query)) {
			$username= $data["username"];
			$name= $data["name"];
			$email= $data["email"];
			$birth= $data["birth"];
			$sex= $data["sex"];
			$level= $data["level"];
		}
	}

	//Bắt sự kiện vào nút LƯU THÔNG TIN
	if (isset($_POST["btn_luu"])) {
		$id_user= $_POST["id_user"];
		$username= $_POST["username"];
		$name= $_POST["name"];
		$email= $_POST["email"];
		$birth= $_POST["birth"];
		$sex= $_POST["sex"];
		$level= $_POST["level"];

		//Kiểm tra trường TÊN ĐĂNG NHẬP
		if (empty($_POST["username"])) {
			$usernameErr= "Bạn chưa điền TÊN ĐĂNG NHẬP.";
		}else{
			$username= test_input($_POST["username"]);
			$sql= "SELECT * FROM users WHERE username= '$username' AND id!= '$id_user'";
			$kt= mysqli_query($conn, $sql);
			if (mysqli_num_rows($kt)> 0) {
				$usernameErr= "TÊN ĐĂNG NHẬP đã tồn tại.";
			}
		}
		
		//Kiểm tra trường HỌ VÀ TÊN
		if (empty($_POST["name"])) {
			$nameErr= "Bạn chưa điền HỌ VÀ TÊN.";
		}else{
			$name= test_input($_POST["name"]);
		}

		//Kiểm tra trường EMAIL
		if (empty($_POST["email"])) {
			$emailErr= "Bạn chưa điền EMAIL.";
		}else{
			$email= test_input($_POST["email"]);
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	  			$emailErr= "EMAIL không đúng định dạng.";
	  		}else{
	  			$email= test_input($_POST["email"]);
				$sql= "SELECT * FROM users WHERE email= '$email' AND id!= '$id_user'";
				$kt= mysqli_query($conn, $sql);
				if (mysqli_num_rows($kt)> 0) {
					$emailErr= "EMAIL đã tồn tại.";
				}
	  		}
		}

		//Kiểm tra trường NGÀY SINH
		if (empty($_POST["birth"])) {
			$birthErr= "Bạn chưa điền NGÀY SINH.";
		}else{
			$birth= test_input($_POST["birth"]);
		}

		//Cập nhật thông tin vào DATABASE
		if ($usernameErr== "" && $nameErr== "" && $emailErr== "" && $birthErr== "") {
			$sql= "UPDATE users SET username= '$username', name= '$name', email= '$email', birth= '$birth', sex= '$sex', level= '$level' WHERE id= '$id_user'";
			mysqli_query($conn, $sql);
			header('Location: ql-thanh-vien.php');
		}
	}

	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
?>





<!DOCTYPE html>
<html>
<head>
	<title>Thay đổi thông tin thành viên</title>
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
			<h1>Thay đổi thông tin thành viên</h1>
			<form method="post" name="fr_update">
				<table class="table">
					<input type="hidden" name="id_user" value="<?php echo $id; ?>">
					<tr>
						<td>Tên đăng nhập: </td>
						<td>
							<input type="text" name="username" size="40" value="<?php echo $username; ?>">
							<span class="error"> * <?php echo $usernameErr; ?></span>
						</td>
					</tr>
					<tr>
						<td>Mật khẩu: </td>
						<td><a href="doi-mat-khau.php?id=<?php echo $id; ?>">Thay đổi mật khẩu</a></td>
					</tr>
					<tr>
						<td>Họ và tên: </td>
						<td>
							<input type="text" name="name" size="40" value="<?php echo $name; ?>">
							<span class="error"> * <?php echo $nameErr; ?></span>
						</td>
					</tr>
					<tr>
						<td>Địa chỉ email: </td>
						<td>
							<input type="text" name="email" size="40" value="<?php echo $email; ?>">
							<span class="error"> * <?php echo $emailErr; ?></span>
						</td>
					</tr>
					<tr>
						<td>Ngày sinh: </td>
						<td>
							<input type="date" name="birth" value="<?php echo $birth; ?>">
							<span class="error"> * <?php echo $birthErr; ?></span>
						</td>
					</tr>
					<tr>
						<td>Giới tính: </td>
						<td>
							<input type="radio" name="sex" <?php if (isset($sex)&& $sex== "Nam")
								echo "checked";?> value="Nam"> Nam | 
							<input type="radio" name="sex" <?php if (isset($sex)&& $sex== "Nữ")
								echo "checked";?> value="Nữ"> Nữ
						</td>
					</tr>
					<tr>
						<td>Cấp độ: </td>
						<td>
							<select name="level">
								<option value= 1 <?php echo ($level== 1)? "selected":""; ?>>Quản trị</option>
								<option value= 2 <?php echo ($level!= 1)? "selected":""; ?>>Thành viên</option>
							</select>
						</td>
					</tr>
					<tr>
						<td></td>
						<td><input type="submit" name="btn_luu" value="LƯU THÔNG TIN"></td>
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