<?php
require_once "../../../config/db.php";
require_once "../../../query/image/ImageBO.php";
require_once "../../../query/image/Image.php";

$imageBO = new ImageBO($conn);
$id = $_GET['id']; // ID của ảnh
$productID = $_GET['productID']; // ID của sản phẩm

// Lấy thông tin ảnh trước khi xóa
$image = $imageBO->showImageByID($id);
if ($image) {
    // Đường dẫn tệp ảnh
    $targetDir = "../../../image-storage/";
    $filePath = $targetDir . $image->getPath();

    // Kiểm tra nếu tệp ảnh tồn tại và xóa tệp
    if (file_exists($filePath)) {
        unlink($filePath);  // Xóa tệp ảnh khỏi thư mục
    }

    // Xóa ảnh khỏi cơ sở dữ liệu
    $imageBO->deleteImage($id);
}
header("Location: _index.php?page=edit&id=$productID");
exit();
