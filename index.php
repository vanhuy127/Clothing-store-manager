<?php
require_once "./config/db.php";
require_once "./query/productDetail/ProductDetailBO.php";
require_once "./query/category/CategoryBO.php";
require_once "./query/cart/CartBO.php";
require_once "./query/constant/Role.php";

$productDetailBO = new ProductDetailBO($conn);
$featureProducts = $productDetailBO->getFeatureProducts($limit = 8);
$newArrivalProducts = $productDetailBO->getNewArrivalProducts($limit = 8);
$cartBO = new CartBO($conn);
$count = $cartBO->getCount()
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cara</title>
    <link rel="icon" type="image/x-icon" href="./img/icon1.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" />
    <link rel="stylesheet" href="style.css" />

    <!-- ADMINPAGE THEME -->
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <!-- <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script> -->
    <!-- CSS Files -->
    <link id="pagestyle" href="./assets/css/argon-dashboard.css?v=2.1.0" rel="stylesheet" />
    <!-- ADMINPAGE THEME -->
</head>

<body>
    <section id="header">
        <p class="logo" style="font-size: 25px; color: #484848; font-weight: 600">
            FASCO
        </p>

        <div>
            <ul id="navbar">
                <li><a class="active" href="index.php">Home</a></li>
                <li><a href="./userPages/shop.php">Shop</a></li>
                <li><a href="./userPages/blog.php">Blog</a></li>
                <li id="lg-bag">
                    <a href="./userPages/cart.php"><i class="bx bx-shopping-bag"></i></a>
                    <?php if ($count > 0): ?>
                        <div class="badge-custom"><?= htmlspecialchars($count) ?></div>
                    <?php endif; ?>

                </li>
                <?php if (isset($_SESSION['roles']) && in_array(Role::$CUSTOMER, $_SESSION['roles'])): ?>
                    <li>Xin chào, <?= htmlspecialchars($_SESSION['username']) ?></li>
                    <div>
                        <a class="btn btn-primary mb-0" href="./logout.php">Sign out</a>
                    </div>
                <?php else: ?>
                    <div>
                        <a class="btn btn-primary mb-0" href="./login.php">Sign in</a>
                    </div>
                <?php endif ?>
                <a href="#" id="close"><i class="bx bx-x"></i></a>
            </ul>
        </div>
        <div id="mobile">
            <a href="./userPages/cart.php"><i class="bx bx-shopping-bag"></i></a>
            <i id="bar" class="bx bx-menu"></i>
        </div>
    </section>

    <section id="main">
        <h4>Trade-in-offer</h4>
        <h2>Super value deals</h2>
        <h1>On all products</h1>
        <p>save more with coupons & up to 70% off!</p>
        <button class="" onclick="window.location.href = './userPages/shop.php'">Shop
            Now</button>
    </section>

    <section id="feature" class="section-p1">
        <div class="fe-box">
            <img src="img/features/f1.png" alt="" />
            <h6>Free Shipping</h6>
        </div>
        <div class="fe-box">
            <img src="img/features/f2.png" alt="" />
            <h6>Online Order</h6>
        </div>
        <div class="fe-box">
            <img src="img/features/f3.png" alt="" />
            <h6>Save Money</h6>
        </div>
        <div class="fe-box">
            <img src="img/features/f4.png" alt="" />
            <h6>Promotions</h6>
        </div>
        <div class="fe-box">
            <img src="img/features/f5.png" alt="" />
            <h6>Happy Sell</h6>
        </div>
        <div class="fe-box">
            <img src="img/features/f6.png" alt="" />
            <h6>F24/7 Support</h6>
        </div>
    </section>

    <section id="product1" class="section-p1">
        <h2>Featured Products</h2>
        <p>Summer Collection New Modern Design</p>
        <div class="pro-container">
            <!-- <div class="pro">
        <img class="shirt" src="img/products/f1.jpg" alt="" />
        <div class="des">
          <span>adidas</span>
          <h5>Cartoon Astronaut T-Shirts</h5>
          <div class="star">
            <i class="bx bxs-star"></i>
            <i class="bx bxs-star"></i>
            <i class="bx bxs-star"></i>
            <i class="bx bxs-star"></i>
            <i class="bx bxs-star"></i>
          </div>
          <h4>₹2499</h4>
        </div>
        <a href="#"><i class="bx bx-cart cart"></i></a>
      </div> -->
            <?php if (!empty($featureProducts)): ?>
                <?php foreach ($featureProducts as $detail): ?>
                    <?php
                    $imagePath = $detail->getImages();
                    $firstImagePath = "no-product.png";
                    if (!empty($imagePath)) {
                        $firstImagePath = $imagePath[0]['path'];
                    }

                    $variants = $detail->getVariants();
                    $firstVariantPrice = 0;
                    if (!empty($variants)) {
                        $firstVariantPrice = $variants[0]['price'];
                    }
                    $rate = $detail->getRate();
                    ?>
                    <div class="pro"
                        onclick="window.location.href='./userPages/product.php?id=<?= $detail->getProductID() ?>';">
                        <img class="shirt" src="./image-storage/<?= $firstImagePath ?>" alt="Product Image" />
                        <div class="des">
                            <span><?= htmlspecialchars($detail->getCategoryName()) ?></span>
                            <h5><?= htmlspecialchars($detail->getProductName()) ?></h5>
                            <div class="star">
                                <?php
                                for ($x = 1; $x <= floor($rate); $x++) {
                                    echo '<i class="bx bxs-star"></i>'; // In ra ngôi sao đầy
                                }

                                // Nếu $rate có phần thập phân, thêm ngôi sao nửa
                                if ($rate > floor($rate)) {
                                    echo '<i class="bx bxs-star-half"></i>'; // In ra ngôi sao nửa
                                }

                                // Thêm các ngôi sao rỗng để đủ 5 sao
                                for ($x = ceil($rate) + 1; $x <= 5; $x++) {
                                    echo '<i class="bx bx-star"></i>'; // In ra ngôi sao rỗng
                                }
                                ?>
                            </div>
                            <h4>
                                <?= $firstVariantPrice > 0
                                    ? number_format($firstVariantPrice, 0, ',') . ' VND'
                                    : 'Giá chưa được khởi tạo' ?>
                            </h4>
                        </div>
                        <a href="./userPages/cart/addToCart.php?id=<?= $detail->getProductID() ?>"><i
                                class="bx bx-cart cart"></i></a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <h4 class="mx-auto">No featured products found.</h4>
            <?php endif; ?>
        </div>
    </section>

    <section id="banner" class="section-m1">
        <h4>Repair Services</h4>
        <h2>Upto <span>70% Off</span> - All t-Shirts & Accessories</h2>
        <button class="normal">Explore More</button>
    </section>

    <section id="product1" class="section-p1">
        <h2>New Arrivals</h2>
        <p>Summer Collection New Modern Design</p>
        <div class="pro-container">
            <!-- <div class="pro">
        <img class="shirt" src="img/products/n1.jpg" alt="" />
        <div class="des">
          <span>adidas</span>
          <h5>Cartoon Astronaut T-Shirts</h5>
          <div class="star">
            <i class="bx bxs-star"></i>
            <i class="bx bxs-star"></i>
            <i class="bx bxs-star"></i>
            <i class="bx bxs-star"></i>
            <i class="bx bxs-star"></i>
          </div>
          <h4>₹2999</h4>
        </div>
        <a href="#"><i class="bx bx-cart cart"></i></a>
      </div> -->
            <?php if (!empty($newArrivalProducts)): ?>
                <?php foreach ($newArrivalProducts as $detail): ?>
                    <?php
                    $imagePath = $detail->getImages();
                    $firstImagePath = "no-product.png";
                    if (!empty($imagePath)) {
                        $firstImagePath = $imagePath[0]['path'];
                    }

                    $variants = $detail->getVariants();
                    $firstVariantPrice = 0;
                    if (!empty($variants)) {
                        $firstVariantPrice = $variants[0]['price'];
                    }
                    $rate = $detail->getRate();
                    ?>
                    <div class="pro"
                        onclick="window.location.href='./userPages/product.php?id=<?= $detail->getProductID() ?>';">
                        <img class="shirt" src="./image-storage/<?= $firstImagePath ?>" alt="Product Image" />
                        <div class="des">
                            <span><?= htmlspecialchars($detail->getCategoryName()) ?></span>
                            <h5><?= htmlspecialchars($detail->getProductName()) ?></h5>
                            <div class="star">
                                <?php
                                for ($x = 1; $x <= floor($rate); $x++) {
                                    echo '<i class="bx bxs-star"></i>'; // In ra ngôi sao đầy
                                }

                                // Nếu $rate có phần thập phân, thêm ngôi sao nửa
                                if ($rate > floor($rate)) {
                                    echo '<i class="bx bxs-star-half"></i>'; // In ra ngôi sao nửa
                                }

                                // Thêm các ngôi sao rỗng để đủ 5 sao
                                for ($x = ceil($rate) + 1; $x <= 5; $x++) {
                                    echo '<i class="bx bx-star"></i>'; // In ra ngôi sao rỗng
                                }
                                ?>
                            </div>
                            <h4>
                                <?= $firstVariantPrice > 0
                                    ? number_format($firstVariantPrice, 0, ',') . ' VND'
                                    : 'Giá chưa được khởi tạo' ?>
                            </h4>
                        </div>
                        <a href="./userPages/cart/addToCart.php?id=<?= $detail->getProductID() ?>"><i
                                class="bx bx-cart cart"></i></a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <h4 class="mx-auto">No new arrivals product found.</h4>
            <?php endif; ?>
        </div>
    </section>

    <section id="sm-banner" class="section-p1">
        <div class="banner-box">
            <h4>crazy deals</h4>
            <h2>buy 1 get 1 free</h2>
            <span>The best classic dress is on sale at cara</span>
            <button class="white">Learn More</button>
        </div>
        <div class="banner-box banner-box2">
            <h4>spring/summer</h4>
            <h2>upcoming season</h2>
            <span>The best classic dress is on sale at cara</span>
            <button class="white">Collection</button>
        </div>
    </section>

    <section id="banner3">
        <div class="banner-box">
            <h2>SEASONAL SALE</h2>
            <h3>Winter Collection -50% OFF</h3>
        </div>
        <div class="banner-box banner-box2">
            <h2>NEW FOOTWEAR COLLECTION</h2>
            <h3>Spring / Summer 2023</h3>
        </div>
        <div class="banner-box banner-box3">
            <h2>T-SHIRTS</h2>
            <h3>New Trendy Prints</h3>
        </div>
    </section>

    <section id="newsletter" class="section-p1 section-m1">
        <div class="newstext">
            <h4>Sign Up For Newsletters</h4>
            <p>
                Get E-mail updates about our latest shop and
                <span>special offers.</span>
            </p>
        </div>
        <div class="form">
            <input type="text" placeholder="Your email address" />
            <button class="normal">Sign Up</button>
        </div>
    </section>

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
                <img src="./img/pay/app.jpg" alt="" />
                <img src="./img/pay/play.jpg" alt="" />
            </div>
            <p>Secured Payment Gateways</p>
            <img src="./img/pay/pay.png" alt="" />
        </div>

        <div class="copyright">
            <p>© 2024, Nguyễn Văn Huy</p>
        </div>
    </footer>

    <script src="script.js"></script>
</body>

</html>