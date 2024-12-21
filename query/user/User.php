<?php
class User
{
    private $userID;
    private $username;
    private $password;
    private $email;
    private $fullName;
    private $phone;
    private $address;
    private $isLocked;
    private $roles = [];

    public function __construct($userID, $username, $password, $email, $fullName, $phone, $address, $isLocked)
    {
        $this->userID = $userID;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->fullName = $fullName;
        $this->phone = $phone;
        $this->address = $address;
        $this->isLocked = $isLocked;
    }

    // Getter và Setter cho từng thuộc tính
    public function getUserID()
    {
        return $this->userID;
    }

    public function setUserID($userID)
    {
        $this->userID = $userID;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getFullName()
    {
        return $this->fullName;
    }

    public function setFullName($fullName)
    {
        $this->fullName = $fullName;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function getIsLocked()
    {
        return $this->isLocked;
    }

    public function setIsLocked($isLocked)
    {
        $this->isLocked = $isLocked;
    }

    // Phương thức để quản lý roles
    public function getRoles()
    {
        return $this->roles;
    }

    public function addRole($roleName)
    {
        if (!in_array($roleName, $this->roles)) {
            $this->roles[] = $roleName;
        }
    }

    public function hasRole($roleName)
    {
        return in_array($roleName, $this->roles);
    }
}
