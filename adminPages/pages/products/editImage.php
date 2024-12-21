<?php
require_once "../../../config/db.php";
require_once "../../../query/image/ImageBO.php";
require_once "../../../query/image/Image.php";

$imageBO = new ImageBO($conn);

$id = $_GET['id']; // ID của ảnh
$productID = $_GET['productID']; // ID của sản phẩm

// Lấy thông tin ảnh hiện tại
$image = $imageBO->showImageByID($id);

if (!$image) {
    die("Ảnh không tồn tại.");
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $displayOrder = $_POST['displayOrder'];
    $targetDir = "../../../image-storage/";

    // Kiểm tra nếu có tệp mới được tải lên
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Lấy thông tin tệp mới
        $fileName = $_FILES["image"]["name"];
        $fileTmpPath = $_FILES["image"]["tmp_name"];
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

        // Tạo tên tệp mới với timestamp
        $newFileName = time() . '.' . $fileExtension;
        $targetFilePath = $targetDir . $newFileName;

        // Xóa tệp ảnh cũ nếu tồn tại
        if (file_exists($targetDir . $image->getPath())) {
            unlink($targetDir . $image->getPath());
        }

        // Xử lý upload tệp mới
        if (move_uploaded_file($fileTmpPath, $targetFilePath)) {
            $image->setPath($newFileName);
        } else {
            echo "Lỗi tải ảnh mới.";
            exit();
        }
    }

    // Cập nhật thứ tự hiển thị
    $image->setOrderNumber($displayOrder);

    // Cập nhật thông tin ảnh trong cơ sở dữ liệu
    if ($imageBO->editImage($image)) {
        header("Location: _index.php?page=edit&id=$productID");
        exit();
    } else {
        echo "Lỗi cập nhật thông tin ảnh.";
    }
}
?>
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h5>Sửa thông tin ảnh</h5>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <form class="px-3" action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="currentImage">Ảnh hiện tại</label>
                        <div class="">
                            <img id="currentImage" src="../../../image-storage/<?= $image->getPath() ?>"
                                alt="Ảnh hiện tại" style="max-width: 200px; max-height: 200px;"
                                class="border-radius-lg" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="image">Tải lên ảnh mới (nếu có)</label>
                        <input class="form-control" type="file" id="image" name="image" accept="image/*"
                            onchange="previewImage(event)">
                        <div class="mt-3">
                            <img id="preview" src="#" alt="Xem trước ảnh"
                                style="max-width: 200px; max-height: 200px; display: none;" class="border-radius-lg" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="displayOrder">Thứ tự hiển thị</label>
                        <input class="form-control" type="number" value="<?= $image->getOrderNumber() ?>" min="1"
                            id="displayOrder" name="displayOrder" required>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="submit" class="btn bg-gradient-primary">
                            Lưu thay đổi
                        </button>
                        <a href="_index.php?page=edit&id=<?php echo $productID ?>" class="btn bg-gradient-danger">
                            Hủy
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function previewImage(event) {
        const preview = document.getElementById('preview');
        const file = event.target.files[0];
        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        } else {
            preview.src = '#';
            preview.style.display = 'none';
        }
    }
</script>