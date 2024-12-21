<?php
require_once "../../../config/db.php";
require_once "../../../query/variant/VariantBO.php";
$variantBO = new VariantBO($conn);
$id = $_GET['id'];
$productID = $_GET['productID'];

$variantBO->deleteVariant($id);
header("Location: _index.php?page=edit&id=$productID");
exit();
