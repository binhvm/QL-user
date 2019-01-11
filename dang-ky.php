<?php
	require_once("lib/connection.php");


	//Định nghĩa biến và gán giá trị rỗng cho các biến
	$username= $password= $repassword= $name= $email= $birth= $sex= $level= "";
	$usernameErr= $passwordErr= $repasswordErr= $nameErr= $emailErr= $birthErr= $sexErr= "";

	if ($_SERVER["REQUEST_METHOD"]== "POST") {

		//Kiểm tra trường ĐĂNG NHẬP
		if (empty($_POST["username"])) {
			$usernameErr= "Bạn chưa điền TÊN ĐĂNG NHẬP.";
		}else{
			$username= test_input($_POST["username"]);
			$sql= "SELECT * FROM users WHERE username= '$username'";
			$kt= mysqli_query($conn, $sql);
			if (mysqli_num_rows($kt)> 0) {
				$usernameErr= "TÊN ĐĂNG NHẬP đã tồn tại.";
			}
		}

		//Kiểm tra trường MẬT KHẨU
		if (empty($_POST["password"])) {
			$passwordErr= "Bạn chưa điền MẬT KHẨU.";
		}else{
			$password= test_input($_POST["password"]);
		}

		//Kiểm tra trường XÁC NHẬN MẬT KHẨU
		if (empty($_POST['repassword'])) {
			$repasswordErr= "Bạn chưa điền XÁC NHẬN MẬT KHẨU.";
		}else{
			$repassword= test_input($_POST["repassword"]);
			if ($repassword!= $password) {
				$repasswordErr= "XÁC NHẬN MẬT KHẨU không trùng khớp.";
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
  				$emailErr = "EMAIL không đúng định dạng.";
			}else{
				$sql= "SELECT * FROM users WHERE email= '$email'";
				$kt= mysqli_query($conn, $sql);
				if (mysqli_num_rows($kt)> 0) {
					$emailErr= "EMAIL đã tồn tại.";
				}
			}
		}

		//Kiểm tra trường NGÀY SINH
		if (empty($_POST["birth"])) {
			$birthErr= "Bạn chưa chọn NGÀY SINH.";
		}else{
			$birth= test_input($_POST["birth"]);
		}

		//Kiểm tra trường GIỚI TÍNH
		if (empty($_POST["sex"])) {
			$sexErr= "Bạn chưa chọn GIỚI TÍNH.";
		}else{
			$sex= test_input($_POST["sex"]);
		}
		
		//Lưu vào DATABASE
		if ($usernameErr== "" && $passwordErr== "" && $repasswordErr== "" && $nameErr== "" && $emailErr== "" && $birthErr== "" && $sexErr== "") {
			$sql= "INSERT INTO users (username, password, name, email, birth, sex, level)
					VALUES ('$username', md5('$password'), '$name', '$email', '$birth', '$sex', '2')";
			mysqli_query($conn, $sql);
			echo "Chúc mừng, bạn đã đăng ký thành công.";
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
	<title>Đăng ký thành viên</title>
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
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
				<h1>Đăng ký thành viên</h1>
				<p><span class="error">* Thông tin bắt buộc</span></p>
				<table class="table">
					<div class="form-group">
						<tr>
							<td>Tên đăng nhập: </td>
							<td>
								<input type="text" name="username" id="username" size="40" value="<?php echo $username; ?>">
								<span class="error"> * <?php echo $usernameErr; ?></span>
							</td>
						</tr>
					</div>
					<tr>
						<td>Mật khẩu: </td>
						<td>
							<input type="password" name="password" id="password" size="40" value="<?php echo $password; ?>">
							<span class="error"> * <?php echo $passwordErr; ?></span>
						</td>
					</tr>
					<tr>
						<td>Xác nhận mật khẩu: </td>
						<td>
							<input type="password" name="repassword" id="repassword" size="40" value="<?php echo $repassword; ?>">
							<span class="error"> * <?php echo $repasswordErr; ?></span>
						</td>
					</tr>
					<tr>
						<td>Họ và tên: </td>
						<td>
							<input type="text" name="name" id="name" size="40" value="<?php echo $name; ?>">
							<span class="error"> * <?php echo $nameErr; ?></span>
						</td>
					</tr>
					<tr>
						<td>Địa chỉ email: </td>
						<td>
							<input type="text" name="email" id="email" size="40" value="<?php echo $email; ?>">
							<span class="error"> * <?php echo $emailErr; ?></span>
						</td>
					</tr>
					<tr>
						<td>Ngày sinh: </td>
						<td>
							<input type="date" name="birth" id="birth" value="<?php echo $birth; ?>">
							<span class="error"> * <?php echo $birthErr; ?></span>
						</td>
					</tr>
					<tr>
						<td>Giới tính: </td>
						<td class="form-check-inline">
							<input type="radio" name="sex" <?php if (isset($sex)&& $sex== "Nam")
								echo "checked";?> value="Nam"> Nam | 
							<input type="radio" name="sex" <?php if (isset($sex)&& $sex== "Nữ")
								echo "checked";?> value="Nữ"> Nữ
							<span class="error"> * <?php echo $sexErr; ?></span>
						</td>
					</tr>
					<tr>
						<td>Cấp độ: </td>
						<td>Thành viên</td>
					</tr>
					<tr>
						<td></td>
						<td><input type="submit" name="btn_dky" class="btn btn-dark" value="ĐĂNG KÝ"></td>
					</tr>
				</table>
			</form>
			<a href="trang-chu.php">Trang chủ</a> | 
			<a href="dang-nhap.php">Đăng nhập</a>
		</div>
	</div>
</body>
</html>