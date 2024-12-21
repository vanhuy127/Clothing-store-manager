<?php
require_once __DIR__ . '/Cart.php';
require_once __DIR__ . '/../productDetail/ProductDetailBO.php';
class CartDAO
{
    private $sessionKey = 'CART_SESSION';
    private $connection;
    public function __construct($dbConnection)
    {
        $this->connection = $dbConnection;
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!isset($_SESSION[$this->sessionKey])) {
            $_SESSION[$this->sessionKey] = [];
        }
    }

    // Add or update item in cart
    public function addOrUpdateCartItem($productID, $variantID, $quantity)
    {
        $productBO = new ProductDetailBO($this->connection);
        $product = $productBO->getProductByIDAndVariantID($productID, $variantID);

        if (!$product) {
            throw new Exception("Product not found.");
        }

        if ($_SESSION[$this->sessionKey][$productID][$variantID]['quantity'] + $quantity > $product->getVariants()[0]['stock']) {
            return;
        }

        if (isset($_SESSION[$this->sessionKey][$productID][$variantID])) {
            // Increase quantity if product already exists in cart
            $_SESSION[$this->sessionKey][$productID][$variantID]['quantity'] += $quantity;
        } else {
            $_SESSION[$this->sessionKey][$productID][$variantID] = [
                'quantity' => $quantity,
            ];
        }
    }

    public function reduceCartItem($productID, $variantID, $quantity)
    {
        if (isset($_SESSION[$this->sessionKey][$productID][$variantID])) {
            // Giảm số lượng
            $_SESSION[$this->sessionKey][$productID][$variantID]['quantity'] -= $quantity;

            // Nếu số lượng <= 0 thì xóa sản phẩm khỏi giỏ hàng
            if ($_SESSION[$this->sessionKey][$productID][$variantID]['quantity'] <= 0) {
                $this->removeCartItem($productID, $variantID);
            }
        }
    }

    // Remove item from cart
    public function removeCartItem($productID, $variantID)
    {
        if (isset($_SESSION[$this->sessionKey][$productID][$variantID])) {
            unset($_SESSION[$this->sessionKey][$productID][$variantID]);
        }
    }

    // Get all cart items
    public function getCartItems()
    {
        $cartItems = [];
        foreach ($_SESSION[$this->sessionKey] as $productID => $variants) {
            foreach ($variants as $variantID => $item) {
                $cartItems[] = [
                    'productID' => $productID,
                    'variantID' => $variantID,
                    'quantity' => $item['quantity']
                ];
            }
        }
        return $cartItems;
    }

    public function getCount()
    {
        $count = 0;
        foreach ($_SESSION[$this->sessionKey] as $productVariants) {
            foreach ($productVariants as $variantID => $item) {
                $count += $item['quantity'];
            }
        }
        return $count;
    }

    // Clear the cart
    public function clearCart()
    {
        $_SESSION[$this->sessionKey] = [];
    }
}
