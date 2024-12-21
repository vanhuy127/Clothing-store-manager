<?php
require_once "../../../config/db.php";
require_once "../../../query/size/SizeBO.php";
$sizeBO = new SizeBO($conn);

$id = $_GET['id'];

$sizeBO->deleteSize($id);
header("Location: _index.php?page=show");
exit();
