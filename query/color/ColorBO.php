<?php
require_once __DIR__ . '/ColorDAO.php';

class ColorBO
{
    private $colorDAO;

    public function __construct($conn)
    {
        $this->colorDAO = new ColorDAO($conn);
    }

    // Lấy tất cả các màu
    public function getAllColors()
    {
        return $this->colorDAO->showAll();
    }

    // Lấy một màu theo ID
    public function getColorByID($colorID)
    {
        return $this->colorDAO->show($colorID);
    }

    // Thêm một màu mới
    public function addColor(Color $color)
    {
        return $this->colorDAO->add($color);
    }

    // Cập nhật thông tin màu
    public function updateColor(Color $color)
    {
        return $this->colorDAO->edit($color);
    }

    // Xóa màu
    public function deleteColor($colorID)
    {
        return $this->colorDAO->delete($colorID);
    }
}
