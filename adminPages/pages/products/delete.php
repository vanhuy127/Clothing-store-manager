<?php
require_once "../../../config/db.php";
// require_once "../../../query/product/Product.php";
require_once "../../../query/product/ProductBO.php";
$productBO = new ProductBO($conn);

$id = $_GET['id'];

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {

if ($productBO->deleteProduct($id) == 1) {
    header("Location: _index.php?page=show");
    exit();
} else {
    header("Location: _index.php?page=show");
    exit();
}
// }