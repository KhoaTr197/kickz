<?php
require_once("promptController.php");
require_once("../models/Database.php");

session_start();

$db = new Database();

//Xu ly tac vu theo mode
switch ($_GET['mode']) {
  case 'product':
    enableProduct();
    break;
  case 'user':
    enableUser();
    break;
  default:
    errorPrompt(
      'ADMIN_HOMEPAGE',
      'Đã xảy ra lỗi, vui lòng thử lại sau!',
      "../admin/index.php?mode=admin-info"
    );
    break;
}

//Kich hoat San Pham
function enableProduct() {
  global $db;

  $enableProductSQL = "
      update SANPHAM
      set TRANGTHAI = 1
      where MASP = {$_GET['id']}
    ";
  
  if ($db->query($enableProductSQL))
    successPrompt(
      'ADMIN_HOMEPAGE',
      'Kích hoạt thành công!',
      "../admin/index.php?mode={$_GET['mode']}&page={$_GET['page']}"
    );
  else
    errorPrompt(
      'ADMIN_HOMEPAGE',
      'Đã xảy ra lỗi, vui lòng thử lại sau!',
      "../admin/index.php?mode={$_GET['mode']}&page={$_GET['page']}"
    );
}

//Kich hoat Nguoi Dung
function enableUser() {
  global $db;
  
  $enableUserSQL = "
    update NGUOIDUNG
    set TRANGTHAI = 1
    where MATK = {$_GET['id']}
  ";
  
  if ($db->query($enableUserSQL))
    successPrompt(
      'ADMIN_HOMEPAGE',
      'Kích hoạt thành công!',
      "../admin/index.php?mode={$_GET['mode']}&page={$_GET['page']}"
    );
  else
    errorPrompt(
      'ADMIN_HOMEPAGE',
      'Đã xảy ra lỗi, vui lòng thử lại sau!',
      "../admin/index.php?mode={$_GET['mode']}&page={$_GET['page']}"
    );
}