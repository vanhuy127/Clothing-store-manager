<?php
require_once __DIR__ . '/Variant.php';

class VariantDAO
{
    private $dbConnection;

    public function __construct($dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    public function add(Variant $variant)
    {
        $sql = "INSERT INTO variants (sizeID, colorID, stock, price, productID) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->dbConnection->prepare($sql);

        if ($stmt === false) {
            return false;
        }

        $sizeID = $variant->getSizeID();
        $colorID = $variant->getColorID();
        $stock = $variant->getStock();
        $price = $variant->getPrice();
        $productID = $variant->getProductID();

        $stmt->bind_param('iiidi', $sizeID, $colorID, $stock, $price, $productID);

        return $stmt->execute();
    }

    public function getByProductID($productID)
    {
        $sql = "SELECT * FROM variants WHERE productID = ?";
        $stmt = $this->dbConnection->prepare($sql);

        if ($stmt === false) {
            return [];
        }

        $stmt->bind_param('i', $productID);
        $stmt->execute();

        $result = $stmt->get_result();
        $variants = [];
        while ($row = $result->fetch_assoc()) {
            $variants[] = $this->mapRowToVariant($row);
        }
        return $variants;
    }

    public function getByID($id)
    {
        $sql = "SELECT * FROM variants WHERE variantID = ?";
        $stmt = $this->dbConnection->prepare($sql);

        if ($stmt === false) {
            return [];
        }

        $stmt->bind_param('i', $id);
        $stmt->execute();

        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            return $this->mapRowToVariant($row);
        }
    }

    public function update(Variant $variant)
    {
        $sql = "UPDATE variants SET sizeID = ?, colorID = ?, stock = ?, price = ?, productID = ? WHERE variantID = ?";
        $stmt = $this->dbConnection->prepare($sql);

        if ($stmt === false) {
            return false;
        }

        $sizeID = $variant->getSizeID();
        $colorID = $variant->getColorID();
        $stock = $variant->getStock();
        $price = $variant->getPrice();
        $productID = $variant->getProductID();
        $variantID = $variant->getVariantID();

        $stmt->bind_param('iiidii', $sizeID, $colorID, $stock, $price, $productID, $variantID);

        return $stmt->execute();
    }

    public function delete($variantID)
    {
        $sql = "DELETE FROM variants WHERE variantID = ?";
        $stmt = $this->dbConnection->prepare($sql);

        if ($stmt === false) {
            return false;
        }

        $stmt->bind_param('i', $variantID);

        return $stmt->execute();
    }

    public function getDetailVariant($productID)
    {
        $sql = "
        SELECT 
            variants.variantID,
            variants.sizeID,
            variants.colorID,
            variants.stock,
            variants.price,
            variants.productID,
            sizes.name AS sizeName,
            colors.colorCode AS colorCode
        FROM variants
        LEFT JOIN sizes ON variants.sizeID = sizes.sizeID
        LEFT JOIN colors ON variants.colorID = colors.colorID
        WHERE variants.productID = ?
    ";

        $stmt = $this->dbConnection->prepare($sql);

        if ($stmt === false) {
            return [];
        }

        $stmt->bind_param('i', $productID);
        $stmt->execute();

        $result = $stmt->get_result();
        $variants = [];

        while ($row = $result->fetch_assoc()) {
            $variant = new Variant();
            $variant->setVariantID($row['variantID']);
            $variant->setSizeID($row['sizeID']);
            $variant->setColorID($row['colorID']);
            $variant->setStock($row['stock']);
            $variant->setPrice($row['price']);
            $variant->setProductID($row['productID']);

            // Kèm theo thông tin chi tiết
            $variants[] = [
                'variant' => $variant,
                'sizeName' => $row['sizeName'] ?? null,
                'colorCode' => $row['colorCode'] ?? null,
            ];
        }

        return $variants;
    }

    public function stockIn($variant)
    {
        $sqlInsert = "INSERT INTO receipt (variantID, productID, quantity, date)
                VALUES (?, ?, ?, NOW());";
        $stmtInsert = $this->dbConnection->prepare($sqlInsert);
        if ($stmtInsert === false) {
            return false;
        }
        $variantID = $variant->getVariantID();
        $productID = $variant->getProductID();
        $quantity = $variant->getStock();

        $stmtInsert->bind_param('iii', $variantID, $productID, $quantity);
        $stmtInsert->execute();
        $sqlUpdate = "UPDATE variants SET stock = stock + ? WHERE variantID = ?";
        $stmtUpdate = $this->dbConnection->prepare($sqlUpdate);
        if ($stmtUpdate === false) {
            return false;
        }
        $stmtUpdate->bind_param('ii', $quantity, $variantID);
        $stmtUpdate->execute();
        return true;
    }

    private function mapRowToVariant($row)
    {
        return new Variant(
            $row['variantID'],
            $row['sizeID'],
            $row['colorID'],
            $row['stock'],
            $row['price'],
            $row['productID']
        );
    }
}
