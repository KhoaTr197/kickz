<?php
require_once("csvController.php");
require_once("imageController.php");
require_once("promptController.php");
require_once("../models/Database.php");
session_start();

//Kiem tra request method
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
  errorPrompt(
    'UPLOAD',
    'Đã xảy ra lỗi, vui lòng thử lại sau!',
    "../admin/import_admin.php?mode={$_POST['mode']}"
  );
}

$db = new Database();

//Xu ly tac vu theo mode
switch ($_POST['mode']) {
  case 'product':
    if(empty($_FILES['data']['tmp_name'][0]) || empty($_FILES['data']['tmp_name'][1])){
      return errorPrompt(
        'UPLOAD',
        'Thiếu 1 trong 2 File!',
        "../admin/import_admin.php?mode={$_POST['mode']}"
      );
    }
    if(!isCSV($_FILES['data']['name'][0]) || !isCSV($_FILES['data']['name'][1])) {
      return errorPrompt(
        'UPLOAD',
        'File không đúng định dạng!',
        "../admin/import_admin.php?mode={$_POST['mode']}"
      );
    }

    $handler = handleCSV($_FILES['data']['tmp_name'][0]);
    readCSV($handler, "insertProduct");
    
    $handler = handleCSV($_FILES['data']['tmp_name'][1]);
    readCSV($handler, "insertCategorize");
    break;
  case 'manufacturer':
    if(empty($_FILES['data']['tmp_name']) || empty($_FILES['image']['tmp_name'][0])){
      return errorPrompt(
        'UPLOAD',
        'Thiếu File!',
        "../admin/import_admin.php?mode={$_POST['mode']}"
      );
    }
    if(!isCSV($_FILES['data']['name']) || !isJPG($_FILES['image']['tmp_name'])) {
      return errorPrompt(
        'UPLOAD',
        'File không đúng định dạng!',
        "../admin/import_admin.php?mode={$_POST['mode']}"
      );
    }
      $handler = handleCSV($_FILES['data']['tmp_name']);
      readCSV($handler, "insertManufacturer");

      insertImage($_FILES['image']);

    break;
  case 'category':
    if(empty($_FILES['data']['tmp_name'])){
      return errorPrompt(
        'UPLOAD',
        'Thiếu File!',
        "../admin/import_admin.php?mode={$_POST['mode']}"
      );
    }
    if(!isCSV($_FILES['data']['name'])) {
      return errorPrompt(
        'UPLOAD',
        'File không đúng định dạng!',
        "../admin/import_admin.php?mode={$_POST['mode']}"
      );
    }
    $handler = handleCSV($_FILES['data']['tmp_name']);
    readCSV($handler, "insertCategory");
    break;
  case 'size':
    if(empty($_FILES['data']['tmp_name'])){
      return errorPrompt(
        'UPLOAD',
        'Thiếu File!',
        "../admin/import_admin.php?mode={$_POST['mode']}"
      );
    }
    if(!isCSV($_FILES['data']['name'])) {
      return errorPrompt(
        'UPLOAD',
        'File không đúng định dạng!',
        "../admin/import_admin.php?mode={$_POST['mode']}"
      );
    }
    $handler = handleCSV($_FILES['data']['tmp_name']);
    readCSV($handler, "insertSize");
    break;
  case 'image':
    if(empty($_FILES['image']['tmp_name'][0])){
      return errorPrompt(
        'UPLOAD',
        'Thiếu File!',
        "../admin/import_admin.php?mode={$_POST['mode']}"
      );
    }
    if(!isJPG($_FILES['image']['tmp_name'])) {
      return errorPrompt(
        'UPLOAD',
        'File không đúng định dạng!',
        "../admin/import_admin.php?mode={$_POST['mode']}"
      );
    }
    insertImage($_FILES['image']);
    break;
  case 'receipt':
    if(empty($_FILES['data']['tmp_name'])){
      return errorPrompt(
        'UPLOAD',
        'Thiếu File!',
        "../admin/import_admin.php?mode={$_POST['mode']}"
      );
    }
    if(!isCSV($_FILES['data']['name'])) {
      return errorPrompt(
        'UPLOAD',
        'File không đúng định dạng!',
        "../admin/import_admin.php?mode={$_POST['mode']}"
      );
    }
    $handler = handleCSV($_FILES['data']['tmp_name']);
    readCSV($handler, "updateReceipt");
    break;
  default:
    errorPrompt(
      'UPLOAD',
      'Đã xảy ra lỗi, vui lòng thử lại sau!',
      "../admin/import_admin.php?mode={$_POST['mode']}"
    );
    break;
}

//Them San Pham
function insertProduct($data, $ref)
{
  global $db;

  $newName = $db->escape_str($data[$ref['TENSP']]);
  $newDescription = $db->escape_str($data[$ref['MOTA']]);

  $productSQL = "insert ignore into SANPHAM (MASP,TENSP,GIA,KHUYENMAI,MOTA,SOSAO,NGSX,MAHSX,TRANGTHAI) values({$data[$ref['MASP']]}, '$newName', {$data[$ref['GIA']]}, {$data[$ref['KHUYENMAI']]}, '$newDescription', {$data[$ref['SOSAO']]}, '{$data[$ref['NGSX']]}', {$data[$ref['MAHSX']]}, {$data[$ref['TRANGTHAI']]})";

  if($db->query($productSQL))
    successPrompt(
      'ADMIN_HOMEPAGE',
      'Thêm thành công!',
      "../admin/index.php?mode={$_POST['mode']}&page=1"  
    );
  else
    errorPrompt(
      'UPLOAD',
      'Đã có lỗi xảy ra, xin vui lòng thử lại!',
      "../admin/import_admin.php?mode={$_POST['mode']}"
    );
}

//Them Danh Muc
function insertCategorize($data, $ref) {
  global $db;

  $categorizeSQL = "insert ignore into PHANLOAI (MASP,MADM) values({$data[$ref['MASP']]}, {$data[$ref['MADM']]})";

  if($db->query($categorizeSQL))
    successPrompt(
      'ADMIN_HOMEPAGE',
      'Thêm thành công!',
      "../admin/index.php?mode={$_POST['mode']}&page=1"  
    );
  else
    errorPrompt(
      'UPLOAD',
      'Đã có lỗi xảy ra, xin vui lòng thử lại!',
      "../admin/import_admin.php?mode={$_POST['mode']}"
    );
}

//Them Hang
function insertManufacturer($data, $ref)
{
  global $db;

  $manufacturerSQL = "insert ignore into HANGSANXUAT (MAHSX, TENHSX, LOGO) values({$data[$ref['MAHSX']]}, '{$data[$ref['TENHSX']]}', NULL)";

  if(!$db->query($manufacturerSQL))
    errorPrompt(
      'UPLOAD',
      'Đã có lỗi xảy ra, xin vui lòng thử lại!',
      "../admin/import_admin.php?mode={$_POST['mode']}"
    );
}

//Them Kich Co
function insertSize($data, $ref)
{
  global $db;

  $sizeSQL = "insert ignore into KICHCO (MASP,MAKC,COGIAY,SOLUONG) values({$data[$ref['MASP']]}, {$data[$ref['MAKC']]}, {$data[$ref['COGIAY']]}, {$data[$ref['SOLUONG']]})";

  if($db->query($sizeSQL))
    successPrompt(
      'ADMIN_HOMEPAGE',
      'Thêm thành công!',
      "../admin/index.php?mode={$_POST['mode']}&page=1"  
    );
  else
    errorPrompt(
      'UPLOAD',
      'Đã có lỗi xảy ra, xin vui lòng thử lại!',
      "../admin/import_admin.php?mode={$_POST['mode']}"
    );
}

//Them Danh Muc
function insertCategory($data, $ref)
{
  global $db;

  $categorySQL = "insert ignore into DANHMUC (MADM,TENDM) values({$data[$ref['MADM']]}, '{$data[$ref['TENDM']]}')";

  if($db->query($categorySQL))
    successPrompt(
      'ADMIN_HOMEPAGE',
      'Thêm thành công!',
      "../admin/index.php?mode={$_POST['mode']}&page=1"  
    );
  else
    errorPrompt(
      'UPLOAD',
      'Đã có lỗi xảy ra, xin vui lòng thử lại!',
      "../admin/import_admin.php?mode={$_POST['mode']}"
    );
}

//Them Hinh Anh
function insertImage($arrayImg)
{
  global $db;

  foreach ($arrayImg['tmp_name'] as $i => $name) {
    $filename = explode('-', substr($arrayImg['name'][$i], 0, -4));
    $file = $arrayImg["tmp_name"][$i];
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
        $imageSQL = "
            insert ignore into HINHANH (MASP, MAHA, FILE)
            values(?, ?, ?)
          ";
        $stmt = $db->prepare($imageSQL);
        mysqli_stmt_bind_param($stmt, 'iis', $id, $idx[$filename[2]], $image);

        if($db->stmt_execute($stmt))
          successPrompt(
            'ADMIN_HOMEPAGE',
            'Thêm thành công!',
            "../admin/index.php?mode={$_POST['mode']}&page=1"  
          );
        else
          errorPrompt(
            'UPLOAD',
            'Đã có lỗi xảy ra, xin vui lòng thử lại!',
            "../admin/import_admin.php?mode={$_POST['mode']}"
          );

        break;
      case 'manufacturer':
        $imageSQL = "
            update HANGSANXUAT
            set LOGO = ?
            where MAHSX = ? 
          ";
        $stmt = $db->prepare($imageSQL);
        mysqli_stmt_bind_param($stmt, 'si', $image, $id);

        if($db->stmt_execute($stmt))
          successPrompt(
            'ADMIN_HOMEPAGE',
            'Thêm thành công!',
            "../admin/index.php?mode={$_POST['mode']}&page=1"  
          );
        else
          errorPrompt(
            'UPLOAD',
            'Đã có lỗi xảy ra, xin vui lòng thử lại!',
            "../admin/import_admin.php?mode={$_POST['mode']}"
          );

        break;
    }
  }
}

//Cap nhat HOADON
function updateReceipt($data, $ref) {
  global $db;

  $updateSQL = "
    update HOADON
    set MATT = 4
    where MAHD = {$data[$ref['MAHD']]}
  ";
  
  if($db->query($updateSQL))
    successPrompt(
      'ADMIN_HOMEPAGE',
      'Cập nhật thành công!',
      "../admin/index.php?mode={$_POST['mode']}&page=1"  
    );
  else
    errorPrompt(
      'UPLOAD',
      'Đã có lỗi xảy ra, xin vui lòng thử lại!',
      "../admin/import_admin.php?mode={$_POST['mode']}"
    );

}
?>