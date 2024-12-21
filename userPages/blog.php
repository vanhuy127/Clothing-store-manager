<?php
require_once "../config/db.php";
require_once "../query/cart/CartBO.php";
require_once "../query/constant/Role.php";

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
    <link rel="icon" type="image/x-icon" href="../img/icon1.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" />
    <link rel="stylesheet" href="../style.css" />
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
                <li><a class="active" href="blog.php">Blog</a></li>

                <li id="lg-bag">
                    <a href="cart.php"><i class="bx bx-shopping-bag"></i></a>
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

    <section id="page-header" class="blog-header">
        <h2>#readmore</h2>
        <p>Read all case studies about our products!</p>
    </section>

    <section id="blog">
        <div class="blog-box">
            <div class="blog-img">
                <img src="../img/blog/b1.jpg" alt="" />
            </div>
            <div class="blog-details">
                <h4>The Cotton Jersey Zip-Up Hoodie</h4>
                <p>
                    The Cotton Jersey Zip-Up Hoodie is a versatile and comfortable
                    outerwear piece that combines style and functionality. Crafted from
                    high-quality cotton jersey fabric, this hoodie offers a cozy feel
                    and a casual yet fashionable look.
                </p>
                <a href="#">CONTINUE READING</a>
            </div>
            <h1>13/01</h1>
        </div>
        <div class="blog-box">
            <div class="blog-img">
                <img src="../img/blog/b2.jpg" alt="" />
            </div>
            <div class="blog-details">
                <h4>How to Style a Quiff</h4>
                <p>
                    The Quiff is a timeless and sophisticated hairstyle that never fails
                    to make a statement. With its voluminous and sculpted front, it adds
                    a touch of elegance and charm to any look.
                </p>
                <a href="#">CONTINUE READING</a>
            </div>
            <h1>13/04</h1>
        </div>
        <div class="blog-box">
            <div class="blog-img">
                <img src="../img/blog/b3.jpg" alt="" />
            </div>
            <div class="blog-details">
                <h4>Must-Have Skater Girl Items</h4>
                <p>
                    Must-Have Skater Girl Items are essential for adding a cool and edgy
                    vibe to your wardrobe. From skateboard to streetwear, these items
                    perfectly capture the skater girl aesthetic.
                </p>
                <a href="#">CONTINUE READING</a>
            </div>
            <h1>12/01</h1>
        </div>
        <div class="blog-box">
            <div class="blog-img">
                <img src="../img/blog/b4.jpg" alt="" />
            </div>
            <div class="blog-details">
                <h4>Runway-Inspired Trends</h4>
                <p>
                    Runway-Inspired Trends are the ultimate source of fashion
                    inspiration, bringing high-end style to everyday life. From bold
                    prints to statement accessories, these trends allow you to express
                    your creativity and stay ahead of the fashion curve.
                </p>
                <a href="#">CONTINUE READING</a>
            </div>
            <h1>16/01</h1>
        </div>
        <div class="blog-box">
            <div class="blog-img">
                <img src="../img/blog/b6.jpg" alt="" />
            </div>
            <div class="blog-details">
                <h4>AW20 Menswear Trends</h4>
                <p>
                    AW20 Menswear Trends are all about blending sophistication with a
                    touch of rebellion. From tailored outerwear to statement
                    accessories, these trends offer a contemporary and stylish approach
                    to men's fashion.
                </p>
                <a href="#">CONTINUE READING</a>
            </div>
            <h1>10/03</h1>
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