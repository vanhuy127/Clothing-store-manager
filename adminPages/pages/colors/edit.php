<?php
require_once "../../../config/db.php";
require_once "../../../query/color/ColorBO.php";
require_once "../../../query/color/Color.php";

$colorBO = new ColorBO($conn);
$id = $_GET['id'];

$colorDB = $colorBO->getColorByID($id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $colorCode = $_POST['color-input'];

    $color = new Color($id, $name, $colorCode);

    if ($colorBO->updateColor($color)) {
        header("Location: _index.php?page=show");
        exit();
    } else {
        echo "sửa màu không thành công!";
        exit();
    }
}
?>
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h5>Sửa màu</h5>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <form class="px-3" action="" method="POST">
                    <div class="form-group">
                        <label for="name">Tên màu</label>
                        <input class="form-control" type="text" id="name" name="name" value="<?= $colorDB->getName() ?>"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="color-input" class="form-control-label">Chọn màu</label>
                        <input class="form-control" type="color" value="<?= $colorDB->getColorCode() ?>"
                            id="color-input" name="color-input" required>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="submit" class="btn bg-gradient-primary">Thêm</button>
                        <a href="_index.php?page=show" class="btn bg-gradient-danger">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>