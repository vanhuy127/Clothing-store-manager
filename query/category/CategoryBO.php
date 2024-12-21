<?php
require_once __DIR__ . '/CategoryDAO.php';

class CategoryBO
{
    private $categoryDAO;

    public function __construct($dbConnection)
    {
        $this->categoryDAO = new CategoryDAO($dbConnection);
    }

    public function showAllCategories()
    {
        return $this->categoryDAO->showAll();
    }

    public function showCategory($id)
    {
        return $this->categoryDAO->show($id);
    }

    public function addCategory(Category $category)
    {
        return $this->categoryDAO->add($category);
    }

    public function updateCategory(Category $category)
    {
        return $this->categoryDAO->update($category);
    }

    public function deleteCategory($id)
    {
        return $this->categoryDAO->delete($id);
    }
}
