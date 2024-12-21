<?php
require_once "../../../config/db.php";
require_once "../../../query/image/ImageBO.php";
require_once "../../../query/image/Image.php";

$imageBO = new ImageBO($conn);

$productID = $_GET['productID'];
$images = $imageBO->showImagesByProductID($productID);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $displayOrder = $_POST['displayOrder'];
    $targetDir = "../../../image-storage/";

    // Kiểm tra xem tệp có tồn tại và hợp lệ hay không
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Lấy thông tin tệp
        $fileName = $_FILES["image"]["name"];
        $fileTmpPath = $_FILES["image"]["tmp_name"];
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION); // Lấy phần mở rộng của tệp

        // Tạo tên tệp mới với timestamp
        $newFileName = time() . '.' . $fileExtension;
        $targetFilePath = $targetDir . $newFileName;

        // Xử lý upload file
        if (move_uploaded_file($fileTmpPath, $targetFilePath)) {
            // Tạo đối tượng Image với tên tệp mới
            $image = new Image(null, $newFileName, $displayOrder, $productID);
            if ($imageBO->addImage($image)) {
                // Chuyển hướng sau khi thành công
                header("Location: _index.php?page=edit&id=$productID");
                exit();
            }
        } else {
            echo "Lỗi tải ảnh lên.";
        }
    } else {
        echo "Vui lòng chọn một tệp hợp lệ.";
    }
}
?>
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h5>Thêm ảnh</h5>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <form class="px-3" action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="image">Hình ảnh</label>
                        <input class="form-control" type="file" id="image" name="image" accept="image/*"
                            onchange="previewImage(event)" required>
                        <div class="mt-3">
                            <img id="preview" src="#" alt="Xem trước ảnh"
                                style="max-width: 200px; max-height: 200px; display: none;" class="border-radius-lg" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="displayOrder">Thứ tự hiển thị</label>
                        <input class="form-control" type="number" value="1" min="1" id="displayOrder"
                            name="displayOrder" required>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="submit" class="btn bg-gradient-primary">
                            Thêm
                        </button>
                        <a href="_index.php?page=edit&id=<?php echo $productID ?>" type="submit"
                            class="btn bg-gradient-danger">
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