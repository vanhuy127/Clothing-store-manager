<?php
require_once __DIR__ . '/UserDAO.php';

class UserBO
{
    private $userDAO;

    public function __construct($dbConnection)
    {
        $this->userDAO = new UserDAO($dbConnection);
    }

    public function getUser($email, $password)
    {
        return $this->userDAO->getUser($email, $password);
    }
}
