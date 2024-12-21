<?php
require_once "../../config/db.php";
require_once "../../query/cart/CartBO.php";
require_once "../../query/cart/Cart.php";
require_once "../../query/constant/Role.php";

session_start();
if (isset($_SESSION['roles']) && in_array(Role::$CUSTOMER, $_SESSION['roles'])) {
    $id = $_GET['id'];
    $vid = $_GET['vid'];
    $quantity = $_GET['quantity'] ?? 1;
    $cartBO = new CartBO($conn);
    $cartBO->addProductToCart($id, $vid, $quantity);
    // Lấy URL của trang trước đó
    $previousPage = $_SERVER['HTTP_REFERER'] ?? '../shop.php';

    // Điều hướng trở lại trang gọi đến
    header("Location: $previousPage");
    exit();
} else {
    header("Location: ../../index.php");
    $previousPage = $_SERVER['HTTP_REFERER'] ?? '../shop.php';
    // Điều hướng trở lại trang gọi đến
    header("Location: $previousPage");
    exit();
}
