<?php
require_once __DIR__ . '/ProductDAO.php';
class ProductBO
{
    private $productDAO;

    // Khởi tạo ProductQuery
    public function __construct($dbConnection)
    {
        $this->productDAO = new ProductDAO($dbConnection);
    }

    // Thêm sản phẩm
    public function addProduct(Product $p)
    {
        // Gọi phương thức add từ ProductQuery
        return $this->productDAO->add($p);
    }

    // Cập nhật sản phẩm
    public function editProduct(Product $p)
    {
        // Gọi phương thức edit từ ProductQuery
        return $this->productDAO->edit($p);
    }

    // Xóa sản phẩm
    public function deleteProduct($productID)
    {
        // Gọi phương thức delete từ ProductQuery
        return $this->productDAO->delete($productID);
    }

    // Hiển thị thông tin sản phẩm
    public function showProduct($productID)
    {
        // Gọi phương thức show từ ProductQuery
        return $this->productDAO->show($productID);
    }

    // Hiển thị tất cả sản phẩm
    public function showAllProducts()
    {
        // Gọi phương thức showAll từ ProductQuery
        return $this->productDAO->showAll();
    }

    public function showAllProductWithImage()
    {
        return $this->productDAO->showAllProductWithImage();
    }
}
