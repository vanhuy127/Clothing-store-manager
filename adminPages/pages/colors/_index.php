<?php
require_once "../../../query/constant/Role.php";

ob_start(); //<--- Dòng code yêu cầu Output Buffering
// Cấu hình để PHP hiện tất cả Lỗi (ERROR) và Cảnh báo (WARNING)
// Chỉ nên sử dụng khi đang phát triển
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Phân quyền
session_start();

//Kiểm tra đăng nhập
if (!isset($_SESSION['userID'])) {
    header("Location: ../../../login.php");
}

if (isset($_SESSION['roles']) && in_array(Role::$ADMIN, $_SESSION['roles'])) {
    //Cho phép truy cập
} else {
    //Không cho phép truy cập
    header("Location: ../notRole/_index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="apple-touch-icon" sizes="76x76" href="../../../assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="../../../assets/img/favicon.png" />
    <title>YUHNAV SHOP</title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- CSS Files -->
    <link id="pagestyle" href="../../../assets/css/argon-dashboard.css?v=2.1.0" rel="stylesheet" />
</head>

<body class="g-sidenav-show bg-gray-100">
    <div class="min-height-300 bg-dark position-absolute w-100"></div>
    <aside
        class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4"
        id="sidenav-main">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
                aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/argon-dashboard/pages/dashboard.html "
                target="_blank">
                <img src="../../../assets/img/logo-ct-dark.png" width="26px" height="26px"
                    class="navbar-brand-img h-100" alt="main_logo" />
                <span class="ms-1 font-weight-bold">YUHNAV SHOP</span>
            </a>
        </div>
        <hr class="horizontal dark mt-0" />
        <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="../products/_index.php?page=show">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-calendar-grid-58 text-dark text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Quản lý mặt hàng</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../suppliers/_index.php?page=show">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-calendar-grid-58 text-dark text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Quản lý nhà cung cấp</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../users/_index.php?page=show">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-calendar-grid-58 text-dark text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Quản lý khách hàng</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../units/_index.php?page=show">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-calendar-grid-58 text-dark text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Quản lý đơn vị</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../categories/_index.php?page=show">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-calendar-grid-58 text-dark text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Quản lý danh mục</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../sizes/_index.php?page=show">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-calendar-grid-58 text-dark text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Quản lý kích thước</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="_index.php?page=show">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-calendar-grid-58 text-dark text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Quản lý màu sắc</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../orders/_index.php?page=show">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-calendar-grid-58 text-dark text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Quản lý đơn hàng</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>
    <main class="main-content position-relative border-radius-lg">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
            data-scroll="false">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <h6 class="font-weight-bolder text-white mb-0">Quản lý nhà cung cấp</h6>
                </nav>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <ul class="navbar-nav justify-content-end w-100">
                        <li class="nav-item d-flex align-items-center">
                            <span class="mx-3">Xin chào, <?= htmlspecialchars($_SESSION['username']) ?></span>
                            <div>
                                <a href="../../../logout.php" class="nav-link text-white font-weight-bold px-0">
                                    <i class="fa fa-user me-sm-1"></i>
                                    <span class="d-sm-inline d-none">Sign out</span>
                                </a>
                            </div>
                        </li>
                        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line bg-white"></i>
                                    <i class="sidenav-toggler-line bg-white"></i>
                                    <i class="sidenav-toggler-line bg-white"></i>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item px-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-white p-0">
                                <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <!-- MAIN -->
            <?php
            if (isset($_GET['page'])) {
                switch ($_GET['page']) {
                    case 'show':
                        require_once './show.php';
                        break;
                    case 'add':
                        require_once './add.php';
                        break;
                    case 'edit':
                        require_once './edit.php';
                        break;
                    case 'delete':
                        require_once './delete.php';
                        break;
                    default:
                        require_once './show.php';
                        break;
                }
            }
            ?>
            <!-- END MAIN -->
            <footer class="footer pt-3">
                <div class="container-fluid">
                    <div class="row align-items-center justify-content-lg-between">
                        <div class="col-lg-6 mb-lg-0 mb-4">
                            <div class="copyright text-center text-sm text-muted text-lg-start">
                                ©
                                <script>
                                document.write(new Date().getFullYear());
                                </script>
                                , made with <i class="fa fa-heart"></i> by
                                <a href="#" class="font-weight-bold" target="_blank">YUHNAV
                                    SHOP</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </main>
    <!--   Core JS Files   -->
    <script src="../../../assets/js/core/popper.min.js"></script>
    <script src="../../../assets/js/core/bootstrap.min.js"></script>
    <script src="../../../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../../../assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script>
    // Lấy input price
    const priceInput = document.getElementById('price');

    // Định dạng giá theo hàng ngàn
    priceInput.addEventListener('input', function() {
        const value = this.value.replace(/,/g, ''); // Loại bỏ dấu phẩy
        if (!isNaN(value) && value.length > 0) {
            // Đảm bảo không có giá trị lỗi và định dạng lại
            this.value = Number(value).toLocaleString('en-US');
        } else {
            this.value = ''; // Xóa nếu không phải số hợp lệ
        }
    });
    </script>
    <script>
    var win = navigator.platform.indexOf("Win") > -1;
    if (win && document.querySelector("#sidenav-scrollbar")) {
        var options = {
            damping: "0.5",
        };
        Scrollbar.init(document.querySelector("#sidenav-scrollbar"), options);
    }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../../../assets/js/argon-dashboard.min.js?v=2.1.0"></script>
</body>

</html>
<?php
ob_end_flush(); //<--- Dòng code yêu cầu in ra tất cả và trả về reponse cho người dùng (Client) 
?>