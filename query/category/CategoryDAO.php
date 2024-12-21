<?php
require_once __DIR__ . '/Category.php';

class CategoryDAO
{
    private $dbConnection;

    public function __construct($dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    public function showAll()
    {
        $sql = "SELECT * FROM categories";
        $stmt = $this->dbConnection->prepare($sql);

        if ($stmt === false) {
            return [];
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $categories = [];
        while ($row = $result->fetch_assoc()) {
            $categories[] = $this->mapRowToCategory($row);
        }

        return $categories;
    }

    public function show($id)
    {
        $sql = "SELECT * FROM categories WHERE categoryID = ?";
        $stmt = $this->dbConnection->prepare($sql);

        if ($stmt === false) {
            return null;
        }

        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $this->mapRowToCategory($row);
        } else {
            return null;
        }
    }

    public function add(Category $category)
    {
        $sql = "INSERT INTO categories (categoryName) VALUES (?)";
        $stmt = $this->dbConnection->prepare($sql);

        if ($stmt === false) {
            return false;
        }

        $categoryName = $category->getCategoryName();
        $stmt->bind_param('s', $categoryName);
        return $stmt->execute();
    }

    public function update(Category $category)
    {
        $sql = "UPDATE categories SET categoryName = ? WHERE categoryID = ?";
        $stmt = $this->dbConnection->prepare($sql);

        if ($stmt === false) {
            return false;
        }

        $categoryName = $category->getCategoryName();
        $categoryId = $category->getCategoryId();
        $stmt->bind_param('si', $categoryName, $categoryId);
        return $stmt->execute();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM categories WHERE categoryID = ?";
        $stmt = $this->dbConnection->prepare($sql);

        if ($stmt === false) {
            return false;
        }

        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

    private function mapRowToCategory($row)
    {
        return new Category($row['categoryID'], $row['categoryName']);
    }
}
