<?php
require_once __DIR__ . '/Supplier.php';

class SupplierDAO
{
    private $dbConnection;

    public function __construct($dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    public function showAll()
    {
        $sql = "SELECT * FROM suppliers";
        $stmt = $this->dbConnection->prepare($sql);

        if ($stmt === false) {
            return [];
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $suppliers = [];
        while ($row = $result->fetch_assoc()) {
            $suppliers[] = $this->mapRowToSupplier($row);
        }

        return $suppliers;
    }
    public function add(Supplier $supplier)
    {
        $sql = "INSERT INTO suppliers (name, contactName, phone, email, address) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->dbConnection->prepare($sql);

        $stmt->bind_param(
            "sssss",
            $supplier->getName(),
            $supplier->getContactName(),
            $supplier->getPhone(),
            $supplier->getEmail(),
            $supplier->getAddress()
        );

        return $stmt->execute();
    }

    public function update(Supplier $supplier)
    {
        $sql = "UPDATE suppliers SET name = ?, contactName = ?, phone = ?, email = ?, address = ? WHERE supplierID = ?";
        $stmt = $this->dbConnection->prepare($sql);

        $stmt->bind_param(
            "sssssi",
            $supplier->getName(),
            $supplier->getContactName(),
            $supplier->getPhone(),
            $supplier->getEmail(),
            $supplier->getAddress(),
            $supplier->getSupplierID()
        );

        return $stmt->execute();
    }

    public function delete($supplierID)
    {
        $sql = "DELETE FROM suppliers WHERE supplierID = ?";
        $stmt = $this->dbConnection->prepare($sql);

        $stmt->bind_param("i", $supplierID);
        return $stmt->execute();
    }

    public function getSupplierByID($supplierID)
    {
        $sql = "SELECT * FROM suppliers WHERE supplierID = ?";
        $stmt = $this->dbConnection->prepare($sql);

        $stmt->bind_param("i", $supplierID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return $this->mapRowToSupplier($row);
        }

        return null;
    }

    private function mapRowToSupplier($row)
    {
        return new Supplier(
            $row['supplierID'] ?? 0,
            $row['name'] ?? '',
            $row['contactName'] ?? '',
            $row['phone'] ?? '',
            $row['email'] ?? '',
            $row['address'] ?? ''
        );
    }
}
