<?php
	require_once("../lib/connection.php");
	session_start();
	include("phan-quyen.php");

	//Thực hiện hiển thị thông tin từ cơ sở dữ liệu
	$id_user= $_GET["id"];
	$sql= "SELECT * FROM users WHERE id= $id_user";
	$query= mysqli_query($conn, $sql);
	while ($data= mysqli_fetch_array($query) ) {
		$username= $data["username"];
		$name= $data["name"];
		$email= $data["email"];
		$birth= $data["birth"];
		$sex= $data["sex"];
		$level= $data["level"];
	}
          
	//Bắt sự kiện click vào nút Xóa
	if (isset($_POST["btn_xoa"])) {

	//Xóa thông tin khỏi cơ sở dữ liệu
	$id_user= $_GET["id"];
	$sql= "DELETE FROM users WHERE id = $id_user";
	$query= mysqli_query($conn, $sql);

	//Sau khi thực hiện xóa thì chuyển sang trang QUẢN LÝ THÀNH VIÊN
	header('Location: ql-thanh-vien.php');
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
			<h1>Xóa thành viên </h1>
			<form method="post" name="fr_update">
				<table class="table">
					<input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
					<tr>
						<td>Tên đăng nhập: </td>
						<td><?php echo $username; ?></td>
					</tr>
					<tr>
						<td>Họ và tên: </td>
						<td><?php echo $name; ?></td>
					</tr>
					<tr>
						<td>Địa chỉ email: </td>
						<td><?php echo $email; ?></td>
					</tr>
					<tr>
						<td>Ngày sinh: </td>
						<td><?php echo $birth; ?></td>
					</tr>
					<tr>
						<td>Giới tính: </td>
						<td><?php echo $sex; ?></td>
					</tr>
					<tr>
						<td>Cấp độ: </td>
						<td>
							<?php
							if ($level==1) {
								echo "Quản trị";
							}else{
								echo "Thành viên";
							}
							?>
						</td>
					</tr>
					<tr>
						<td></td>
						<td><input type="submit" name="btn_xoa" value="XÓA THÀNH VIÊN"></td>
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