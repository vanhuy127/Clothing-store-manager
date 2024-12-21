<?php
require_once "../../../config/db.php";
require_once "../../../query/size/SizeBO.php";
require_once "../../../query/color/ColorBO.php";
require_once "../../../query/variant/Variant.php";
require_once "../../../query/variant/VariantBO.php";

$id = $_GET['id'];
$productID = $_GET['productID'];


$sizeBO = new SizeBO($conn);
$colorBO = new ColorBO($conn);
$variantBO = new VariantBO($conn);

$sizes = $sizeBO->getAllSizes();
$colors = $colorBO->getAllColors();

$variant = $variantBO->getByID($id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ form
    $sizeID = isset($_POST['sizeID']) && !empty($_POST['sizeID']) ? $_POST['sizeID'] : null;
    $colorID = isset($_POST['colorID']) && !empty($_POST['colorID']) ? $_POST['colorID'] : null;
    $stock = $_POST['stock'];
    $price = str_replace(',', '', $_POST['price']);

    // Cập nhật đối tượng Variant
    $variant->setSizeID($sizeID);
    $variant->setColorID($colorID);
    $variant->setStock($stock);
    $variant->setPrice($price);

    var_dump($variant);
    // Lưu thay đổi vào cơ sở dữ liệu
    if ($variantBO->updateVariant($variant)) {
        header("Location: _index.php?page=edit&id=$productID");
        exit();
    } else {
        echo "Lỗi khi cập nhật biến thể.";
    }
}
?>
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h5>Sửa biến thể</h5>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <form class="px-3" action="" method="POST">
                    <!-- Chọn kích thước -->
                    <div class="form-group">
                        <label for="sizeID">Chọn kích thước</label>
                        <select class="form-control" id="sizeID" name="sizeID">
                            <option value="" <?= $variant->getSizeID() ? '' : 'selected' ?>>Chọn kích thước</option>
                            <?php foreach ($sizes as $size) : ?>
                                <option value="<?php echo $size->getSizeID(); ?>"
                                    <?= $size->getSizeID() == $variant->getSizeID() ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($size->getName()) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Chọn màu sắc -->
                    <div class="form-group">
                        <label for="colorID">Chọn màu sắc</label>
                        <select class="form-control" id="colorID" name="colorID">
                            <option value="" <?= $variant->getColorID() ? '' : 'selected' ?>>Chọn màu sắc</option>
                            <?php foreach ($colors as $color) : ?>
                                <option value="<?php echo $color->getColorID(); ?>"
                                    style="color: <?php echo $color->getName() ?>;"
                                    <?= $color->getColorID() == $variant->getColorID() ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($color->getName()) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Nhập số lượng tồn kho -->
                    <div class="form-group">
                        <label for="stock">Số lượng tồn kho</label>
                        <input class="form-control" type="number" min="0" id="stock" name="stock"
                            value="<?= htmlspecialchars($variant->getStock()) ?>" required>
                    </div>

                    <!-- Nhập giá -->
                    <div class="form-group">
                        <label for="price">Giá</label>
                        <input class="form-control" type="text" min="0" id="price" name="price"
                            value="<?= htmlspecialchars(number_format($variant->getPrice(), 0, '.', ',')) ?>" required>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="submit" class="btn bg-gradient-primary">
                            Lưu
                        </button>
                        <a href="_index.php?page=edit&id=<?php echo htmlspecialchars($productID); ?>"
                            class="btn bg-gradient-danger">
                            Hủy
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>