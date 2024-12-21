<?php
class Variant
{
    private $variantID;
    private $sizeID;
    private $colorID;
    private $stock;
    private $price;
    private $productID;

    public function __construct($variantID = 0, $sizeID = null, $colorID = null, $stock = 0, $price = 0, $productID = 0)
    {
        $this->variantID = $variantID;
        $this->sizeID = $sizeID;
        $this->colorID = $colorID;
        $this->stock = $stock;
        $this->price = $price;
        $this->productID = $productID;
    }

    public function getVariantID()
    {
        return $this->variantID;
    }

    public function getSizeID()
    {
        return $this->sizeID;
    }

    public function getColorID()
    {
        return $this->colorID;
    }

    public function getStock()
    {
        return $this->stock;
    }

    public function getProductID()
    {
        return $this->productID;
    }
    public function getPrice()
    {
        return $this->price;
    }
    public function setVariantID($variantID)
    {
        $this->variantID = $variantID;
    }
    public function setSizeID($sizeID)
    {
        $this->sizeID = $sizeID;
    }

    public function setColorID($colorID)
    {
        $this->colorID = $colorID;
    }

    public function setStock($stock)
    {
        $this->stock = $stock;
    }

    public function setProductID($productID)
    {
        $this->productID = $productID;
    }

    public function setPrice($price)
    {
        return $this->price = $price;
    }
}
