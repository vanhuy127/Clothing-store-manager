<?php
require_once "../config/db.php";
require_once "../query/productDetail/ProductDetailBO.php";

// Lấy tham số màu sắc và kích thước từ AJAX request
$color = $_GET['color'];
$size = $_GET['size'];
$productId = $_GET['productId'];

$productDetailBO = new ProductDetailBO($conn);
$product = $productDetailBO->getProductDetailByID((int)$productId);
$variants = $product->getVariants();

$price = 0;
$stock = 0;
$vid = 0;
foreach ($variants as $v) {
    if (strtolower($v['colorCode']) == strtolower($color) && strtolower($v['sizeName']) == strtolower($size)) {
        $price = $v['price'];
        $stock = $v['stock'];
        $vid = $v['id'];
        break;
    }
}

$formattedPrice = $price > 0 ? number_format($price, 0, ',', '.') . ' VND' : 0;

if ($price > 0) {
    $response = array(
        'success' => true,
        'price' => $formattedPrice,
        'stock' => $stock,
        'vid' => $vid
    );
} else {
    $response = array(
        'success' => false,
        'price' => "Giá chưa được thiết lập cho biến thể này!!!",
        'stock' => "Tồn kho chưa được thiết lập cho biến thể này!!!",
        'vid' => 0
    );
}

// Set proper content type and return the JSON response
header('Content-Type: application/json');
echo json_encode($response);
exit; // Ensure no other output occurs after this