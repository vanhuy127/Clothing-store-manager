<?php
require_once __DIR__ . '/Unit.php';

class UnitDAO
{
    private $dbConnection;

    public function __construct($dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    public function add(Unit $unit)
    {
        $name = $unit->getName();
        $sql = "INSERT INTO units (name) VALUES (?)";
        $stmt = $this->dbConnection->prepare($sql);

        if ($stmt === false) {
            return false;
        }

        $stmt->bind_param('s', $name);
        return $stmt->execute();
    }

    // Hàm lấy một Unit theo ID
    public function show($id)
    {
        $sql = "SELECT * FROM units WHERE unitID = ?";
        $stmt = $this->dbConnection->prepare($sql);

        if ($stmt === false) {
            return null;
        }

        $stmt->bind_param('i', $id);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            return $this->mapRowToUnit($data); // Sử dụng hàm mapping
        }

        return null;
    }

    // Hàm lấy tất cả các Unit
    public function showAll()
    {
        $sql = "SELECT * FROM units";
        $stmt = $this->dbConnection->prepare($sql);

        if ($stmt === false) {
            return [];
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $units = [];
        while ($row = $result->fetch_assoc()) {
            $units[] = $this->mapRowToUnit($row); // Sử dụng hàm mapping
        }

        return $units;
    }

    // Hàm cập nhật thông tin một Unit
    public function edit(Unit $unit)
    {
        $unitID = $unit->getUnitID();
        $name = $unit->getName();

        $sql = "UPDATE units SET name = ? WHERE unitID = ?";
        $stmt = $this->dbConnection->prepare($sql);

        if ($stmt === false) {
            return false;
        }

        $stmt->bind_param('si', $name, $unitID);
        return $stmt->execute();
    }

    // Hàm xóa một Unit theo ID
    public function delete($id)
    {
        $sql = "DELETE FROM units WHERE unitID = ?";
        $stmt = $this->dbConnection->prepare($sql);

        if ($stmt === false) {
            return false;
        }

        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

    // Hàm mapping một row từ kết quả truy vấn thành đối tượng Unit
    private function mapRowToUnit($row)
    {
        return new Unit(
            $row['unitID'] ?? null, // Nếu không có giá trị, trả về null
            $row['name'] ?? null
        );
    }
}
