<?php
require_once "../../../config/db.php";
require_once "../../../query/unit/UnitBO.php";
$unitBO = new UnitBO($conn);
$units = $unitBO->getAllUnits();
?>
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h5>Hiển thị đơn vị</h5>
                <a type="button" class="btn bg-gradient-primary" style="margin-bottom: 0 !important;"
                    href="_index.php?page=add">
                    Thêm
                </a>
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
                                    Tên đơn vị
                                </th>
                                <th class="text-secondary opacity-7"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stt = 1;
                            ?>
                            <?php if ($units): ?>
                            <?php foreach ($units as $i): ?>
                            <tr>
                                <td>
                                    <p class="text-xl text-secondary mb-0">
                                        <?= $stt++ ?>
                                    </p>
                                </td>
                                <td>
                                    <p class="text-xl text-secondary mb-0">
                                        <?= htmlspecialchars($i->getName()) ?>
                                    </p>
                                </td>
                                <td class="align-middle text-center">
                                    <a href="_index.php?page=edit&id=<?= $i->getUnitID() ?>"
                                        class="btn bg-gradient-info" data-toggle="tooltip"
                                        data-original-title="Edit product" style="margin-bottom: 0 !important;">
                                        Edit
                                    </a>
                                    <a href="_index.php?page=delete&id=<?= $i->getUnitID() ?>"
                                        class="btn bg-gradient-danger" data-toggle="tooltip"
                                        data-original-title="Delete product" style="margin-bottom: 0 !important;"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa đơn vị này?')">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">No units found.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>