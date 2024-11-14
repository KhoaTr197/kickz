<?php
  require_once("../controllers/csvController.php");
  require_once("../controllers/imageController.php");
  require_once("../models/Database.php");
  session_start();

  $supportedModes = [
    'product',
    'manufacturer',
    'size',
    'category',
    'image'
  ];

  if(!isset($_POST['mode']) || !in_array($_POST['mode'], $supportedModes)) {
    $_SESSION['UPLOAD']['ERROR_PROMPT']="Đã xảy ra lỗi, vui lòng thử lại sau!";
    header("location: importPage_admin.php?mode={$_POST['mode']}");
  }
  switch($_POST['mode']) {
    case 'product':
    case 'manufacturer':
    case 'size':
    case 'category':
      if(!str_contains($_FILES['data']['name'], '.csv')) {
        $_SESSION['UPLOAD']['ERROR_PROMPT']="File không hợp lệ!";
        header("location: importPage_admin.php?mode={$_POST['mode']}");
      }
      break;
    case 'image':
      if(!checkImages($_FILES['image']['tmp_name'])) {
        $_SESSION['UPLOAD']['ERROR_PROMPT']="File hình ảnh không hợp lệ!";
        header("location: importPage_admin.php?mode={$_POST['mode']}");
      }
      break;
    default:
      header("location: importPage_admin.php?mode={$_POST['mode']}");
      break;
  }

  $db = new Database();
  $mode = ucfirst($_POST['mode']);

  switch($_POST['mode']) {
    case 'product':
    case 'manufacturer':
    case 'size':
    case 'category':
      $handler = handleCSV($_FILES['data']['tmp_name']);
      readCSV($handler, "add$mode");
      break;
    case 'image':
      insertImages($db, $_FILES['image']);
      break;
    default:
      break;
  }

  //header("location: index.php");

  function errorPrompt() {
    $_SESSION['UPLOAD']['ERROR_PROMPT']="Đã xảy ra lỗi, vui lòng thử lại sau!";
    header("location: importPage_admin.php?mode={$_POST['mode']}");
  }

  function addProduct($row, $columns) {
    global $db;

    $newName = $db->escape_str($row[$columns['TENSP']]);
    $newDescription = $db->escape_str($row[$columns['MOTA']]);

    $productSQL = "insert ignore into SANPHAM (MASP,TENSP,GIA,KHUYENMAI,MOTA,SOSAO,NGLAPSP,MAHSX,TRANGTHAI) values({$row[$columns['MASP']]}, '$newName', {$row[$columns['GIA']]}, {$row[$columns['KHUYENMAI']]}, '$newDescription', {$row[$columns['SOSAO']]}, '{$row[$columns['NGLAPSP']]}', {$row[$columns['MAHSX']]}, {$row[$columns['TRANGTHAI']]})";

    echo $result = $db->query($productSQL);
    if(!$result) errorPrompt();
  }

  function addManufacturer($row, $columns) {
    global $db;

    $manufacturerSQL = "insert ignore into HANGSANXUAT (MAHSX, TENHSX, LOGO) values({$row[$columns['MAHSX']]}, '{$row[$columns['TENHSX']]}', NULL)";

    echo $result = $db->query($manufacturerSQL);
    if(!$result) errorPrompt();
  }

  function addSize($row, $columns) {
    global $db;
  }

  function addCategory($row, $columns) {
    global $db;
  }
?>