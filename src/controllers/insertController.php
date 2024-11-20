<?php
require_once("../models/Database.php");
require_once("imageController.php");

session_start();

$supportedModes = [
  'product',
  'manufacturer',
  'size',
  'category',
  'image'
];

if (!isset($_POST['mode']) || !in_array($_POST['mode'], $supportedModes)) {
  $_SESSION['UPLOAD']['ERROR_PROMPT'] = "Đã xảy ra lỗi, vui lòng thử lại sau!";
  header("location: ../admin/insert_admin.php?mode={$_POST['mode']}");
}

$db = new Database();
$mode = ucfirst($_POST['mode']);
$errorFlag = false;

switch ($_POST['mode']) {
  case 'product':
  case 'category':
  case 'size':
    "insert$mode"();
    break;
  case 'manufacturer':
    insertManufacturer();
    insertImage('manufacturer');
    break;
  case 'image':
    "insert$mode"('product');
    break;
  default:
    break;
}

if($errorFlag) {
  header("location: ../admin/import_admin.php?mode={$_POST['mode']}");
} else {
  header("location: ../admin/index.php?mode={$_POST['mode']}");
}

function errorPrompt()
{
  $_SESSION['UPLOAD']['ERROR_PROMPT'] = "Đã xảy ra lỗi, vui lòng thử lại sau!";
  $errorFlag=true;
}

function insertProduct()
{
  global $db;

  $newName = $db->escape_str($_POST['TENSP']);
  $newDescription = $db->escape_str($_POST['MOTA']);

  $productSQL = "insert ignore into SANPHAM (MASP,TENSP,GIA,KHUYENMAI,MOTA,SOSAO,NGSX,MAHSX,TRANGTHAI) values(NULL, N'{$newName}',{$_POST['price']},{$_POST['discount']}, N'{$newDescription}',{$_POST['rating']}, '{$_POST['date']}', {$_POST['manufacturer']}, 1)";

  $result = $db->query($productSQL);
  if (!$result) errorPrompt();

  $lastestProductId = $db->get_last_id();

  foreach($_POST['category'] as $categoryId) {
    $categorizeSQL = "insert ignore into PHANLOAI (MADM, MASP) values($categoryId, $lastestProductId)";

    $result = $db->query($categorizeSQL);
    if (!$result) errorPrompt();
  }
}

function insertManufacturer()
{
  global $db;

  $manufacturerSQL = "insert ignore into HANGSANXUAT (MAHSX, TENHSX, LOGO) values(NULL, '{$_POST['name']}', NULL)";

  $result = $db->query($manufacturerSQL);
  if (!$result) errorPrompt();
}

function insertSize()
{
  global $db;

  $sizeSQL = "insert ignore into KICHCO (MAKC, MASP, COGIAY, SOLUONG) values(NULL, {$_POST['id']}, {$_POST['size']}, {$_POST['quantity']})";

  $result = $db->query($sizeSQL);
  if (!$result) errorPrompt();
}

function insertCategory()
{
  global $db;

  $categorySQL = "insert ignore into DANHMUC (MADM, TENDM) values(NULL, '{$_POST['name']}')";

  $result = $db->query($categorySQL);
  if (!$result) errorPrompt();
}

function insertImage($mode)
{
  global $db;

  $filename = explode('-', substr($_FILES['image']['name'], 0, -4));
  $file = $_FILES['image']['tmp_name'];
  $image = file_get_contents($file);

  $idx = [
    'right' => 1,
    'front' => 2,
    'left' => 3,
    'back' => 4
  ];
  $id = (int)$filename[1];
  $imageSQL = "";
  $stmt = null;

  switch ($mode) {
    case 'product':
      $imageSQL = "
        insert ignore into HINHANH (MASP, MAHA, URL)
        values(?, ?, ?)
      ";
      $stmt = $db->prepare($imageSQL);
      mysqli_stmt_bind_param($stmt, 'iis', $id, $idx[$filename[2]], $image);
      $db->stmt_execute($stmt);
      break;
    case 'manufacturer':
      $checkSQL = "select * from HANGSANXUAT where MAHSX = $id} limit 1";

      $result = $db->query($checkSQL);
      if(!$result || $db->rows_count($result) === 0) errorPrompt();

      $imageSQL = "
        update HANGSANXUAT
        set LOGO = ?
        where MAHSX = ? 
      ";
      $stmt = $db->prepare($imageSQL);
      mysqli_stmt_bind_param($stmt, 'si', $image, $id);
      $result = $db->stmt_execute($stmt);
      if (!$result) errorPrompt();

      break;
  }
}
