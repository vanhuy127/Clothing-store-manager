<?php
class ProductDetail
{
    public $productID;
    public $productName;
    public $description;
    public $rate;
    public $images = [];
    public $categoryName;
    public $unitName;
    public $supplierName;
    public $variants = [];

    public function __construct($productID, $productName, $description, $rate, $categoryName, $unitName, $supplierName)
    {
        $this->productID = $productID;
        $this->productName = $productName;
        $this->description = $description;
        $this->rate = $rate;
        $this->categoryName = $categoryName;
        $this->unitName = $unitName;
        $this->supplierName = $supplierName;
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

    public function getImages()
    {
        return $this->images;
    }

    public function getCategoryName()
    {
        return $this->categoryName;
    }

    public function setCategoryName($categoryName)
    {
        $this->categoryName = $categoryName;
    }

    public function getUnitName()
    {
        return $this->unitName;
    }

    public function setUnitName($unitName)
    {
        $this->unitName = $unitName;
    }

    public function getSupplierName()
    {
        return $this->supplierName;
    }

    public function setSupplierName($supplierName)
    {
        $this->supplierName = $supplierName;
    }

    public function getVariants()
    {
        return $this->variants;
    }

    public function setImages($path, $orderNumber)
    {
        $this->images[] = [
            'path' => $path,
            'orderNumber' => $orderNumber
        ];
    }

    public function setVariants($id, $stock, $price, $sizeName, $colorName, $colorCode)
    {
        $this->variants[] = [
            'id' => $id,
            'stock' => $stock,
            'price' => $price,
            'sizeName' => $sizeName,
            'colorName' => $colorName,
            'colorCode' => $colorCode
        ];
    }
}
