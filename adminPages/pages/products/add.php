<?php
require_once "../../../config/db.php";
require_once "../../../query/product/ProductBO.php";
require_once "../../../query/product/Product.php";
require_once "../../../query/category/CategoryBO.php";
require_once "../../../query/supplier/SupplierBO.php";
require_once "../../../query/unit/UnitBO.php";
$productBO = new ProductBO($conn);
$categoryBO = new CategoryBO($conn);
$supplierBO = new SupplierBO($conn);
$unitBO = new UnitBO($conn);

$products = $productBO->showAllProducts();
$categories = $categoryBO->showAllCategories();
$suppliers = $supplierBO->showAllSuppliers();
$units = $unitBO->getAllUnits();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $rate = 1;
    $unitID = $_POST['unitID'];
    $supplierID = $_POST['supplierID'];
    $categoryID = $_POST['categoryID'];
    $isSelling = isset($_POST['isSelling']) ? 1 : 0;

    $product = new Product(null, $name, $description, $rate, $unitID, $supplierID, $categoryID, $isSelling);

    $productBO = new ProductBO($conn);
    $newProductID = $productBO->addProduct($product);
    if ($newProductID) {
        header("Location: _index.php?page=edit&id=$newProductID");
        exit();
    } else {
        exit();
    }
}
?>
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h5>Thêm mặt hàng</h5>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <form class="px-3" action="" method="POST">
                    <div class="form-group">
                        <label for="productName">Tên mặt hàng</label>
                        <input class="form-control" type="text" id="productName" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Mô tả</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="unit">Đơn vị</label>
                        <select class="form-control" id="unit" name="unitID" required>
                            <option value="">-----Chọn đơn vị-----</option>
                            <?php foreach ($units as $u): ?>
                            <option value="<?= $u->getUnitID() ?>"><?= htmlspecialchars($u->getName()) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="supplier">Nhà cung cấp</label>
                        <select class="form-control" id="supplier" name="supplierID" required>
                            <option value="">-----Chọn nhà cung cấp-----</option>
                            <?php foreach ($suppliers as $s): ?>
                            <option value="<?= $s->getSupplierID() ?>"><?= htmlspecialchars($s->getName()) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="category">Loại hàng</label>
                        <select class="form-control" id="category" name="categoryID" required>
                            <option value="">-----Chọn loại hàng-----</option>
                            <?php foreach ($categories as $c): ?>
                            <option value="<?= $c->getCategoryID() ?>"><?= htmlspecialchars($c->getCategoryName()) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="isSelling" name="isSelling" checked>
                        <label class="form-check-label" for="isSelling">Đang bán</label>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="submit" class="btn bg-gradient-primary">
                            Thêm
                        </button>
                        <a href="_index.php?page=show" type="submit" class="btn bg-gradient-danger">
                            Hủy
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>