<?php
require_once __DIR__ . '/SizeDAO.php';

class SizeBO
{
    private $sizeDAO;

    public function __construct($dbConnection)
    {
        $this->sizeDAO = new SizeDAO($dbConnection);
    }

    public function addSize(Size $size)
    {
        return $this->sizeDAO->add($size);
    }

    public function getSize($id)
    {
        return $this->sizeDAO->show($id);
    }

    public function getAllSizes()
    {
        return $this->sizeDAO->showAll();
    }

    public function updateSize(Size $size)
    {
        return $this->sizeDAO->edit($size);
    }

    public function deleteSize($id)
    {
        return $this->sizeDAO->delete($id);
    }
}
