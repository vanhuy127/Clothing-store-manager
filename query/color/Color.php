<?php
class Color
{
    private $colorID;
    private $name;
    private $colorCode;  // Mã màu (ví dụ: mã HEX hoặc RGB)

    // Constructor
    public function __construct($colorID = 0, $name = "", $colorCode = "")
    {
        $this->colorID = $colorID;
        $this->name = $name;
        $this->colorCode = $colorCode;
    }

    // Getter và Setter cho colorID
    public function getColorID()
    {
        return $this->colorID;
    }

    public function setColorID($colorID)
    {
        $this->colorID = $colorID;
    }

    // Getter và Setter cho name
    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    // Getter và Setter cho colorCode
    public function getColorCode()
    {
        return $this->colorCode;
    }

    public function setColorCode($colorCode)
    {
        $this->colorCode = $colorCode;
    }
}
