<?php
require_once __DIR__ . '/ImageDAO.php';
class ImageBO
{
    private $imageDAO;

    public function __construct($dbConnection)
    {
        $this->imageDAO = new ImageDAO($dbConnection);
    }

    // Thêm hình ảnh
    public function addImage(Image $image)
    {
        return $this->imageDAO->add($image);
    }

    // Hiển thị hình ảnh theo ID sản phẩm
    public function showImagesByProductID($productID)
    {
        return $this->imageDAO->showByProductID($productID);
    }

    public function showImageByID($imageID)
    {
        return $this->imageDAO->showByID($imageID);
    }

    // Hiển thị tất cả hình ảnh
    public function showAllImages()
    {
        return $this->imageDAO->showAll();
    }

    // Cập nhật thông tin hình ảnh
    public function editImage(Image $image)
    {
        return $this->imageDAO->edit($image);
    }

    // Xóa hình ảnh
    public function deleteImage($imageID)
    {
        return $this->imageDAO->delete($imageID);
    }
}
