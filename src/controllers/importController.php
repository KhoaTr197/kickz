<?php
  require_once("csvController.php");
  require_once("imageController.php");
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
    header("location: ../admin/import_admin.php?mode={$_POST['mode']}");
  }
  switch($_POST['mode']) {
    case 'product':
    case 'manufacturer':
    case 'size':
    case 'category':
      if(!str_contains($_FILES['data']['name'], '.csv')) {
        $_SESSION['UPLOAD']['ERROR_PROMPT']="File không hợp lệ!";
        header("location: ../admin/import_admin.php?mode={$_POST['mode']}");
      }
      break;
    case 'image':
      if(!checkImages($_FILES['image']['tmp_name'])) {
        $_SESSION['UPLOAD']['ERROR_PROMPT']="File hình ảnh không hợp lệ!";
        header("location: ../admin/import_admin.php?mode={$_POST['mode']}");
      }
      break;
    default:
      header("location: ../admin/import_admin.php?mode={$_POST['mode']}");
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
      addImage($_FILES['image']);
      break;
    default:
      break;
  }

  //header("location: ../admin/index.php");

  function errorPrompt() {
    $_SESSION['UPLOAD']['ERROR_PROMPT']="Đã xảy ra lỗi, vui lòng thử lại sau!";
    header("location: ../admin/import_admin.php?mode={$_POST['mode']}");
  }

  function addProduct($row, $columns) {
    global $db;

    $newName = $db->escape_str($row[$columns['TENSP']]);
    $newDescription = $db->escape_str($row[$columns['MOTA']]);

    $productSQL = "insert ignore into SANPHAM (MASP,TENSP,GIA,KHUYENMAI,MOTA,SOSAO,NGLAPSP,MAHSX,TRANGTHAI) values({$row[$columns['MASP']]}, '$newName', {$row[$columns['GIA']]}, {$row[$columns['KHUYENMAI']]}, '$newDescription', {$row[$columns['SOSAO']]}, '{$row[$columns['NGLAPSP']]}', {$row[$columns['MAHSX']]}, {$row[$columns['TRANGTHAI']]})";

    $result = $db->query($productSQL);
    if(!$result) errorPrompt();
  }

  function addManufacturer($row, $columns) {
    global $db;

    $manufacturerSQL = "insert ignore into HANGSANXUAT (MAHSX, TENHSX, LOGO) values({$row[$columns['MAHSX']]}, '{$row[$columns['TENHSX']]}', NULL)";

    $result = $db->query($manufacturerSQL);
    if(!$result) errorPrompt();
  }

  function addSize($row, $columns) {
    global $db;

    $sizeSQL = "insert ignore into KICHCO (MASP,MAKC,COGIAY,SOLUONG) values({$row[$columns['MASP']]}, {$row[$columns['MAKC']]}, {$row[$columns['COGIAY']]}, {$row[$columns['SOLUONG']]})";

    $result = $db->query($sizeSQL);
    if(!$result) errorPrompt();
  }

  function addCategory($row, $columns) {
    global $db;
  }

  function addImage($arrayImg) {
    global $db;

    foreach($arrayImg['tmp_name'] as $i => $name) {
      $filename = explode('-', substr($arrayImg['name'][$i], 0, -4));
      $file = $arrayImg["tmp_name"][$i];
      $image = file_get_contents($file);

      $idx=[
        'right' => 1,
        'front' => 2,
        'left' => 3,
        'back' => 4
      ];
      $id = (int)$filename[1];
      $imageSQL = "";
      $stmt = null;

      switch($filename[0]) {
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
          $imageSQL = "
            update HANGSANXUAT
            set LOGO = ?
            where MAHSX = ? 
          ";
          echo $imageSQL;
          $stmt = $db->prepare($imageSQL);
          mysqli_stmt_bind_param($stmt, 'si', $image, $id);
          $db->stmt_execute($stmt);
          break;
      }      
    }
  }
?>