<?php
require_once __DIR__ . '/CartDAO.php';
require_once __DIR__ . '/Cart.php';
require_once __DIR__ . '/../productDetail/ProductDetailBO.php';

class CartBO
{
    private $cartDAO;
    private $productDAO;

    public function __construct($dbConnection)
    {
        $this->cartDAO = new CartDAO($dbConnection);
        $this->productDAO = new ProductDetailBO($dbConnection);
    }

    // Add product to cart
    public function addProductToCart($productID, $variantID, $quantity)
    {
        return $this->cartDAO->addOrUpdateCartItem($productID, $variantID, $quantity);
    }

    public function reduceProductToCart($productID, $quantity, $variantID)
    {
        return $this->cartDAO->reduceCartItem($productID, $quantity, $variantID);
    }

    // Remove product from cart
    public function removeProductFromCart($productID, $variantID)
    {
        $this->cartDAO->removeCartItem($productID, $variantID);
    }

    // Get all cart items with product details
    public function getCartItemsWithDetails()
    {
        $cartItems = $this->cartDAO->getCartItems(); // Lấy tất cả các sản phẩm trong giỏ hàng
        $detailedCartItems = []; // Mảng để chứa thông tin chi tiết của sản phẩm

        foreach ($cartItems as $v) {
            $product = $this->productDAO->getProductByIDAndVariantID($v["productID"], $v["variantID"]);
            $cart = new Cart($product, $v['quantity']);
            $detailedCartItems[] = $cart;
        }

        return $detailedCartItems;
    }

    public function getCount()
    {
        return $this->cartDAO->getCount();
    }

    // Get total price of the cart
    public function getTotalPrice()
    {
        $cartItems = $this->getCartItemsWithDetails();
        $total = 0;

        foreach ($cartItems as $c) {
            $total += $c->getTotalPrice();
        }
        return $total;
    }

    // Clear the cart
    public function clearCart()
    {
        $this->cartDAO->clearCart();
    }

    public function getCartItems()
    {
        return $this->cartDAO->getCartItems();
    }
}
