<?php
require_once __DIR__ . '/Product.php';
require_once __DIR__ . '/../image/Image.php';

class ProductDAO
{
    private $dbConnection;

    public function __construct($dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    public function add(Product $p)
    {
        $name = $p->getName();
        $description = $p->getDescription();
        $rate = $p->getRate();
        $unitID = $p->getUnitID();
        $supplierID = $p->getSupplierID();
        $categoryID = $p->getCategoryID();
        $isSelling = $p->getIsSelling() ? 1 : 0;

        $sql = "INSERT INTO products (name, description, rate, unitID, supplierID, categoryID, isSelling) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->dbConnection->prepare($sql);

        if ($stmt === false) {
            return null;
        }

        $stmt->bind_param('ssiiiii', $name, $description, $rate, $unitID, $supplierID, $categoryID, $isSelling);

        if ($stmt->execute()) {
            // Trả về ID của bản ghi vừa được thêm
            return $this->dbConnection->insert_id;
        } else {
            return false;
        }
    }

    public function show($id)
    {
        $sql = "SELECT * FROM products WHERE productID = ?";

        $stmt = $this->dbConnection->prepare($sql);

        if ($stmt === false) {
            return null;
        }

        $stmt->bind_param('i', $id);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $this->mapRowToProduct($row);
        } else {
            return null;
        }
    }

    public function showAll()
    {
        $sql = "SELECT * FROM products";

        $stmt = $this->dbConnection->prepare($sql);

        if ($stmt === false) {
            return [];
        }

        $stmt->execute();

        $result = $stmt->get_result();
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $this->mapRowToProduct($row);
        }
        return $products;
    }

    public function showAllProductWithImage()
    {
        $sql = "
        SELECT p.*, i.imageID, i.path, i.orderNumber
        FROM products p
        LEFT JOIN images i ON p.productID = i.productID
        WHERE i.orderNumber = (
            SELECT MIN(orderNumber)
            FROM images
            WHERE productID = p.productID
        ) OR i.orderNumber IS NULL;
        ";

        $stmt = $this->dbConnection->prepare($sql);

        if ($stmt === false) {
            return [];
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $productDetails = [];
        while ($row = $result->fetch_assoc()) {
            $product = $this->mapRowToProduct($row);
            $image = $this->mapRowToImage($row);

            $productDetails[] = [
                'product' => $product,
                'image' => $image
            ];
        }

        return $productDetails;
    }

    public function edit(Product $p)
    {
        $productID = $p->getProductID();
        $name = $p->getName();
        $description = $p->getDescription();
        $rate = $p->getRate();
        $unitID = $p->getUnitID();
        $supplierID = $p->getSupplierID();
        $categoryID = $p->getCategoryID();
        $isSelling = $p->getIsSelling() ? 1 : 0;

        $sql = "UPDATE products SET name = ?, description = ?, rate = ?, unitID = ?, supplierID = ?, categoryID = ?, isSelling = ? WHERE productID = ?";

        $stmt = $this->dbConnection->prepare($sql);

        if ($stmt === false) {
            return false;
        }

        $stmt->bind_param('ssiiiiii', $name, $description, $rate, $unitID, $supplierID, $categoryID, $isSelling, $productID);

        return $stmt->execute();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM products WHERE productID = ?";

        $stmt = $this->dbConnection->prepare($sql);

        if ($stmt === false) {
            return false;
        }

        $stmt->bind_param('i', $id);

        return $stmt->execute();
    }

    private function mapRowToProduct($row)
    {
        $product = new Product();
        $product->setProductID($row['productID']);
        $product->setName($row['name']);
        $product->setDescription($row['description']);
        $product->setRate($row['rate']);
        $product->setUnitID($row['unitID']);
        $product->setSupplierID($row['supplierID']);
        $product->setCategoryID($row['categoryID']);
        $product->setIsSelling($row['isSelling']);
        return $product;
    }

    private function mapRowToImage($row)
    {
        if (!isset($row['imageID']) || $row['imageID'] === null) {
            return null; // Không có ảnh
        }

        $image = new Image();
        $image->setImageID($row['imageID']);
        $image->setPath($row['path']);
        $image->setOrderNumber($row['orderNumber']);
        $image->setProductID($row['productID']);

        return $image;
    }
}