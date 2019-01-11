<?php
	require_once("../lib/connection.php");
	session_start();
	include("phan-quyen.php");
?>





<!DOCTYPE html>
<html>
<head>
	<title>Quản lý thành viên</title>
	<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <style type="text/css">
    	a:hover{
    		text-decoration: none;
    	}
    </style>
</head>
<body>
	<div class="container">
		<div class="row">
			<h1>Quản lý thành viên</h1>
			<div class="table-responsive">
				<table class="table table-striped">
					<caption>Danh sách thành viên đã đăng ký</caption>
					<thead class="thead-">
						<tr>
							<th>STT</th>
							<th>Tên đăng nhập</th>
							<th>Họ và tên</th>
							<th>Địa chỉ email</th>
							<th>Ngày sinh</th>
							<th>Giới tính</th>
							<th>Cấp độ</th>
							<th>Hành động</th>
						</tr>
					</thead>
					<tbody>
						<?php
	            			$stt= 1 ;
	            			$sql= "SELECT * FROM users";

				            //Thực thi câu $sql với biến conn lấy từ file connection.php
				            $query= mysqli_query($conn,$sql);
				            while ($data= mysqli_fetch_array($query)) {
	          			?>

						<!--Hiển thị thông tin từ cơ sở dữ liệu-->
			            <tr>
			              <th scope="row"><?php echo $stt++ ?></th>
			              <td><?php echo $data["username"]; ?></td>
			              <td><?php echo $data["name"]; ?></td>
			              <td><?php echo $data["email"]; ?></td>
			              <td><?php echo $data["birth"]; ?></td>
			              <td><?php echo $data["sex"]; ?></td>
			              <td>
			                <?php
			                    if ($data["level"]== 1) {
			                      echo "Quản trị";
			                    }else{
			                      echo "Thành viên";
			                    }
			                ?>
			              </td>
			              <td>
			              	<a href="sua-thanh-vien.php?id=<?php echo $data["id"]; ?>">Sửa</a> |
			              	<a href="xoa-thanh-vien.php?id=<?php echo $data["id"]; ?>">Xóa</a>
			              </td>
			            </tr>
				       	<?php
				       		}
				       	?>
					</tbody>
				</table>
			</div>
			<a href="../trang-chu.php">Trang chủ</a> | 
			<a href="them-thanh-vien.php">Thêm thành viên</a> | 
			<a href="../dang-xuat.php">Đăng xuất</a>
		</div>
	</div>
</body>
</html>