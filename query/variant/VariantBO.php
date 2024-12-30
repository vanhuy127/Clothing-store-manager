<?php
require_once __DIR__ . '/VariantDAO.php';

class VariantBO
{
    private $variantDAO;

    public function __construct($dbConnection)
    {
        $this->variantDAO = new VariantDAO($dbConnection);
    }

    public function addVariant(Variant $variant)
    {
        return $this->variantDAO->add($variant);
    }

    public function getVariantsByProductID($productID)
    {
        return $this->variantDAO->getByProductID($productID);
    }

    public function getByID($id)
    {
        return $this->variantDAO->getByID($id);
    }

    public function getDetailVariant($productID)
    {
        return $this->variantDAO->getDetailVariant($productID);
    }

    public function updateVariant(Variant $variant)
    {
        return $this->variantDAO->update($variant);
    }

    public function stockIn(Variant $variant)
    {
        return $this->variantDAO->stockIn($variant);
    }

    public function deleteVariant($variantID)
    {
        return $this->variantDAO->delete($variantID);
    }
}
