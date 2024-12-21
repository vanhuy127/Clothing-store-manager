<?php
class Size
{
    private $sizeID;
    private $name;

    public function __construct($sizeID = 0, $name = '')
    {
        $this->sizeID = $sizeID;
        $this->name = $name;
    }

    public function getSizeID()
    {
        return $this->sizeID;
    }

    public function setSizeID($sizeID)
    {
        $this->sizeID = $sizeID;
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
