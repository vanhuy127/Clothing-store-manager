<?php
class Image
{
    private $imageID;
    private $path;
    private $orderNumber;
    private $productID;

    public function __construct($imageID = 0, $path = "", $orderNumber = 0, $productID = 0)
    {
        $this->imageID = $imageID;
        $this->path = $path;
        $this->orderNumber = $orderNumber;
        $this->productID = $productID;
    }

    public function getImageID()
    {
        return $this->imageID;
    }

    public function setImageID($imageID)
    {
        $this->imageID = $imageID;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setPath($path)
    {
        $this->path = $path;
    }

    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    public function setOrderNumber($orderNumber)
    {
        $this->orderNumber = $orderNumber;
    }

    public function getProductID()
    {
        return $this->productID;
    }

    public function setProductID($productID)
    {
        $this->productID = $productID;
    }
}
