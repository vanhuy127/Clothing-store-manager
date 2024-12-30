<?php

class Receipt
{
    private $receiptID;
    private $variantID;
    private $sizeName;
    private $colorName;
    private $productID;
    private $productName;
    private $quantity;
    private $date;

    public function __construct($receiptID = 0, $variantID = 0, $sizeName = "", $colorName = "", $productID = 0, $productName = "", $quantity = 0, $date = "")
    {
        $this->receiptID = $receiptID;
        $this->variantID = $variantID;
        $this->sizeName = $sizeName;
        $this->colorName = $colorName;
        $this->productID = $productID;
        $this->productName = $productName;
        $this->quantity = $quantity;
        $this->date = $date;
    }

    public function getReceiptID()
    {
        return $this->receiptID;
    }

    public function setReceiptID($receiptID)
    {
        $this->receiptID = $receiptID;
    }

    public function getVariantID()
    {
        return $this->variantID;
    }

    public function setVariantID($variantID)
    {
        $this->variantID = $variantID;
    }

    public function getSizeName()
    {
        return $this->sizeName;
    }

    public function setSizeName($sizeName)
    {
        $this->sizeName = $sizeName;
    }

    public function getColorName()
    {
        return $this->colorName;
    }

    public function setColorName($colorName)
    {
        $this->colorName = $colorName;
    }

    public function getProductID()
    {
        return $this->productID;
    }

    public function setProductID($productID)
    {
        $this->productID = $productID;
    }

    public function getProductName()
    {
        return $this->productName;
    }

    public function setProductName($productName)
    {
        $this->productName = $productName;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }
}