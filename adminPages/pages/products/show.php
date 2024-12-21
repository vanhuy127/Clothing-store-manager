<?php
require_once "../../../config/db.php";
require_once "../../../query/product/ProductBO.php";
$productBO = new ProductBO($conn);
$productDetails = $productBO->showAllProductWithImage();
?>
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h5>Hiển thị danh sách mặt hàng</h5>
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
                                    Ảnh
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Tên mặt hàng
                                </th>
                                <th class="text-secondary opacity-7"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($productDetails): ?>
                                <?php
                                $stt = 1; // Khởi tạo biến STT
                                foreach ($productDetails as $detail): ?>
                                    <?php
                                    $product = $detail['product'];
                                    $image = $detail['image'];
                                    ?>
                                    <tr>
                                        <td>
                                            <!-- Hiển thị số thứ tự -->
                                            <p class="text-secondary mb-0"><?= $stt++ ?></p>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <img src="../../../image-storage/<?= $image ? htmlspecialchars($image->getPath()) : 'no-product.png' ?>"
                                                    class="avatar avatar-xl me-3" alt="Product Image" />
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xl text-secondary mb-0">
                                                <?= htmlspecialchars($product->getName()) ?>
                                            </p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <a href="_index.php?page=edit&id=<?= $product->getProductID() ?>"
                                                class="btn bg-gradient-info" data-toggle="tooltip"
                                                data-original-title="Edit product" style="margin-bottom: 0 !important;">
                                                Edit
                                            </a>
                                            <a href="_index.php?page=delete&id=<?= $product->getProductID() ?>"
                                                class="btn bg-gradient-danger" data-toggle="tooltip"
                                                data-original-title="Delete product" style="margin-bottom: 0 !important;"
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa mặt hàng này?')">
                                                Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center">No products found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>