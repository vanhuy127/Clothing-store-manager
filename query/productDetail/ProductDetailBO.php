<?php
require_once __DIR__ . '/ProductDetailDAO.php';
class ProductDetailBO
{
    private $productDetailDAO;

    public function __construct($dbConnection)
    {
        $this->productDetailDAO = new ProductDetailDAO($dbConnection);
    }

    public function getCount($search = '', $category = 0, $priceFrom = 0, $priceTo = 0)
    {
        return $this->productDetailDAO->getCount($search, $category, $priceFrom, $priceTo);
    }

    public function getAllProductDetails($search = '', $category = 0, $priceFrom = 0, $priceTo = 0, $page = 1, $pageSize = 8)
    {
        return $this->productDetailDAO->getAllProductDetails($search, $category, $priceFrom, $priceTo, $page, $pageSize);
    }

    public function getFeatureProducts($limit = 8)
    {
        return $this->productDetailDAO->getFeatureProducts($limit);
    }

    public function getNewArrivalProducts($limit = 8)
    {
        return $this->productDetailDAO->getNewArrivalProducts($limit);
    }

    public function getProductByID($productID)
    {
        return $this->productDetailDAO->getProductByID($productID);
    }

    public function getProductByIDAndVariantID($productID, $variantID)
    {
        return $this->productDetailDAO->getProductByIDAndVariantID($productID, $variantID);
    }

    public function getProductDetailByID($productID)
    {
        return $this->productDetailDAO->getProductDetailByID($productID);
    }
}