<?php
require_once __DIR__ . '/ReceiptDAO.php';

class ReceiptBO
{
    private $receiptDAO;

    public function __construct($dbConnection)
    {
        $this->receiptDAO = new ReceiptDAO($dbConnection);
    }


    public function getAllReceipt()
    {
        return $this->receiptDAO->showAll();
    }
}