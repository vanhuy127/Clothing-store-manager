<?php
require_once __DIR__ . '/UnitDAO.php';

class UnitBO
{
    private $unitDAO;

    public function __construct($dbConnection)
    {
        $this->unitDAO = new UnitDAO($dbConnection);
    }

    public function addUnit(Unit $unit)
    {
        return $this->unitDAO->add($unit);
    }

    public function getUnit($id)
    {
        return $this->unitDAO->show($id);
    }

    public function getAllUnits()
    {
        return $this->unitDAO->showAll();
    }

    public function updateUnit(Unit $unit)
    {
        return $this->unitDAO->edit($unit);
    }

    public function deleteUnit($id)
    {
        return $this->unitDAO->delete($id);
    }
}
