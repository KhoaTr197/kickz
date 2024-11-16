<?php
require_once("../models/Database.php");
session_start();

$db = new Database();

if($_SERVER['REQUEST_METHOD'] !== 'POST' || $_FILES['image']['error'] > UPLOAD_ERR_OK)
  header("location: addPage_admin.php");

foreach($_FILES["image"]["tmp_name"] as $i => $name) {
  $check = exif_imagetype($_FILES["image"]["tmp_name"][$i]);

  if($check != IMAGETYPE_JPEG) {
    $_SESSION['UPLOAD'] = [
      'PROMPT' => 'File không đúng định dạng!'
    ];
  header("location: addPage_admin.php");
  }
}

$manufacturerId = $db->fetch($db->query("select id from manufacturer where name like '{$_POST['manufacturer']}'"));
$manufacturerId = $manufacturerId['id'];

$addProductSQL = productSQL($manufacturerId);

$db->query($addProductSQL);

$latestProductId = $db->get_last_id();

$addSizeSQL = sizeSQL($latestProductId);

$db->query($addSizeSQL);

foreach($_FILES["image"]["tmp_name"] as $i => $name) {
  $file = $_FILES["image"]["tmp_name"][$i];

  $image = file_get_contents($file);
  
  $sql = "
    insert into image (product_id, id, image)
    values(?, ?, ?)
  ";
  $stmt = $db->prepare($sql);
  $imageId = $i+1;
  mysqli_stmt_bind_param($stmt, 'iis', $latestProductId, $imageId, $image);
  $db->stmt_execute($stmt);
}

header("location: index.php");

function productSQL($manufacturer_id) {
  $result = "
    insert into product (id, name, price, discount, description, rating, manufactured_date, manufacturer_id)
    values (NULL, '{$_POST['name']}', {$_POST['price']}, {$_POST['discount']}, '{$_POST['description']}', 5, '29-01-2010', $manufacturer_id)
  ";
  return $result;
}

function sizeSQL($product_id) {
  $result = "insert into size (product_id, id, size, quantity) values ";
  foreach($_POST as $key => $value) {
    if(str_contains($key, "size")) {
      $size = explode("-", $key);
      print_r($size);
      $result .= "('$product_id', NULL, '{$size[1]}', '$value'), ";
    }
  }
  return rtrim($result, ', ');
}
?>