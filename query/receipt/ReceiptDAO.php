<?php
require_once __DIR__ . '/Receipt.php';

class ReceiptDAO
{
    private $dbConnection;

    public function __construct($dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    public function showAll()
    {
        $sql = "SELECT r.*, p.name as productName, s.name as sizeName, c.name as colorName
                FROM receipt r
                JOIN products p on r.productID = p.productID
                JOIN variants v on r.variantID = v.variantID
                JOIN sizes s on v.sizeID = s.sizeID
                JOIN colors c on v.colorID = c.colorID";

        $stmt = $this->dbConnection->prepare($sql);

        if ($stmt === false) {
            return [];
        }

        $stmt->execute();

        $result = $stmt->get_result();
        $receipts = [];
        while ($row = $result->fetch_assoc()) {
            $receipts[] = $this->mapRowToReceipt($row);
        }
        return $receipts;
    }

    private function mapRowToReceipt($row)
    {
        $receipt = new Receipt(receiptID: $row['receiptID'], variantID: $row['variantID'], sizeName: $row['sizeName'], colorName: $row['colorName'], productID: $row['productID'], productName: $row['productName'], quantity: $row['quantity'], date: $row['date']);
        return $receipt;
    }
}