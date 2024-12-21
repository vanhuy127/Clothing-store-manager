<?php

class Supplier
{
    private $supplierID;
    private $name;
    private $contactName;
    private $phone;
    private $email;
    private $address;

    public function __construct($supplierID = 0, $name = '', $contactName = '', $phone = '', $email = '', $address = '')
    {
        $this->supplierID = $supplierID;
        $this->name = $name;
        $this->contactName = $contactName;
        $this->phone = $phone;
        $this->email = $email;
        $this->address = $address;
    }

    public function getSupplierID()
    {
        return $this->supplierID;
    }

    public function setSupplierID($supplierID)
    {
        $this->supplierID = $supplierID;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getContactName()
    {
        return $this->contactName;
    }

    public function setContactName($contactName)
    {
        $this->contactName = $contactName;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }
}
