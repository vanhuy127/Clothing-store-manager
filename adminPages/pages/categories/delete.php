<?php
require_once "../../../config/db.php";
require_once "../../../query/category/CategoryBO.php";
$categoryBO = new CategoryBO($conn);

$id = $_GET['id'];

$categoryBO->deleteCategory($id);
header("Location: _index.php?page=show");
exit();
