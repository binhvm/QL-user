
<?php
//Kiểm tra người dùng đã đăng nhập hay chưa?
if (isset($_SESSION['username'])== false) {
	
	//Nếu chưa thì chuyển hướng về trang đăng nhập
	header('Location: ../dang-nhap.php');
}else{

	//Nếu đã đăng nhập
	if (isset($_SESSION['level'])== true) {
		$level= $_SESSION['level'];
		
		//Kiểm tra cấp độ người dùng
		if ($level!= '1') {
			echo "Bạn không đủ quyền truy cập vào trang này.<br>";
			echo "<a href='http://localhost/thuctap/Binh/trang-chu.php'> Click để về lại trang chủ</a>";
			exit();
		}
	}
}
?>