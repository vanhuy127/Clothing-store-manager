<?php
require_once __DIR__ . '/Order.php';
require_once __DIR__ . '/../constant/OrderStatus.php';

class OrderDAO
{
    private $dbConnection;

    public function __construct($dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    public function addOrder(Order $order)
    {
        $sql = "INSERT INTO orders(totalPrice, date, customerID, status) VALUES (?, ?, ?, ?)";
        $stmt = $this->dbConnection->prepare($sql);

        if ($stmt === false) {
            return false;
        }
        $totalPrice = $order->getTotalPrice();
        $date = $order->getDate();
        $customerID = $order->getCustomer()['customerID'];
        $status = OrderStatus::$INIT;

        // Sử dụng các biến để bind_param
        $stmt->bind_param('isii', $totalPrice, $date, $customerID, $status);
        $stmt->execute();
        return $this->dbConnection->insert_id;
    }

    public function addOrderDetail($orderID, OrderDetails $od)
    {
        $sql = "INSERT INTO orderdetails(orderID, VariantID, Quantity, Price) VALUES (?, ?, ?, ?)";
        $stmt = $this->dbConnection->prepare($sql);

        if ($stmt === false) {
            return false;
        }

        $variantID = $od->getVariantID();
        $quantity =  $od->getQuantity();
        $price = $od->getPrice();

        $stmt->bind_param('iiii', $orderID, $variantID, $quantity, $price);
        return $stmt->execute();
    }

    public function getAllOrder()
    {
        $sql = "SELECT orders.*, users.fullName
                FROM orders JOIN users on orders.customerID = users.userID";

        $stmt = $this->dbConnection->prepare($sql);

        if ($stmt === false) {
            return [];
        }

        $stmt->execute();

        $result = $stmt->get_result();
        $order = [];
        while ($row = $result->fetch_assoc()) {
            $order[] = new Order(
                $row['orderID'],
                $row['totalPrice'],
                $row['date'],
                $row['customerID'],
                $row['fullName'],
                $row['status']
            );
        }
        return $order;
    }

    public function getDetailOrderByID($orderID)
    {
        $sql = "SELECT  o.orderID, o.totalPrice, o.date, o.customerID, o.status, u.username, u.fullName, u.email, u.phone, u.address, 
                        v.variantID, p.productID, i.path, p.name as productName, s.name as sizeName, c.name as colorName, 
                        od.Quantity, od.Price, MIN(i.orderNumber)
                FROM orders as o 
                JOIN users as u on o.customerID = u.userID
                JOIN orderdetails as od on o.orderID = od.orderID
                JOIN variants as v on od.VariantID = v.variantID
                JOIN sizes as s on v.sizeID = s.sizeID
                JOIN colors as c on c.colorID = v.colorID
                JOIN products as p on v.productID = p.productID
                JOIN images as i on p.productID = i.productID
                WHERE o.orderID = ?
                GROUP BY v.variantID";

        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bind_param('i', $orderID);

        if ($stmt === false) {
            return null;
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $order = null;

        while ($row = $result->fetch_assoc()) {
            if ($order === null) {
                // Khởi tạo đối tượng Order nếu chưa được tạo
                $order = new Order(
                    orderID: $row['orderID'],
                    totalPrice: $row['totalPrice'],
                    date: $row['date'],
                    status: $row['status']
                );

                // Thiết lập thêm thông tin khách hàng
                $order->setCustomer(
                    $row['customerID'],
                    $row['fullName'],
                    $row['email'],
                    $row['phone'],
                    $row['address']
                );
            }

            // Tạo đối tượng OrderDetails cho từng sản phẩm
            $orderDetail = new OrderDetails(
                $row['variantID'],
                $row['productID'],
                $row['productName'],
                $row['path'],
                $row['sizeName'],
                $row['colorName'],
                $row['Quantity'],
                $row['Price']
            );

            $order->addOrderDetail($orderDetail);
        }

        return $order;
    }

    public function updateOrderStatus(Order $order)
    {
        $orderID = $order->getOrderID();
        $status = $order->getStatus();


        $sql = "UPDATE orders SET status = ? WHERE orderID = ?";

        $stmt = $this->dbConnection->prepare($sql);

        if ($stmt === false) {
            return false;
        }

        $stmt->bind_param('ii', $status, $orderID);

        return $stmt->execute();
    }
}