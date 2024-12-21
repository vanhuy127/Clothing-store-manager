<?php
require_once "../../../config/db.php";
require_once "../../../query/supplier/SupplierBO.php";
require_once "../../../query/supplier/Supplier.php";

$supplierBO = new SupplierBO($conn);
$id = $_GET['id'];
$supplierDB = $supplierBO->getSupplierByID($id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $contactName = $_POST['contactName'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    $supplier = new Supplier($id, $name, $contactName, $phone, $email, $address);

    if ($supplierBO->updateSupplier($supplier)) {
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
                <h5>Sửa nhà cung cấp</h5>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <form class="px-3" action="" method="POST">
                    <div class="form-group">
                        <label for="name">Tên nhà cung cấp</label>
                        <input class="form-control" type="text" id="name" name="name"
                            value="<?= $supplierDB->getName() ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="contactName">Tên người liên hệ</label>
                        <input class="form-control" type="text" id="contactName" name="contactName"
                            value="<?= $supplierDB->getContactName() ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Số điện thoại</label>
                        <input class="form-control" type="text" id="phone" name="phone"
                            value="<?= $supplierDB->getPhone() ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input class="form-control" type="email" id="email" name="email"
                            value="<?= $supplierDB->getEmail() ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Địa chỉ</label>
                        <input class="form-control" type="text" id="address" name="address"
                            value="<?= $supplierDB->getAddress() ?>" required>
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