<?php
require_once "../../../config/db.php";
require_once "../../../query/unit/UnitBO.php";
$unitBO = new UnitBO($conn);

$id = $_GET['id'];

$unitBO->deleteUnit($id);
header("Location: _index.php?page=show");
exit();
