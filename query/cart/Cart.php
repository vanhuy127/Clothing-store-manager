<?php
class Cart
{
    private $product;
    private $quantity;
    private $totalPrice;

    public function __construct($product, $quantity)
    {
        $this->product = $product;
        $this->quantity = $quantity;
        $this->totalPrice = ($product->getVariants())[0]['price'] * $quantity;
    }

    // Getter for product
    public function getProduct()
    {
        return $this->product;
    }

    // Setter for product
    public function setProduct($product)
    {
        $this->product = $product;
    }

    // Getter for quantity
    public function getQuantity()
    {
        return $this->quantity;
    }

    // Setter for quantity
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    // Getter for totalPrice
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    // Setter for totalPrice
    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;
    }
}
