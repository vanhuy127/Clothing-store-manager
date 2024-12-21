<?php
require_once "../../../config/db.php";
require_once "../../../query/size/SizeBO.php";
require_once "../../../query/size/Size.php";

$sizeBO = new SizeBO($conn);
$id = $_GET['id'];
$sizeDB = $sizeBO->getSize($id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];

    $size = new Size($id, $name);

    if ($sizeBO->updateSize($size)) {
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
                <h5>Sửa kích thước</h5>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <form class="px-3" action="" method="POST">
                    <div class="form-group">
                        <label for="name">Tên kích thước</label>
                        <input class="form-control" type="text" id="name" name="name" value="<?= $sizeDB->getName() ?>"
                            required>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="submit" class="btn bg-gradient-primary">Sửa</button>
                        <a href="_index.php?page=show" class="btn bg-gradient-danger">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>