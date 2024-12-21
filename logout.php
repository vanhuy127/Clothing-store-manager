<?php
session_start(); // Bắt đầu session

// Hủy tất cả các session
session_unset();
session_destroy();

// Điều hướng về trang đăng nhập
header("Location: login.php");
exit();
