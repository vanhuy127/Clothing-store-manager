<?php
require_once "../config/db.php";
require_once "../query/productDetail/ProductDetailBO.php";
require_once "../query/cart/CartBO.php";
require_once "../query/constant/Role.php";

$id = $_GET['id'];

$productDetailBO = new ProductDetailBO($conn);
$cartBO = new CartBO($conn);

$count = $cartBO->getCount();

$featureProducts = $productDetailBO->getFeatureProducts($limit = 4);

$product = $productDetailBO->getProductDetailByID($id);
$images = $product->getImages();
$variants = $product->getVariants();

// Xử lý unique size và unique color
$uniqueSizes = [];
$uniqueColors = [];
foreach ($variants as $variant) {
    // Thêm sizeName nếu chưa tồn tại trong $uniqueSizes
    if (!in_array($variant['sizeName'], $uniqueSizes)) {
        $uniqueSizes[] = $variant['sizeName'];
    }
    // Thêm colorCode nếu chưa tồn tại trong $uniqueColors
    if (!in_array($variant['colorCode'], $uniqueColors)) {
        $uniqueColors[] = $variant['colorCode'];
    }
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" />
    <link rel="stylesheet" href="../style.css" />
    <link rel="stylesheet" href="product.css" />

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
                <li><a class="" href="shop.php">Shop</a></li>
                <li><a href="blog.php">Blog</a></li>
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

    <section id="prodetails" class="section-p1">
        <div class="single-pro-image">
            <img src="../image-storage/<?= $images ? htmlspecialchars($images[0]['path']) : 'no-product.png'  ?>"
                width="100%" id="MainImg" alt="" />

            <div class="small-img-group">
                <?php if (!empty($images)): ?>
                <?php foreach ($images as $i): ?>
                <div class="small-img-col">
                    <img src="../image-storage/<?= $i ? htmlspecialchars($i['path']) : 'no-product.png'  ?>"
                        width="100%" class="small-img" alt="" />
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <!-- <h4 class="mx-auto">No images found.</h4> -->
                <?php endif; ?>
            </div>
        </div>

        <div class="single-pro-details">
            <!-- <h6>Home / T-Shirt</h6> -->
            <h4><?= htmlspecialchars($product->getProductName()) ?></h4>
            <h2>Vui lòng chọn biến thể!!</h2>
            <div class="color-options">
                <span>Stock: </span><span class="stock">Vui lòng chọn biến thể!!</span>
            </div>
            <div class="size-options">
                <span>Select Size:</span>
                <div class="sizes">
                    <?php foreach ($uniqueSizes as $size): ?>
                    <div class="size"><?= htmlspecialchars($size) ?></div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="color-options">
                <span>Select Color:</span>
                <div class="colors">
                    <?php foreach ($uniqueColors as $color): ?>
                    <div class="color" style="background-color: <?= htmlspecialchars($color) ?>"></div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div style="display: flex; align-items: center; gap: 20px">
                <div class="change-quantity">
                    <i class="bx bx-minus"></i>
                    <input type="number" class="quantityInput" value="1" />
                    <i class="bx bx-plus"></i>
                </div>
                <button class="normal add-to-card">Add To Cart</button>
            </div>
            <h4>Product Details</h4>
            <span><?= $product->getDescription() ? htmlspecialchars($product->getDescription()) : "No description" ?></span>
        </div>
    </section>

    <section id="product1" class="section-p1">
        <h2>Featured Products</h2>
        <p>Summer Collection New Modern Design</p>
        <div class="pro-container">
            <!-- FUEATURE PRODUCT -->
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
                onclick="window.location.href='../userPages/product.php?id=<?= $detail->getProductID() ?>';">
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
                <a href="../userPages/cart/addToCart.php?id=<?= $detail->getProductID() ?>"><i
                        class="bx bx-cart cart"></i></a>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <h4 class="mx-auto">No featured products found.</h4>
            <?php endif; ?>
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

    <script>
    var MainImg = document.getElementById("MainImg");
    var smallImgs = document.getElementsByClassName("small-img");

    // Loop through each small image and attach an event listener
    for (let i = 0; i < smallImgs.length; i++) {
        smallImgs[i].onclick = function() {
            MainImg.src = this.src; // Set the main image source to the clicked image source
        };
    }
    </script>

    <script src="../script.js"></script>
    <script>
    // Hàm chuyển đổi RGBA hoặc RGB sang HEX
    function rgbToHex(rgb) {
        const match = rgb.match(/\d+/g); // Tách các số từ chuỗi RGB hoặc RGBA
        if (!match || match.length < 3) return null;

        let r = parseInt(match[0]).toString(16).padStart(2, '0'); // Đảm bảo 2 ký tự HEX
        let g = parseInt(match[1]).toString(16).padStart(2, '0');
        let b = parseInt(match[2]).toString(16).padStart(2, '0');

        return `#${r}${g}${b}`; // Trả về giá trị HEX
    }
    </script>
    <script>
    const sizeElements = document.querySelectorAll(".size");
    const colorElements = document.querySelectorAll(".color");
    const priceDisplay = document.querySelector(".single-pro-details > h2");
    const stockDisplay = document.querySelector(".stock");
    const addToCartBtn = document.querySelector(".add-to-card");

    const productId = <?= $id ?>; // Lấy ID sản phẩm hiện tại

    let selectedSize = null;
    let selectedColor = null;
    let vid = 0;

    // Hàm cập nhật giá
    function updatePrice() {
        if (selectedSize && selectedColor) {

            // Construct the query parameters for the GET request
            const url =
                `getVariantPrice.php?color=${encodeURIComponent(selectedColor)}&size=${encodeURIComponent(selectedSize)}&productId=${productId}`;

            fetch(url, {
                    method: "GET",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    }
                })
                .then(response => response.text()) // Use text() to log the raw response
                .then(data => {
                    console.log(data); // Check the raw response from the server
                    try {
                        const jsonData = JSON.parse(data); // Manually parse the JSON
                        if (jsonData.success) {
                            priceDisplay.textContent = `${jsonData.price}`;
                            stockDisplay.textContent = `${jsonData.stock}`;
                            vid = jsonData.vid;
                            console.log("vid: ", vid);

                        } else {
                            priceDisplay.textContent = jsonData.price; // Error message for price
                            stockDisplay.textContent = jsonData.stock; // Error message for stock
                            vid = 0;
                        }
                    } catch (e) {
                        console.error("Error parsing JSON:", e);
                        priceDisplay.textContent = "Lỗi dữ liệu từ máy chủ";
                        stockDisplay.textContent = "";
                    }
                })
                .catch(error => console.error("Error fetching price:", error));
        }
    }

    // xử lý nút thêm vào giỏ hàng
    addToCartBtn.addEventListener("click", () => {
        if (vid) {
            const quantity = document.querySelector(".quantityInput").value;
            const url = `./cart/addToCart.php?id=${productId}&vid=${vid}&quantity=${quantity}`;
            console.log(url);
            window.location.href = url; // Điều hướng tới URL với id và vid
        } else {
            alert("Vui lòng chọn kích thước và màu sắc trước khi thêm vào giỏ hàng!");
        }
    });

    // Xử lý chọn kích thước
    sizeElements.forEach(size => {
        size.addEventListener("click", function() {
            selectedSize = this.textContent.trim();
            sizeElements.forEach(el => el.classList.remove("active"));
            this.classList.add("active");
            updatePrice();
        });
    });

    // Xử lý chọn màu sắc
    colorElements.forEach(color => {
        color.addEventListener("click", function() {
            selectedColor = rgbToHex(this.style.backgroundColor);
            colorElements.forEach(el => el.classList.remove("active"));
            this.classList.add("active");
            updatePrice();
        });
    });
    </script>
    <script>
    document.addEventListener("DOMContentLoaded", () => {
        // Get references to the elements
        const minusButton = document.querySelector(".bx-minus");
        const plusButton = document.querySelector(".bx-plus");
        const quantityInput = document.querySelector(".change-quantity input");
        const stockDisplay = document.querySelector(".stock");

        // Ensure the value cannot go below 1
        const minValue = 1;

        // Function to get current stock value
        function getStockValue() {
            const stockValue = parseInt(stockDisplay.textContent.trim(), 10);
            return isNaN(stockValue) ? 0 : stockValue; // Return 0 if stock value is invalid
        }

        // Function to check if stock is valid (greater than 0)
        function isStockAvailable() {
            return getStockValue() > 0;
        }

        // Handle minus button click
        minusButton.addEventListener("click", () => {
            if (isStockAvailable()) {
                let currentValue = parseInt(quantityInput.value, 10) || minValue;
                if (currentValue > minValue) {
                    quantityInput.value = currentValue - 1;
                }
            } else {
                alert("Stock is unavailable!"); // Optional alert message
            }
        });

        // Handle plus button click
        plusButton.addEventListener("click", () => {
            if (isStockAvailable()) {
                let currentValue = parseInt(quantityInput.value, 10) || minValue;
                let stockValue = getStockValue();

                if (currentValue < stockValue) {
                    quantityInput.value = currentValue + 1; // Increase value if less than stock
                } else {
                    alert(`Số lượng tối đa là ${stockValue}.`); // Optional alert when reaching stock
                }
            } else {
                alert("Stock is unavailable!"); // Optional alert message
            }
        });

        // Prevent input values less than 1 or greater than stock when manually changed
        quantityInput.addEventListener("input", () => {
            let stockValue = getStockValue();
            let currentValue = parseInt(quantityInput.value, 10);

            if (isNaN(currentValue) || currentValue < minValue) {
                quantityInput.value = minValue; // Set to min if invalid or below 1
            } else if (currentValue > stockValue) {
                quantityInput.value = stockValue; // Set to stock value if exceeding it
                alert(`Số lượng tối đa là ${stockValue}.`);
            }
        });
    });
    </script>
</body>

</html>