<?php
require_once("imageController.php");
require_once("promptController.php");
require_once("../models/Database.php");

session_start();

//Kiem tra request method
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
  errorPrompt(
    'UPLOAD',
    'Đã xảy ra lỗi, vui lòng thử lại sau!',
    "../admin/insert_admin.php?mode={$_POST['mode']}"
  );
}

$db = new Database();

//Xu ly tac vu theo mode
switch ($_POST['mode']) {
  case 'product':
    insertProduct();
    break;
  case 'manufacturer': {
    insertImage('insertManufacturer');
  }
    
    break;
  case 'category':
    insertCategory();
    break;
  case 'size':
    insertSize();
    break;
  case 'image':
    insertImage();
    break;
  default:
    return errorPrompt(
      'UPLOAD',
      'Đã xảy ra lỗi, vui lòng thử lại sau!',
      "../admin/insert_admin.php?mode={$_POST['mode']}"
    );
    break;
}

//Them San Pham
function insertProduct()
{
  global $db;

  if(!isset($_POST['category']) || !isset($_POST['manufacturer']))
    return errorPrompt(
      'UPLOAD',
      'Đã có lỗi xảy ra, xin vui lòng thử lại!',
      "../admin/insert_admin.php?mode={$_POST['mode']}"
    );
  
  if(empty($_POST['rating'])) $_POST['rating'] = 0;
  if(empty($_POST['price'])) $_POST['price'] = 0;
  if(empty($_POST['discount'])) $_POST['discount'] = 0;
  if(empty($_POST['date'])) $_POST['date'] = date('Y-m-d');

  $newName = $db->escape_str($_POST['name']);
  $newDescription = $db->escape_str($_POST['description']);
  $newManufacturer = isset($_POST['manufacturer']) ? $_POST['manufacturer'] : 'NULL';

  $productSQL = "insert ignore into SANPHAM (MASP,TENSP,GIA,KHUYENMAI,MOTA,SOSAO,NGSX,MAHSX,TRANGTHAI) values(NULL, '{$newName}',{$_POST['price']},{$_POST['discount']}, '{$newDescription}',{$_POST['rating']}, '{$_POST['date']}', {$newManufacturer}, 1)";

  

  if (!$db->query($productSQL))
    return errorPrompt(
      'UPLOAD',
      'Đã có lỗi xảy ra, xin vui lòng thử lại!',
      "../admin/insert_admin.php?mode={$_POST['mode']}"
    );

  $lastestProductId = $db->get_last_id();
  
  if(!empty($_POST['category'])) {
    foreach($_POST['category'] as $categoryId) {
      $categorizeSQL = "insert ignore into PHANLOAI (MADM, MASP) values($categoryId, $lastestProductId)";
  
      if (!$db->query($categorizeSQL))
        return errorPrompt(
          'UPLOAD',
          'Đã có lỗi xảy ra, xin vui lòng thử lại!',
          "../admin/insert_admin.php?mode={$_POST['mode']}"
        );
    }
  }

  successPrompt(
    'ADMIN_HOMEPAGE',
    'Thêm thành công!',
    "../admin/index.php?mode={$_POST['mode']}&page=1"  
  );
}

function insertManufacturer($id)
{
  global $db;

  $manufacturerSQL = "insert ignore into HANGSANXUAT (MAHSX, TENHSX, LOGO) values($id, '{$_POST['name']}', NULL)";

  if(!$db->query($manufacturerSQL))
    return errorPrompt(
      'UPLOAD',
      'Đã có lỗi xảy ra, xin vui lòng thử lại!',
      "../admin/insert_admin.php?mode={$_POST['mode']}"
    );
}

//Them Kich Co
function insertSize()
{
  global $db;
  $checkSizeSQL = "select * from KICHCO where MASP = '{$_POST['id']}' and COGIAY = {$_POST['size']}";
  $result = $db->query($checkSizeSQL);
  if($db->rows_count($result) > 0){
    return errorPrompt(
      'UPLOAD',
      'Đã tồn tại kích cỡ này!',
      "../admin/insert_admin.php?mode={$_POST['mode']}"
    );
  }
  $sizeSQL = "insert ignore into KICHCO (MAKC, MASP, COGIAY, SOLUONG) values(NULL, {$_POST['id']}, {$_POST['size']}, {$_POST['quantity']})";

  if($db->query($sizeSQL))
    return successPrompt(
      'ADMIN_HOMEPAGE',
      'Thêm thành công!',
      "../admin/index.php?mode={$_POST['mode']}&page=1"  
    );
  else
    errorPrompt(
      'UPLOAD',
      'Đã có lỗi xảy ra, xin vui lòng thử lại!',
      "../admin/insert_admin.php?mode={$_POST['mode']}"
    );
}

//Them Danh Muc
function insertCategory()
{
  global $db;

  $categorySQL = "insert ignore into DANHMUC (MADM, TENDM) values(NULL, '{$_POST['name']}')";

  if($db->query($categorySQL))
    return successPrompt(
      'ADMIN_HOMEPAGE',
      'Thêm thành công!',
      "../admin/index.php?mode={$_POST['mode']}&page=1"  
    );
  else
    errorPrompt(
      'UPLOAD',
      'Đã có lỗi xảy ra, xin vui lòng thử lại!',
      "../admin/insert_admin.php?mode={$_POST['mode']}"
    );
}

function insertImage($cb=NULL)
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

  switch ($_POST['mode']) {
    case 'image':
      $checkImageSQL = "
        select MASP, MAHA
        from HINHANH
        where MASP = {$id} and MAHA = {$idx[$filename[2]]}
      ";
      if($db->rows_count($db->query($checkImageSQL)) > 0)
        return errorPrompt(
          'UPLOAD',
          'Đã tồn tại hình ảnh này!',
          "../admin/insert_admin.php?mode={$_POST['mode']}"
        );
      $imageSQL = "
        insert ignore into HINHANH (MASP, MAHA, FILE)
        values(?, ?, ?)
      ";
      $stmt = $db->prepare($imageSQL);
      mysqli_stmt_bind_param($stmt, 'iis', $id, $idx[$filename[2]], $image);
      break;
    case 'manufacturer':
      $cb($id);
      $imageSQL = "
        update HANGSANXUAT
        set LOGO = ?
        where MAHSX = ? 
      ";
      $stmt = $db->prepare($imageSQL);
      mysqli_stmt_bind_param($stmt, 'si', $image, $id);
      break;
  }

  if($db->stmt_execute($stmt))
    return successPrompt(
      'ADMIN_HOMEPAGE',
      'Thêm thành công!',
      "../admin/index.php?mode={$_POST['mode']}&page=1"  
    );
  else
    errorPrompt(
      'UPLOAD',
      'Đã có lỗi xảy ra, xin vui lòng thử lại!',
      "../admin/insert_admin.php?mode={$_POST['mode']}"
    );
}

?>
