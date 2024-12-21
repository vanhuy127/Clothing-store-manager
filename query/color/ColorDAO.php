<?php
require_once __DIR__ . '/Color.php';

class ColorDAO
{
    private $dbConnection;

    public function __construct($dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    // Thêm một màu mới
    public function add(Color $color)
    {
        $name = $color->getName();
        $colorCode = $color->getColorCode();

        $sql = "INSERT INTO colors (name, colorCode) VALUES (?, ?)";
        $stmt = $this->dbConnection->prepare($sql);

        if ($stmt === false) {
            return false;
        }

        $stmt->bind_param('ss', $name, $colorCode);

        return $stmt->execute();
    }

    // Lấy thông tin màu theo ID
    public function show($id)
    {
        $sql = "SELECT * FROM colors WHERE colorID = ?";

        $stmt = $this->dbConnection->prepare($sql);

        if ($stmt === false) {
            return null;
        }

        $stmt->bind_param('i', $id);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $this->mapRowToColor($row);
        } else {
            return null;
        }
    }

    // Lấy danh sách tất cả các màu
    public function showAll()
    {
        $sql = "SELECT * FROM colors";

        $stmt = $this->dbConnection->prepare($sql);

        if ($stmt === false) {
            return [];
        }

        $stmt->execute();

        $result = $stmt->get_result();
        $colors = [];
        while ($row = $result->fetch_assoc()) {
            $colors[] = $this->mapRowToColor($row);
        }
        return $colors;
    }

    // Cập nhật thông tin màu
    public function edit(Color $color)
    {
        $colorID = $color->getColorID();
        $name = $color->getName();
        $colorCode = $color->getColorCode();

        $sql = "UPDATE colors SET name = ?, colorCode = ? WHERE colorID = ?";

        $stmt = $this->dbConnection->prepare($sql);

        if ($stmt === false) {
            return false;
        }

        $stmt->bind_param('ssi', $name, $colorCode, $colorID);

        return $stmt->execute();
    }

    // Xóa một màu
    public function delete($id)
    {
        $sql = "DELETE FROM colors WHERE colorID = ?";

        $stmt = $this->dbConnection->prepare($sql);

        if ($stmt === false) {
            return false;
        }

        $stmt->bind_param('i', $id);

        return $stmt->execute();
    }

    // Ánh xạ từ hàng dữ liệu sang đối tượng Color
    private function mapRowToColor($row)
    {
        $color = new Color();
        $color->setColorID($row['colorID']);
        $color->setName($row['name']);
        $color->setColorCode($row['colorCode']);
        return $color;
    }
}
