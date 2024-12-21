<?php
require_once __DIR__ . '/User.php';

class UserDAO
{
    private $dbConnection;

    public function __construct($dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }
    function getUser($email, $password)
    {
        $sql = "SELECT u.*, r.roleName
                FROM users as u 
                LEFT JOIN userroles as ul ON u.userID = ul.userID
                LEFT JOIN roles as r on ul.roleID = r.roleID
                WHERE u.email = ? 
                AND u.password = ?";
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = null;
            while ($row = $result->fetch_assoc()) {
                // Nếu chưa tạo đối tượng User, thì khởi tạo
                if ($user === null) {
                    $user = new User(
                        $row['userID'],
                        $row['username'],
                        $row['password'],
                        $row['email'],
                        $row['fullName'],
                        $row['phone'],
                        $row['address'],
                        $row['isLocked']
                    );
                }
                // Thêm vai trò vào danh sách roles
                $user->addRole($row['roleName']);
            }
            return $user;
        } else {
            return null;
        }
    }
}
