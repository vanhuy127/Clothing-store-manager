<?php
require_once "../../../config/db.php";
require_once "../../../query/product/Product.php";

require_once "../../../query/product/ProductBO.php";
require_once "../../../query/category/CategoryBO.php";
require_once "../../../query/supplier/SupplierBO.php";
require_once "../../../query/unit/UnitBO.php";
require_once "../../../query/image/ImageBO.php";
require_once "../../../query/variant/VariantBO.php";

$productBO = new ProductBO($conn);
$categoryBO = new CategoryBO($conn);
$supplierBO = new SupplierBO($conn);
$unitBO = new UnitBO($conn);
$imageBO = new ImageBO($conn);
$variantBO = new VariantBO($conn);

$id = $_GET['id'];

$products = $productBO->showAllProducts();
$categories = $categoryBO->showAllCategories();
$suppliers = $supplierBO->showAllSuppliers();
$units = $unitBO->getAllUnits();

$images = $imageBO->showImagesByProductID($id);
$product = $productBO->showProduct($id);
$detailVariants = $variantBO->getDetailVariant($id);

usort($images, function ($a, $b) {
    return $a->getOrderNumber() <=> $b->getOrderNumber();
});

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $rate = $_POST['rate'];
    $unitID = $_POST['unitID'];
    $supplierID = $_POST['supplierID'];
    $categoryID = $_POST['categoryID'];
    $isSelling = isset($_POST['isSelling']) ? 1 : 0;

    $product = new Product($id, $name, $description, $rate, $unitID, $supplierID, $categoryID, $isSelling);

    $productBO = new ProductBO($conn);

    if ($productBO->editProduct($product) == 1) {
        header("Location: _index.php?page=show");
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
                <h5>Sửa mặt hàng</h5>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <form class="px-3" action="" method="POST">
                    <div class="form-group">
                        <label for="productName">Tên mặt hàng</label>
                        <input class="form-control" type="text" id="productName" name="name"
                            value="<?= $product->getName() ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Mô tả</label>
                        <textarea class="form-control" id="description" name="description"
                            rows="3"><?= htmlspecialchars($product->getDescription()) ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="description">Đánh giá</label>
                        <input class="form-control" type="number" min="1" max="5" id="rate" name="rate"
                            value="<?= $product->getRate() ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="unit">Đơn vị</label>
                        <select class="form-control" id="unit" name="unitID" required>
                            <option value="">-----Chọn đơn vị-----</option>
                            <?php foreach ($units as $u): ?>
                                <option value="<?= $u->getUnitID() ?>"
                                    <?= $product->getUnitID() == $u->getUnitID() ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($u->getName()) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="supplier">Nhà cung cấp</label>
                        <select class="form-control" id="supplier" name="supplierID" required>
                            <option value="">-----Chọn nhà cung cấp-----</option>
                            <?php foreach ($suppliers as $s): ?>
                                <option value="<?= $s->getSupplierID() ?>"
                                    <?= $product->getSupplierID() == $s->getSupplierID() ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($s->getName()) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="category">Loại hàng</label>
                        <select class="form-control" id="category" name="categoryID" required>
                            <option value="">-----Chọn loại hàng-----</option>
                            <?php foreach ($categories as $c): ?>
                                <option value="<?= $c->getCategoryID() ?>"
                                    <?= $product->getCategoryID() == $c->getCategoryID() ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($c->getCategoryName()) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="isSelling" name="isSelling"
                            <?= $product->getIsSelling() ? 'checked' : '' ?>>
                        <label class="form-check-label" for="isSelling">Đang bán</label>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="submit" class="btn bg-gradient-primary">
                            Sửa
                        </button>
                        <a href="_index.php?page=show" type="submit" class="btn bg-gradient-danger">
                            Hủy
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h5>Thêm ảnh</h5>
                <a type="button" class="btn bg-gradient-primary" style="margin-bottom: 0 !important;"
                    href="_index.php?page=add_image&productID=<?= $id ?>">
                    Thêm
                </a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ảnh</th>
                                <th
                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 col-6">
                                    Thứ tự hiển thị</th>
                                <th class="text-secondary opacity-7"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($images)): ?>
                                <?php foreach ($images as $image): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <img src="../../../image-storage/<?= htmlspecialchars($image->getPath()) ?>"
                                                    class="avatar avatar-xl me-3" alt="Product Image" />
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xl text-secondary mb-0">
                                                <?= htmlspecialchars($image->getOrderNumber()) ?>
                                            </p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <a href="_index.php?page=edit_image&id=<?= $image->getImageID() ?>&productID=<?= $product->getProductID() ?>"
                                                class="btn bg-gradient-info" data-toggle="tooltip" title="Edit Image"
                                                style="margin-bottom: 0 !important;">
                                                Edit
                                            </a>
                                            <a href="_index.php?page=delete_image&id=<?= $image->getImageID() ?>&productID=<?= $id ?>"
                                                class="btn bg-gradient-danger" data-toggle="tooltip" title="Delete Image"
                                                style="margin-bottom: 0 !important;"
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa ảnh này?')">
                                                Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="text-center">
                                        <p class="text-secondary mb-0">Không có ảnh nào được liên kết với sản phẩm này.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h5>Thêm biến thể</h5>
                <a type="button" class="btn bg-gradient-primary" style="margin-bottom: 0 !important;"
                    href="_index.php?page=add_variant&productID=<?= $id ?>">
                    Thêm
                </a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">kích
                                    thước</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">màu
                                    sắc</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">giá
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">tồn
                                    kho
                                </th>
                                <th class="text-secondary opacity-7"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($detailVariants)): ?>
                                <?php foreach ($detailVariants as $detail):
                                    $variant = $detail['variant'];
                                    $sizeName = $detail['sizeName'] ?? '-';
                                    $colorCode = $detail['colorCode'] ?? '-';
                                ?>
                                    <tr>
                                        <!-- Kích thước -->
                                        <td>
                                            <p class="text-xl text-secondary mb-0">
                                                <?= htmlspecialchars($sizeName) ?>
                                            </p>
                                        </td>
                                        <!-- Màu sắc -->
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div
                                                    style="width: 30px; height: 30px; background-color: <?= htmlspecialchars($colorCode) ?>; border-radius: 5px;">
                                                </div>
                                                <p class="text-xl text-secondary mb-0">
                                                    <?= htmlspecialchars($colorCode) ?>
                                                </p>
                                            </div>
                                        </td>
                                        <!-- Giá -->
                                        <td>
                                            <p class="text-xl text-secondary mb-0">
                                                <?= number_format($variant->getPrice(), 0, ',') ?> VND
                                            </p>
                                        </td>
                                        <!-- Kho -->
                                        <td>
                                            <p class="text-xl text-secondary mb-0">
                                                <?= htmlspecialchars($variant->getStock()) ?>
                                            </p>
                                        </td>
                                        <!-- Hành động -->
                                        <td class="align-middle text-center">
                                            <a href="_index.php?page=edit_variant&id=<?= $variant->getVariantID() ?>&productID=<?= htmlspecialchars($id) ?>"
                                                class="btn bg-gradient-info" data-toggle="tooltip" title="Sửa biến thể"
                                                style="margin-bottom: 0 !important;">
                                                Edit
                                            </a>
                                            <a href="_index.php?page=delete_variant&id=<?= $variant->getVariantID() ?>&productID=<?= htmlspecialchars($id) ?>"
                                                class="btn bg-gradient-danger" data-toggle="tooltip" title="Xóa biến thể"
                                                style="margin-bottom: 0 !important;"
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa biến thể này?')">
                                                Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <p class="text-secondary mb-0">Không có biến thể nào cho sản phẩm này.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>