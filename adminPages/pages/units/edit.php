<?php
require_once "../../../config/db.php";
require_once "../../../query/unit/UnitBO.php";
require_once "../../../query/unit/Unit.php";

$unitBO = new UnitBO($conn);
$id = $_GET['id'];
$unitDB = $unitBO->getUnit($id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];

    $unit = new Unit($id, $name);

    if ($unitBO->updateUnit($unit)) {
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
                <h5>Sửa đơn vị</h5>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <form class="px-3" action="" method="POST">
                    <div class="form-group">
                        <label for="name">Tên đơn vị</label>
                        <input class="form-control" type="text" id="name" name="name" value="<?= $unitDB->getName() ?>"
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