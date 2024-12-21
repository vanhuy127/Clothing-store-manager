<?php
require_once "../../../config/db.php";
require_once "../../../query/order/OrderBO.php";
require_once "../../../query/order/Order.php";
require_once "../../../query/constant/OrderStatus.php";

$orderBO = new OrderBO($conn);
$id = $_GET['id'];
$orderDB = $orderBO->getDetailOrderByID($id);
$orderDetails = $orderDB->getOrderDetails();
$datetime = new DateTime($orderDB->getDate());

function renderStatus($currentStatus)
{
    $availableStatuses = [];

    switch ($currentStatus) {
        case OrderStatus::$INIT:
            $availableStatuses = [
                OrderStatus::$INIT,
                OrderStatus::$PREPARING,
                OrderStatus::$CANCEL,
            ];
            break;

        case OrderStatus::$PREPARING:
            $availableStatuses = [
                OrderStatus::$PREPARING,
                OrderStatus::$SHIPPING,
                OrderStatus::$CANCEL,
            ];
            break;

        case OrderStatus::$SHIPPING:
            $availableStatuses = [
                OrderStatus::$SHIPPING,
                OrderStatus::$FINISH,
                OrderStatus::$REFUND,
            ];
            break;

        case OrderStatus::$FINISH:
        case OrderStatus::$REFUND:
        case OrderStatus::$CANCEL:
            $availableStatuses = [
                $currentStatus,
            ];
            break;
        default:
            break;
    }

    return $availableStatuses;
}

$statusArray = renderStatus($orderDB->getStatus());

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'];
    $order = new Order(orderID: $id, status: $status);

    if ($orderBO->updateOrderStatus($order)) {
        header("Location: _index.php?page=edit&id=" . $id);
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
                <h5>Cập nhật thông tin đơn hàng</h5>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <form class="px-3" action="" method="POST">
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="name">Họ và tên khách hàng</label>
                            <input class="form-control" type="text" id="name" name="name"
                                value="<?= htmlspecialchars($orderDB->getCustomer()['fullName'] ?? "") ?>" disabled>
                        </div>
                        <div class="form-group col-6">
                            <label for="name">Email</label>
                            <input class="form-control" type="text" id="name" name="name"
                                value="<?= htmlspecialchars($orderDB->getCustomer()['email'] ?? "") ?>" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="name">Số điện thoại</label>
                            <input class="form-control" type="text" id="name" name="name"
                                value="<?= htmlspecialchars($orderDB->getCustomer()['phone'] ?? "") ?>" disabled>
                        </div>
                        <div class="form-group col-6">
                            <label for="name">Địa chỉ</label>
                            <input class="form-control" type="text" id="name" name="name"
                                value="<?= htmlspecialchars($orderDB->getCustomer()['address'] ?? "") ?>" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="name">Ngày đặt mua</label>
                            <input class="form-control" type="text" id="name" name="name"
                                value="<?= htmlspecialchars($datetime->format('d-m-Y H:i:s')) ?>" disabled>
                        </div>
                        <div class="form-group col-6">
                            <label for="name">Tổng tiền phải trả</label>
                            <input class="form-control" type="text" id="name" name="name"
                                value="<?= number_format($orderDB->getTotalPrice(), 0, ',') . ' VND' ?>" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="name">Trạng thái đơn hàng</label>
                            <select class="form-control" id="unit" name="status" required>
                                <?php foreach ($statusArray as $i): ?>
                                <option value="<?= $i ?>" <?= $i == $orderDB->getStatus() ? 'selected' : '' ?>>
                                    <?= htmlspecialchars(OrderStatus::getStatusName($i)) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        STT
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Ảnh
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Tên mặt hàng
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Kích thước
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Màu sắc
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Số lượng
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Thành tiền
                                    </th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stt = 1;
                                ?>
                                <?php if ($orderDetails): ?>
                                <?php foreach ($orderDetails as $i): ?>
                                <tr>
                                    <td>
                                        <p class="text-xl text-secondary mb-0">
                                            <?= $stt++ ?>
                                        </p>
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <img src="../../../image-storage/<?= $i ? htmlspecialchars($i->getImage()) : 'no-product.png' ?>"
                                                class="avatar avatar-xl me-3" alt="Product Image" />
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xl text-secondary mb-0">
                                            <?= htmlspecialchars($i->getProductName()) ?>
                                        </p>
                                    </td>
                                    <td>
                                        <p class="text-xl text-secondary mb-0">
                                            <?= htmlspecialchars($i->getSize()) ?>
                                        </p>
                                    </td>
                                    <td>
                                        <p class="text-xl text-secondary mb-0">
                                            <?= htmlspecialchars($i->getColor()) ?>
                                        </p>
                                    </td>
                                    <td>
                                        <p class="text-xl text-secondary mb-0">
                                            <?= htmlspecialchars($i->getQuantity()) ?>
                                        </p>
                                    </td>
                                    <td>
                                        <p class="text-xl text-secondary mb-0">
                                            <?= number_format($i->getPrice(), 0, ',') . ' VND' ?>
                                        </p>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center">No order found.</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="submit" class="btn bg-gradient-primary">Cập nhật</button>
                        <a href="_index.php?page=show" class="btn bg-gradient-danger">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>