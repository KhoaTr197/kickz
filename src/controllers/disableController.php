<?php
require_once("promptController.php");
require_once("../models/Database.php");

session_start();

$db = new Database();

switch ($_GET['mode']) {
  case 'product':
    updateProduct();
    break;
  case 'manufacturer':
    deleteManufacturer();
    break;
  case 'category':
    deleteCategory();
    break;
  case 'size':
    deleteSize();
    break;
  case 'image':
    deleteImage();
    break;
  default:
    errorPrompt(
      'ADMIN_HOMEPAGE',
      'Đã xảy ra lỗi, vui lòng thử lại sau!',
      "../admin/index.php?mode=admin-info"
    );
    break;
}

function updateProduct() {
  global $db;

  $updateProductSQL = "
    update SANPHAM
    set TRANGTHAI = 0
    where MASP = {$_GET['id']}
  ";

  if($db->query($updateProductSQL))
    errorPrompt(
      'ADMIN_HOMEPAGE',
      'Vô hiệu hóa thành công!',
      "../admin/index.php?mode={$_GET['mode']}&page={$_GET['page']}"
    );
  else
    errorPrompt(
      'ADMIN_HOMEPAGE',
      'Đã xảy ra lỗi, vui lòng thử lại sau!',
      "../admin/index.php?mode={$_GET['mode']}&page={$_GET['page']}"
    );
}

function deleteManufacturer() {
  global $db;

  $deleteManufacturerSQL = "
    delete from HANGSANXUAT
    where MAHSX = {$_GET['id']}
  ";

  if($db->query($deleteManufacturerSQL))
    errorPrompt(
      'ADMIN_HOMEPAGE',
      'Xóa thành công!',
      "../admin/index.php?mode={$_GET['mode']}&page={$_GET['page']}"
    );
  else
    errorPrompt(
      'ADMIN_HOMEPAGE',
      'Đã xảy ra lỗi, vui lòng thử lại sau!',
      "../admin/index.php?mode={$_GET['mode']}&page={$_GET['page']}"
    );
}

function deleteCategory() {
  global $db;

  $deleteCategorySQL = "
    delete from DANHMUC
    where MADM = {$_GET['id']}
  ";

  if($db->query($deleteCategorySQL))
    errorPrompt(
      'ADMIN_HOMEPAGE',
      'Xóa thành công!',
      "../admin/index.php?mode={$_GET['mode']}&page={$_GET['page']}"
    );
  else
    errorPrompt(
      'ADMIN_HOMEPAGE',
      'Đã xảy ra lỗi, vui lòng thử lại sau!',
      "../admin/index.php?mode={$_GET['mode']}&page={$_GET['page']}"
    );
}

function deleteSize() {
  global $db;

  $deleteSizeSQL = "
    delete from KICHCO
    where MASP = {$_GET['productId']} and MAKC = {$_GET['id']}
  ";

  if($db->query($deleteSizeSQL))
    errorPrompt(
      'ADMIN_HOMEPAGE',
      'Xóa thành công!',
      "../admin/index.php?mode={$_GET['mode']}&page={$_GET['page']}"
    );
  else
    errorPrompt(
      'ADMIN_HOMEPAGE',
      'Đã xảy ra lỗi, vui lòng thử lại sau!',
      "../admin/index.php?mode={$_GET['mode']}&page={$_GET['page']}"
    );
}

function deleteImage() {
  global $db;

  $deleteImageSQL = "
    delete from HINHANH
    where MAHA = {$_POST['id']} and MASP = {$_POST['productId']}
  ";

  if($db->query($deleteImageSQL))
    errorPrompt(
      'ADMIN_HOMEPAGE',
      'Xóa thành công!',
      "../admin/index.php?mode={$_GET['mode']}&page={$_GET['page']}"
    );
  else
    errorPrompt(
      'ADMIN_HOMEPAGE',
      'Đã xảy ra lỗi, vui lòng thử lại sau!',
      "../admin/index.php?mode={$_GET['mode']}&page={$_GET['page']}"
    );
}