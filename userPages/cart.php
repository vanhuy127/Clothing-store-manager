<?php
require_once "../query/cart/CartBO.php";
require_once "../query/cart/Cart.php";

require_once "../query/constant/Role.php";

require_once "../query/order/OrderBO.php";
require_once "../query/order/Order.php";
require_once "../config/db.php";
date_default_timezone_set('Asia/Ho_Chi_Minh'); // Đặt múi giờ Việt Nam

$cartBO = new CartBO($conn);
$orderBO = new OrderBO($conn);

$carts = $cartBO->getCartItemsWithDetails();
$count = $cartBO->getCount();
$totalPrice = $cartBO->getTotalPrice();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (empty($carts)) {
        exit();
    }

    $customerID = $_SESSION['userID'];
    // Lấy thông tin giỏ hàng
    $orderDetails = [];



    foreach ($carts as $cartItem) {
        $orderDetails[] = new OrderDetails(
            variantID: $cartItem->getProduct()->getVariants()[0]['id'],
            quantity: $cartItem->getQuantity(),
            price: $cartItem->getTotalPrice(),
        );
    }

    $order = new Order(
        totalPrice: $totalPrice,
        date: date('Y-m-d H:i:s'),
        customerID: $customerID,
    );

    foreach ($orderDetails as $detail) {
        $order->addOrderDetail($detail);
    }

    // var_dump($order);
    $orderBO->addOrder($order);
    $cartBO->clearCart();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cara</title>
    <link rel="icon" type="image/x-icon" href="../img/icon1.png" />

    <!-- ADMINPAGE THEME -->
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <!-- <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script> -->
    <!-- CSS Files -->
    <link id="pagestyle" href="../assets/css/argon-dashboard.css?v=2.1.0" rel="stylesheet" />
    <!-- ADMINPAGE THEME -->

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../style.css" />
    <style>
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        margin: 0;
        -webkit-appearance: none;
    }

    .checkout:disabled {
        opacity: 0.5;
        cursor: default;
    }
    </style>
</head>

<body>
    <section id="header">
        <p class="logo" style="font-size: 25px; color: #484848; font-weight: 600">
            FASCO
        </p>
        <div>
            <ul id="navbar">
                <li><a href="../index.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="blog.php">Blog</a></li>
                <li id="lg-bag btn btn-primary">
                    <a class="active" href="cart.php"><i class="bx bx-shopping-bag"></i></a>
                    <?php if ($count > 0): ?>
                    <div class="badge-custom"><?= htmlspecialchars($count) ?></div>
                    <?php endif; ?>
                </li>
                <?php if (isset($_SESSION['roles']) && in_array(Role::$CUSTOMER, $_SESSION['roles'])): ?>
                <li>Xin chào, <?= htmlspecialchars($_SESSION['username']) ?></li>
                <div>
                    <a class="btn btn-primary mb-0" href="../logout.php">Sign out</a>
                </div>
                <?php else: ?>
                <div>
                    <a class="btn btn-primary mb-0" href="../login.php">Sign in</a>
                </div>
                <?php endif ?>
                <a href="#" id="close"><i class="bx bx-x"></i></a>
            </ul>
        </div>
        <div id="mobile">
            <a href="cart.html"><i class="bx bx-shopping-bag"></i></a>
            <i id="bar" class="bx bx-menu"></i>
        </div>
    </section>

    <section id="page-header" class="about-header">
        <h2>#let's_talk</h2>
        <p>LEAVE A MESSAGE, We love to hear from you!</p>
    </section>

    <?php if (isset($_SESSION['roles']) && in_array(Role::$CUSTOMER, $_SESSION['roles'])): ?>
    <!-- CART -->
    <section id="cart" class="section-p1">
        <table width="100%">
            <thead>
                <tr>
                    <td>Remove</td>
                    <td>Image</td>
                    <td>Product</td>
                    <td style="width: 8%;">Size</td>
                    <td style="width: 8%;">Color</td>
                    <td>Price</td>
                    <td class="text-center">Quantity</td>
                    <td class="text-center">Subtotal</td>
                </tr>
            </thead>
            <tbody>
                <!-- <tr>
          <td><i class=" bx bx-x-circle"></i></td>
                    <td><img src="../img/products/f1.jpg" alt="" /></td>
                    <td>Cartoon Astronaut T-Shirts</td>
                    <td>₹2499</td>
                    <td><input type="number" value="1" /></td>
                    <td>₹2499</td>
                </tr> -->
                <?php if (!empty($carts)): ?>
                <?php foreach ($carts as $c): ?>
                <tr>
                    <td>
                        <a
                            href="./cart/removeFromCart.php?id=<?= $c->getProduct()->getProductID() ?>&vid=<?= $c->getProduct()->getVariants()[0]['id'] ?>">
                            <i class="bx bx-x-circle"></i>
                        </a>
                    </td>
                    <td>
                        <img src="../image-storage/<?= ($c->getProduct()->getImages())[0]['path'] ? htmlspecialchars(($c->getProduct()->getImages())[0]['path']) : 'no-product.png' ?>"
                            alt="" />
                    </td>
                    <td><?= htmlspecialchars($c->getProduct()->getProductName()) ?></td>
                    <td><?= htmlspecialchars($c->getProduct()->getVariants()[0]['sizeName']) ?></td>
                    <td><?= htmlspecialchars($c->getProduct()->getVariants()[0]['colorName']) ?></td>
                    <td><?= number_format($c->getProduct()->getVariants()[0]['price'], 0, ',') . ' VND' ?></td>
                    <td class="">
                        <div class="d-flex align-items-center gap-2 justify-content-center">
                            <a
                                href="./cart/addToCart.php?id=<?= $c->getProduct()->getProductID() ?>&vid=<?= $c->getProduct()->getVariants()[0]['id'] ?>">
                                <i class='bx bx-plus bx-sm cursor-pointer'></i>
                            </a>
                            <input class="w-30" type="number" value="<?= htmlspecialchars($c->getQuantity()) ?>"
                                disabled />
                            <a
                                href="./cart/reduceFromCart.php?id=<?= $c->getProduct()->getProductID() ?>&vid=<?= $c->getProduct()->getVariants()[0]['id'] ?>">
                                <i class='bx bx-minus bx-sm cursor-pointer'></i>
                            </a>
                        </div>
                    </td>
                    <td class="text-center"><?= number_format($c->getTotalPrice(), 0, ',') . ' VND' ?></td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <!-- <h4 class="">No products found.</h4> -->
                <?php endif; ?>
            </tbody>
        </table>
    </section>

    <section id="cart-add" class="section-p1">
        <div id="coupon">
            <h3>Apply Coupon</h3>
            <div>
                <input type="text" placeholder="Enter Your Coupon" />
                <button class="normal">Apply</button>
            </div>
        </div>

        <div id="subtotal">
            <h3>Cart Total</h3>
            <table>
                <tr>
                    <td>Cart Subtotal</td>
                    <td><?= number_format($totalPrice, 0, ',') . ' VND' ?></td>
                </tr>
                <tr>
                    <td>Shipping</td>
                    <td>Free</td>
                </tr>
                <tr>
                    <td><strong>Total</strong></td>
                    <td><strong><?= number_format($totalPrice, 0, ',') . ' VND' ?></strong></td>
                </tr>
            </table>
            <form action="" method="post">
                <button class="normal checkout" type="submit" <?php echo empty($carts) ? 'disabled' : ''; ?>>Proceed to
                    checkout</button>
            </form>
        </div>
    </section>
    <!-- CART -->
    <?php else: ?>
    <p class="h4 text-center mt-3 m-10"> Bạn cần Đăng Nhập để thực hiện thao tác này</p>
    <?php endif ?>

    <footer class="section-p1">
        <div class="col">
            <p class="logo" style="font-size: 25px; color: #484848; font-weight: 600">
                FASCO
            </p>
            <h4>Contact</h4>
            <p>
                <strong>Address:</strong> 562 Wellington Road, Street 32, San
                Francisco
            </p>
            <p><strong>Phone:</strong> +01 2222 345 / (+91) 0 123 456 789</p>
            <p><strong>Hours:</strong> 10:00 - 18:00, Mon - Sat</p>
            <div class="follow">
                <h4>Follow us</h4>
                <div class="icon">
                    <i class="bx bxl-facebook"></i>
                    <i class="bx bxl-twitter"></i>
                    <i class="bx bxl-instagram"></i>
                    <i class="bx bxl-pinterest-alt"></i>
                    <i class="bx bxl-youtube"></i>
                </div>
            </div>
        </div>

        <div class="col">
            <h4>About</h4>
            <a href="#">About us</a>
            <a href="#">Devlivery Information</a>
            <a href="#">Privacy Policy</a>
            <a href="#">Terms & Conditions</a>
            <a href="#">Contact Us</a>
        </div>

        <div class="col">
            <h4>My Account</h4>
            <a href="#">Sign In</a>
            <a href="#">View Cart</a>
            <a href="#">My Wishlist</a>
            <a href="#">Track My Order</a>
            <a href="#">Help</a>
        </div>

        <div class="col install">
            <h4>Install App</h4>
            <p>From App Store or Google Play</p>
            <div class="row">
                <img src="../img/pay/app.jpg" alt="" />
                <img src="../img/pay/play.jpg" alt="" />
            </div>
            <p>Secured Payment Gateways</p>
            <img src="../img/pay/pay.png" alt="" />
        </div>

        <div class="copyright">
            <p>© 2024, Nguyễn Văn Huy</p>
        </div>
    </footer>

    <script src="../script.js"></script>
</body>

</html>