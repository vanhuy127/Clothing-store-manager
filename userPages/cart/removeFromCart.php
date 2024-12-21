<?php
require_once "../../config/db.php";
require_once "../../query/cart/CartBO.php";
require_once "../../query/cart/Cart.php";

$id = $_GET['id'];
$vid = $_GET['vid'];
$cartBO = new CartBO($conn);
$cartBO->removeProductFromCart($id, $vid);
// Lấy URL của trang trước đó
$previousPage = $_SERVER['HTTP_REFERER'] ?? '../shop.php';

// Điều hướng trở lại trang gọi đến
header("Location: $previousPage");
exit();
