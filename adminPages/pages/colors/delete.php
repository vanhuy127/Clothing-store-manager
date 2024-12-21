<?php
require_once "../../../config/db.php";
require_once "../../../query/color/ColorBO.php";
$colorBO = new ColorBO($conn);
$id = $_GET['id'];

$colorBO->deleteColor($id);
header("Location: _index.php?page=show");
exit();
