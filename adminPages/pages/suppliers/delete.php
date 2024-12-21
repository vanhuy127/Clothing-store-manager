<?php
require_once "../../../config/db.php";
require_once "../../../query/supplier/SupplierBO.php";
$supplierBO = new SupplierBO($conn);

$id = $_GET['id'];

$supplierBO->deleteSupplier($id);
header("Location: _index.php?page=show");
exit();
