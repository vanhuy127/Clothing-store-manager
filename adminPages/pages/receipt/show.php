<?php
require_once "../../../config/db.php";
require_once "../../../query/receipt/ReceiptBO.php";
$receiptBO = new ReceiptBO($conn);
$receipts = $receiptBO->getAllReceipt();
?>
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h5>Hiển thị lịch sử nhập kho</h5>
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
                                    Tên mặt hàng
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Tên kích thước
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Tên màu sắc
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Số lượng
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Ngày nhập
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stt = 1
                            ?>
                            <?php if ($receipts): ?>
                            <?php foreach ($receipts as $r): ?>
                            <tr>
                                <td>
                                    <p class="text-xl text-secondary mb-0">
                                        <?= $stt++ ?>
                                    </p>
                                </td>
                                <td>
                                    <p class="text-xl text-secondary mb-0">
                                        <?= htmlspecialchars($r->getProductName()) ?>
                                    </p>
                                </td>
                                <td>
                                    <p class="text-xl text-secondary mb-0">
                                        <?= htmlspecialchars($r->getSizeName()) ?>
                                    </p>
                                </td>
                                <td>
                                    <p class="text-xl text-secondary mb-0">
                                        <?= htmlspecialchars($r->getColorName()) ?>
                                    </p>
                                </td>
                                <td>
                                    <p class="text-xl text-secondary mb-0">
                                        <?= htmlspecialchars($r->getQuantity()) ?>
                                    </p>
                                </td>
                                <td>
                                    <p class="text-xl text-secondary mb-0">
                                        <?= htmlspecialchars($r->getDate()) ?>
                                    </p>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">No receipt found.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>