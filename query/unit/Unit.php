<?php
class Unit
{
    private $unitID;
    private $name;

    public function __construct($unitID = null, $name = null)
    {
        $this->unitID = $unitID;
        $this->name = $name;
    }

    public function getUnitID()
    {
        return $this->unitID;
    }

    public function setUnitID($unitID)
    {
        $this->unitID = $unitID;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
}
