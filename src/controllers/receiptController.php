<?php
require_once("../models/Database.php");
require_once("promptController.php");
session_start();

$db = new Database();

//Xu ly tac vu theo trang thai
switch($_GET['currStatus']) {
  case 1:
    if($_GET['isCancel'] == 0)
      approveReceipt();
    else if ($_GET['isCancel'] == 1)
      cancelReceipt();
    break;
  case 2:
    prepareProduct();
    break;
  case 3:
    if ($_GET['nextStatus'] == 4)
      deliveryDone();
    else if($_GET['nextStatus'] == 5)
      sendBack();
    break;
  default:
    break;
}

function cancelReceipt(){
  global $db;

  $updateSQL = "
    update HOADON
    set MATT = 10
    where MAHD = {$_GET['id']} and MATT = 1
  ";
  if($db->query($updateSQL))
    successPrompt(
      'ADMIN_HOMEPAGE',
      'Huỷ thành công!',
      "../admin/index.php?mode={$_GET['mode']}&page={$_GET['page']}&status={$_GET['currStatus']}"
    );
  else
    errorPrompt(
      'ADMIN_HOMEPAGE',
      'Đã có lỗi xảy ra, xin vui lòng thử lại!',
      "../admin/index.php?mode={$_GET['mode']}&page={$_GET['page']}&status={$_GET['currStatus']}"
    );
}

function approveReceipt() {
  global $db;

  $updateSQL = "
    update HOADON
    set MATT = 2
    where MAHD = {$_GET['id']} and MATT = 1
  ";
  if($db->query($updateSQL))
    successPrompt(
      'ADMIN_HOMEPAGE',
      'Phê duyệt thành công!',
      "../admin/index.php?mode={$_GET['mode']}&page={$_GET['page']}&status={$_GET['currStatus']}"
    );
  else
    errorPrompt(
      'ADMIN_HOMEPAGE',
      'Đã có lỗi xảy ra, xin vui lòng thử lại!',
      "../admin/index.php?mode={$_GET['mode']}&page={$_GET['page']}&status={$_GET['currStatus']}"
    );
}

//Chuan bi San Pham, giao
function prepareProduct() {
  global $db;

  $updateSQL = "
    update KICHCO R1
    inner join CHITIETHOADON R2
    on R1.MASP = R2.MASP
    set R1.SOLUONG = R1.SOLUONG - R2.SOLUONG
    where R2.MAHD = {$_GET['id']} and R1.MAKC = R2.MAKC;

    update HOADON
    set MATT = 3
    where MAHD = {$_GET['id']} and MATT = 2;
  ";

  if($db->multi_query($updateSQL))
    successPrompt(
      'ADMIN_HOMEPAGE',
      'Chuẩn bị hàng thành công!',
      "../admin/index.php?mode={$_GET['mode']}&page={$_GET['page']}&status={$_GET['currStatus']}"
    );
  else
    errorPrompt(
      'ADMIN_HOMEPAGE',
      'Đã có lỗi xảy ra, xin vui lòng thử lại!',
      "../admin/index.php?mode={$_GET['mode']}&page={$_GET['page']}&status={$_GET['currStatus']}"
    );
}

//Tra hang
function sendBack() {
  global $db;

  $updateSQL = "
    update KICHCO R1
    inner join CHITIETHOADON R2
    on R1.MASP = R2.MASP
    set R1.SOLUONG = R1.SOLUONG + R2.SOLUONG
    where R2.MAHD = {$_GET['id']} and R1.MAKC = R2.MAKC;

    update HOADON
    set MATT = 5
    where MAHD = {$_GET['id']} and MATT = 3;
  ";

  if($db->multi_query($updateSQL))
    warningPrompt(
      'ADMIN_HOMEPAGE',
      'Trả hàng thành công!',
      "../admin/index.php?mode={$_GET['mode']}&page={$_GET['page']}&status={$_GET['currStatus']}"
    );
  else
    errorPrompt(
      'ADMIN_HOMEPAGE',
      'Đã có lỗi xảy ra, xin vui lòng thử lại!',
      "../admin/index.php?mode={$_GET['mode']}&page={$_GET['page']}&status={$_GET['currStatus']}"
    );
}

//Giao thanh cong
function deliveryDone() {
  global $db;

  $updateSQL = "
    update HOADON
    set MATT = 4
    where MAHD = {$_GET['id']} and MATT = 3;
  ";

  if($db->query($updateSQL))
    successPrompt(
      'ADMIN_HOMEPAGE',
      'Giao hàng thành công!',
      "../admin/index.php?mode={$_GET['mode']}&page={$_GET['page']}&status={$_GET['currStatus']}"
    );
  else
    errorPrompt(
      'ADMIN_HOMEPAGE',
      'Đã có lỗi xảy ra, xin vui lòng thử lại!',
      "../admin/index.php?mode={$_GET['mode']}&page={$_GET['page']}&status={$_GET['currStatus']}"
    );
}
?>