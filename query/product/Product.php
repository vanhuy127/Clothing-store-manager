<?php
class Product
{
    private $productID;
    private $name;
    private $description;
    private $rate;
    private $unitID;
    private $supplierID;
    private $categoryID;
    private $isSelling;

    public function __construct(
        $productID = 0,
        $name = '',
        $description = '',
        $rate = 0.0,
        $unitID = 0,
        $supplierID = 0,
        $categoryID = 0,
        $isSelling = false
    ) {
        $this->productID = $productID;
        $this->name = $name;
        $this->description = $description;
        $this->rate = $rate;
        $this->unitID = $unitID;
        $this->supplierID = $supplierID;
        $this->categoryID = $categoryID;
        $this->isSelling = $isSelling;
    }

    public function getProductID()
    {
        return $this->productID;
    }

    public function setProductID($productID)
    {
        $this->productID = $productID;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getRate()
    {
        return $this->rate;
    }

    public function setRate($rate)
    {
        $this->rate = $rate;
    }

    public function getUnitID()
    {
        return $this->unitID;
    }

    public function setUnitID($unitID)
    {
        $this->unitID = $unitID;
    }

    public function getSupplierID()
    {
        return $this->supplierID;
    }

    public function setSupplierID($supplierID)
    {
        $this->supplierID = $supplierID;
    }

    public function getCategoryID()
    {
        return $this->categoryID;
    }

    public function setCategoryID($categoryID)
    {
        $this->categoryID = $categoryID;
    }

    public function getIsSelling()
    {
        return $this->isSelling;
    }

    public function setIsSelling($isSelling)
    {
        $this->isSelling = $isSelling;
    }
}
