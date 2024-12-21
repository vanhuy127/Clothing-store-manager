<?php
class Order
{
    private $orderID;
    private $totalPrice;
    private $date;
    private $customer = [
        'customerID' => null,
        'fullName' => null,
        'email' => null,
        'phone' => null,
        'address' => null,
    ];
    private $orderDetails = [];
    private $status;

    public function __construct($orderID = 0, $totalPrice = 0, $date = "", $customerID = 0, $fullName = "", $status = 0)
    {
        $this->orderID = $orderID;
        $this->totalPrice = $totalPrice;
        $this->date = $date;
        $this->customer['customerID'] = $customerID;
        $this->customer['fullName'] = $fullName;
        $this->status = $status;
    }

    // Getter và Setter cho OrderID
    public function getOrderID()
    {
        return $this->orderID;
    }

    public function setOrderID($orderID)
    {
        $this->orderID = $orderID;
    }

    // Getter và Setter cho TotalPrice
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;
    }

    // Getter và Setter cho Date
    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    // Getter và Setter cho Customer
    public function getCustomer()
    {
        return $this->customer;
    }

    public function setCustomer($customerID, $fullName, $email, $phone, $address)
    {
        $this->customer['customerID'] = $customerID;
        $this->customer['fullName'] = $fullName;
        $this->customer['email'] = $email;
        $this->customer['phone'] = $phone;
        $this->customer['address'] = $address;
    }

    // Thêm một chi tiết hóa đơn vào OrderDetails
    public function addOrderDetail(OrderDetails $orderDetail)
    {
        $this->orderDetails[] = $orderDetail;
    }

    // Lấy tất cả các chi tiết hóa đơn
    public function getOrderDetails()
    {
        return $this->orderDetails;
    }
}

class OrderDetails
{
    private $variantID;
    private $productID;
    private $productName;
    private $image;
    private $size;
    private $color;
    private $quantity;
    private $price;

    public function __construct($variantID = 0, $productID = 0, $productName = "", $image = "", $size = "", $color = "", $quantity = 0, $price = 0)
    {
        $this->variantID = $variantID;
        $this->productID = $productID;
        $this->productName = $productName;
        $this->image = $image;
        $this->size = $size;
        $this->color = $color;
        $this->quantity = $quantity;
        $this->price = $price;
    }

    public function getVariantID()
    {
        return $this->variantID;
    }

    public function setVariantID($variantID)
    {
        $this->variantID = $variantID;
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

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function setSize($size)
    {
        $this->size = $size;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function setColor($color)
    {
        $this->color = $color;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }
}