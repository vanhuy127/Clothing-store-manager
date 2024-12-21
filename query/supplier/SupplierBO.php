<?php
require_once __DIR__ . '/SupplierDAO.php';
class SupplierBO
{
    private $supplierDAO;

    // Khởi tạo ProductQuery
    public function __construct($dbConnection)
    {
        $this->supplierDAO = new SupplierDAO($dbConnection);
    }

    public function showAllSuppliers()
    {
        return $this->supplierDAO->showAll();
    }
    public function addSupplier(Supplier $supplier)
    {
        return $this->supplierDAO->add($supplier);
    }
    public function updateSupplier(Supplier $supplier)
    {
        return $this->supplierDAO->update($supplier);
    }
    public function deleteSupplier($supplierID)
    {
        return $this->supplierDAO->delete($supplierID);
    }
    public function getSupplierByID($supplierID)
    {
        return $this->supplierDAO->getSupplierByID($supplierID);
    }
}
