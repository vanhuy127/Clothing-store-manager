<?php
require_once "../../../config/db.php";
require_once "../../../query/order/OrderBO.php";
require_once "../../../query/constant/OrderStatus.php";
$orderBO = new OrderBO($conn);
$orders = $orderBO->getAllOrder();
$orderStatus = new OrderStatus();
?>
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h5>Danh sách đơn hàng</h5>
                <!-- <a type="button" class="btn bg-gradient-primary" style="margin-bottom: 0 !important;"
                    href="_index.php?page=add">
                    Thêm
                </a> -->
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    STT
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Tên khách hàng
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Ngày đặt mua
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Tổng tiền
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Trạng thái
                                </th>
                                <th class="text-secondary opacity-7"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stt = 1;
                            ?>
                            <?php if ($orders): ?>
                            <?php foreach ($orders as $i): ?>
                            <?php
                                    $datetime = new DateTime($i->getDate());
                                    ?>
                            <tr>
                                <td>
                                    <p class="text-xl text-secondary mb-0">
                                        <?= $stt++ ?>
                                    </p>
                                </td>
                                <td>
                                    <p class="text-xl text-secondary mb-0">
                                        <?= htmlspecialchars($i->getCustomer()['fullName'] ?? '') ?>
                                    </p>
                                </td>
                                <td>
                                    <p class="text-xl text-secondary mb-0">
                                        <?= htmlspecialchars($datetime->format('d-m-Y H:i:s')) ?>
                                    </p>
                                </td>
                                <td>
                                    <p class="text-xl text-secondary mb-0">
                                        <?= number_format($i->getTotalPrice(), 0, ',') . ' VND' ?>
                                    </p>
                                </td>
                                <td>
                                    <p class="text-xl text-secondary mb-0">
                                        <?= htmlspecialchars(OrderStatus::getStatusName($i->getStatus())) ?>
                                    </p>
                                </td>

                                <td class="align-middle text-center">
                                    <a href="_index.php?page=edit&id=<?= $i->getOrderID() ?>"
                                        class="btn bg-gradient-info" data-toggle="tooltip"
                                        data-original-title="Edit product" style="margin-bottom: 0 !important;">
                                        Edit
                                    </a>
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
            </div>
        </div>
    </div>
</div>