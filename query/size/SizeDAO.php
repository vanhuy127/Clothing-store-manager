<?php
require_once __DIR__ . '/Size.php';

class SizeDAO
{
    private $dbConnection;

    public function __construct($dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    // Thêm kích thước mới
    public function add(Size $size)
    {
        $name = $size->getName();

        $sql = "INSERT INTO sizes (name) VALUES (?)";
        $stmt = $this->dbConnection->prepare($sql);

        if ($stmt === false) {
            return false;
        }

        $stmt->bind_param('s', $name);

        return $stmt->execute();
    }

    // Lấy thông tin kích thước theo ID
    public function show($id)
    {
        $sql = "SELECT * FROM sizes WHERE sizeID = ?";

        $stmt = $this->dbConnection->prepare($sql);

        if ($stmt === false) {
            return null;
        }

        $stmt->bind_param('i', $id);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $this->mapRowToSize($row);
        } else {
            return null;
        }
    }

    // Lấy danh sách tất cả kích thước
    public function showAll()
    {
        $sql = "SELECT * FROM sizes";

        $stmt = $this->dbConnection->prepare($sql);

        if ($stmt === false) {
            return [];
        }

        $stmt->execute();

        $result = $stmt->get_result();
        $sizes = [];
        while ($row = $result->fetch_assoc()) {
            $sizes[] = $this->mapRowToSize($row);
        }
        return $sizes;
    }

    // Cập nhật thông tin kích thước
    public function edit(Size $size)
    {
        $sizeID = $size->getSizeID();
        $name = $size->getName();

        $sql = "UPDATE sizes SET name = ? WHERE sizeID = ?";

        $stmt = $this->dbConnection->prepare($sql);

        if ($stmt === false) {
            return false;
        }

        $stmt->bind_param('si', $name, $sizeID);

        return $stmt->execute();
    }

    // Xóa kích thước
    public function delete($id)
    {
        $sql = "DELETE FROM sizes WHERE sizeID = ?";

        $stmt = $this->dbConnection->prepare($sql);

        if ($stmt === false) {
            return false;
        }

        $stmt->bind_param('i', $id);

        return $stmt->execute();
    }

    // Ánh xạ từ hàng dữ liệu sang đối tượng Size
    private function mapRowToSize($row)
    {
        $size = new Size();
        $size->setSizeID($row['sizeID']);
        $size->setName($row['name']);
        return $size;
    }
}
