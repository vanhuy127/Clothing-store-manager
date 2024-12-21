<?php
session_start();
require_once "../config/db.php";
require_once "../query/productDetail/ProductDetailBO.php";
require_once "../query/category/CategoryBO.php";
require_once "../query/cart/CartBO.php";
require_once "../query/constant/Role.php";

$SEARCH_SHOP_SESSION = "search_shop_session";
$PAGE_SIZE = 8;
$SESSION_TIMEOUT = 15 * 60; // 15 phút (tính bằng giây)

//=========================================================
// Kiểm tra và xóa session nếu đã hết hạn
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $SESSION_TIMEOUT)) {
    // Hết thời gian sống, xóa session
    unset($_SESSION[$SEARCH_SHOP_SESSION]);
    unset($_SESSION['last_activity']);
}

// Cập nhật thời gian hoạt động cuối cùng
$_SESSION['last_activity'] = time();
//=========================================================

$productDetailBO = new ProductDetailBO($conn);
$categoryBO = new CategoryBO($conn);
$cartBO = new CartBO($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Nếu người dùng gửi form tìm kiếm, đặt trang về 1
    $PAGE = 1;
} else {
    // Lấy trang từ query string hoặc session nếu không có
    $PAGE = isset($_GET['page']) ? (int)$_GET['page'] : ($_SESSION[$SEARCH_SHOP_SESSION]['page'] ?? 1);
}

// Cập nhật trang hiện tại vào session
$_SESSION[$SEARCH_SHOP_SESSION]['page'] = $PAGE;

$searchSession = $_SESSION[$SEARCH_SHOP_SESSION]['search'] ?? '';
$categorySession = $_SESSION[$SEARCH_SHOP_SESSION]['category'] ?? 0;
$priceFromSession = $_SESSION[$SEARCH_SHOP_SESSION]['price_from'] ?? 0;
$priceToSession = $_SESSION[$SEARCH_SHOP_SESSION]['price_to'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $search = htmlspecialchars($_POST['search'] ?? '');
    $category = htmlspecialchars($_POST['category'] ?? 0);
    $priceFrom = (float) str_replace(',', '', $_POST['price_from'] ?? 0);
    $priceTo = (float) str_replace(',', '', $_POST['price_to'] ?? 0);

    $_SESSION[$SEARCH_SHOP_SESSION] = [
        'search' => $search,
        'category' => $category,
        'price_from' => $priceFrom,
        'price_to' => $priceTo,
    ];

    $searchSession = $search;
    $categorySession = $category;
    $priceFromSession = $priceFrom;
    $priceToSession = $priceTo;
}

$productDetails = $productDetailBO->getAllProductDetails(
    $searchSession,
    $categorySession,
    $priceFromSession,
    $priceToSession,
    $PAGE,
    $PAGE_SIZE
);
$rowCount = $productDetailBO->getCount($searchSession, $categorySession, $priceFromSession, $priceToSession);

$NUM_PAGE = ceil($rowCount / $PAGE_SIZE);

$categories = $categoryBO->showAllCategories();

$count = $cartBO->getCount();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cara</title>

    <!-- ADMINPAGE THEME -->
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- CSS Files -->
    <link id="pagestyle" href="../assets/css/argon-dashboard.css?v=2.1.0" rel="stylesheet" />
    <!-- ADMINPAGE THEME -->

    <link rel="icon" type="image/x-icon" href="../img/icon1.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" />
    <link rel="stylesheet" href="../style.css" />
</head>

<body>
    <section id="header">
        <p class="logo" style="font-size: 25px; color: #484848; font-weight: 600">
            FASCO
        </p>
        <div>
            <ul id="navbar">
                <li><a href="../index.php">Home</a></li>
                <li><a class="active" href="shop.php">Shop</a></li>
                <li><a href="blog.php">Blog</a></li>

                <li id="lg-bag">
                    <a href="cart.php" style="z-index: -1;"><i class="bx bx-shopping-bag"></i></a>
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
            <a href="cart.php"><i class="bx bx-shopping-bag"></i></a>
            <i id="bar" class="bx bx-menu"></i>
        </div>
    </section>

    <section id="page-header">
        <h2>#stayhome</h2>
        <p>save more with coupons & up to 70% off!</p>
    </section>

    <form class="px-7 mt-5 row" method="POST" action="">
        <div class="form-group col-sm">
            <label for="example-text-input" class="form-control-label">Tìm kiếm</label>
            <input class="form-control" type="text" name="search" value="<?= htmlspecialchars($searchSession) ?>"
                id="example-text-input">
        </div>
        <div class="form-group col-sm">
            <label for="exampleFormControlSelect1">Danh mục</label>
            <select class="form-control" name="category" id="exampleFormControlSelect1">
                <option value="">--Chọn danh mục--</option>
                <?php foreach ($categories as $c): ?>
                    <option value="<?= htmlspecialchars($c->getCategoryID()) ?>"
                        <?= $categorySession == $c->getCategoryID() ? 'selected' : '' ?>>
                        <?= htmlspecialchars($c->getCategoryName()) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group col-sm">
            <label for="example-number-input" class="form-control-label">Từ</label>
            <div class="input-group">
                <input class="form-control price-input" type="text" name="price_from"
                    value="<?= htmlspecialchars(number_format($priceFromSession)) ?>">
                <span class="input-group-text" id="basic-addon2">VND</span>
            </div>
        </div>
        <div class="form-group col-sm">
            <label for="example-number-input" class="form-control-label">Đến</label>
            <div class="input-group">
                <input class="form-control price-input" type="text" name="price_to"
                    value="<?= htmlspecialchars(number_format($priceToSession)) ?>">
                <span class="input-group-text" id="basic-addon2">VND</span>
            </div>
        </div>
        <button type="submit" class="btn btn-primary col-2 h-50 align-self-end">Tìm kiếm</button>
    </form>

    <section id="product1" class="section-p1" style="padding-top: 0 !important;">
        <div class="pro-container">
            <!-- Hiển thị danh sách sản phẩm -->
            <?php if (!empty($productDetails)): ?>
                <?php foreach ($productDetails as $detail): ?>
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
                    <div class="pro" onclick="window.location.href='product.php?id=<?= $detail->getProductID() ?>';">
                        <img class="shirt" src="../image-storage/<?= $firstImagePath ?>" alt="Product Image" />
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
                        <a
                            href="./cart/addToCart.php?id=<?= $detail->getProductID() ?>&vid=<?= $detail->getVariants()[0]['id'] ?>"><i
                                class="bx bx-cart cart"></i></a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <h4 class="mx-auto">No products found.</h4>
            <?php endif; ?>
        </div>
    </section>

    <section id="pagination" class="section-p1 gap-2 row justify-content-center">
        <?php
        // Hiển thị liên kết trang
        for ($pageNum = 1; $pageNum <= $NUM_PAGE; $pageNum++) {
            if ($pageNum == $PAGE) {
                echo "<a href='#' class='opacity-6' style='width: 50px'>$pageNum</a>";
            } else {
                echo "<a href='?page=$pageNum' style='width: 50px'>$pageNum</a>";
            }
        }
        ?>
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

    <!-- ADMINPAGE THEME -->
    <!--   Core JS Files   -->
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../assets/js/argon-dashboard.min.js?v=2.1.0"></script>
    <!-- ADMINPAGE THEME -->

    <script>
        // Chọn tất cả các input có class "price-input"
        const priceInputs = document.querySelectorAll('.price-input');

        priceInputs.forEach(input => {
            input.addEventListener('input', function() {
                const value = this.value.replace(/,/g, ''); // Loại bỏ dấu phẩy
                if (!isNaN(value) && value.length > 0) {
                    // Đảm bảo không có giá trị lỗi và định dạng lại
                    this.value = Number(value).toLocaleString('en-US');
                } else {
                    this.value = ''; // Xóa nếu không phải số hợp lệ
                }
            });
        });
    </script>

    <script src="../script.js"></script>
</body>

</html>