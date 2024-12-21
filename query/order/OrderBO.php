<?php
require_once __DIR__ . '/OrderDAO.php';
class OrderBO
{
    private $orderDAO;

    // Khởi tạo ProductQuery
    public function __construct($dbConnection)
    {
        $this->orderDAO = new OrderDAO($dbConnection);
    }

    public function addOrder(Order $order)
    {
        $orderID = $this->orderDAO->addOrder($order);
        $variants = $order->getOrderDetails();
        foreach ($variants as $v) {
            $this->orderDAO->addOrderDetail($orderID, $v);
        }
    }
    public function getAllOrder()
    {
        return $this->orderDAO->getAllOrder();
    }

    public function getDetailOrderByID($orderID)
    {
        return $this->orderDAO->getDetailOrderByID($orderID);
    }

    public function updateOrderStatus(Order $order)
    {
        return $this->orderDAO->updateOrderStatus($order);
    }
}