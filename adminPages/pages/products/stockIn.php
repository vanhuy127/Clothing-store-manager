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
    $stock = $_POST['stockIn'];
    $variantUP = new Variant(variantID: $id, stock: $stock, productID: $productID);
    if ($variantBO->stockIn($variantUP)) {
        header("Location: _index.php?page=edit&id=$productID");
        exit();
    } else {
        echo "Lỗi khi nhập kho.";
        exit();
    }
}
?>
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h5>Nhập thêm hàng</h5>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <form class="px-3" action="" method="POST">
                    <!-- Chọn kích thước -->
                    <div class="form-group">
                        <label for="sizeID">Chọn kích thước</label>
                        <select class="form-control" disabled id="sizeID" name="sizeID">
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
                        <select class="form-control" disabled id="colorID" name="colorID">
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
                        <input class="form-control" disabled type="number" min="0" id="stock" name="stock"
                            value="<?= htmlspecialchars($variant->getStock()) ?>" required>
                    </div>

                    <!-- Nhập giá -->
                    <div class="form-group">
                        <label for="price">Giá</label>
                        <input class="form-control" disabled type="text" min="0" id="price" name="price"
                            value="<?= htmlspecialchars(number_format($variant->getPrice(), 0, '.', ',')) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="stock">Số lượng nhập hàng</label>
                        <input class="form-control" type="number" id="stock" name="stockIn" value="0" required>
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