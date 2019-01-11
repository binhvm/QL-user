<?php
session_start();
session_destroy();
header('Location: trang-chu.php');
?>