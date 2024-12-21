<?php
require_once __DIR__ . "/Image.php";
class ImageDAO
{
    private $dbConnection;

    public function __construct($dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    // Thêm hình ảnh vào cơ sở dữ liệu
    public function add(Image $image)
    {
        $path = $image->getPath();
        $orderNumber = $image->getOrderNumber();
        $productID = $image->getProductID();

        $sql = "INSERT INTO images (path, orderNumber, productID) VALUES (?, ?, ?)";

        $stmt = $this->dbConnection->prepare($sql);

        if ($stmt === false) {
            return false;
        }

        $stmt->bind_param('sii', $path, $orderNumber, $productID);
        return $stmt->execute();
    }

    // Hiển thị hình ảnh theo ID sản phẩm
    public function showByProductID($productID)
    {
        $sql = "SELECT * FROM images WHERE productID = ?";
        $stmt = $this->dbConnection->prepare($sql);

        if ($stmt === false) {
            return [];
        }

        $stmt->bind_param('i', $productID);
        $stmt->execute();
        $result = $stmt->get_result();

        $images = [];
        while ($row = $result->fetch_assoc()) {
            $images[] = $this->mapRowToImage($row);
        }

        return $images;
    }

    public function showByID($imageID)
    {
        $sql = "SELECT * FROM images WHERE imageID = ?";
        $stmt = $this->dbConnection->prepare($sql);

        if ($stmt === false) {
            return [];
        }

        $stmt->bind_param('i', $imageID);
        $stmt->execute();
        $result = $stmt->get_result();


        while ($row = $result->fetch_assoc()) {
            return $this->mapRowToImage($row);
        }

        return null;
    }

    // Hiển thị tất cả hình ảnh
    public function showAll()
    {
        $sql = "SELECT * FROM images";
        $stmt = $this->dbConnection->prepare($sql);

        if ($stmt === false) {
            return [];
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $images = [];
        while ($row = $result->fetch_assoc()) {
            $images[] = $this->mapRowToImage($row);
        }
        return $images;
    }

    // Cập nhật thông tin hình ảnh
    public function edit(Image $image)
    {
        $imageID = $image->getImageID();
        $path = $image->getPath();
        $orderNumber = $image->getOrderNumber();
        $productID = $image->getProductID();

        $sql = "UPDATE images SET path = ?, orderNumber = ?, productID = ? WHERE imageID = ?";

        $stmt = $this->dbConnection->prepare($sql);

        if ($stmt === false) {
            return false;
        }

        $stmt->bind_param('siii', $path, $orderNumber, $productID, $imageID);
        return $stmt->execute();
    }

    // Xóa hình ảnh
    public function delete($imageID)
    {
        $sql = "DELETE FROM images WHERE imageID = ?";
        $stmt = $this->dbConnection->prepare($sql);

        if ($stmt === false) {
            return false;
        }

        $stmt->bind_param('i', $imageID);
        return $stmt->execute();
    }

    // Hàm ánh xạ từ mảng dữ liệu của cơ sở dữ liệu sang đối tượng Image
    private function mapRowToImage($row)
    {
        $image = new Image();
        $image->setImageID($row['imageID']);
        $image->setPath($row['path']);
        $image->setOrderNumber($row['orderNumber']);
        $image->setProductID($row['productID']);
        return $image;
    }
}
