<?php
require_once("../models/Database.php");
require_once("promptController.php");
session_start();

$db = new Database();

if (isset($_SERVER['REQUEST_METHOD'])) {
  switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
      addToCart($_POST);
      break;
    case 'GET':
      cartHandle($_GET);
      break;
  }
}

function cartHandle()
{
  global $db;

  $sql = "";
  switch ($_GET['mode']) {
    case 'increase':
      $sql = "
        update CHITIETGIOHANG
        set SOLUONG = SOLUONG + 1
        where MAGH = {$_SESSION['CART_ID']} and MASP = {$_GET['id']} and MAKC = {$_GET['sizeId']}
      ";
      break;
    case 'decrease':
      $sql = "
        update CHITIETGIOHANG
        set SOLUONG = SOLUONG - 1
        where MAGH = {$_SESSION['CART_ID']} and MASP = {$_GET['id']} and MAKC = {$_GET['sizeId']} and SOLUONG > 0;

        delete from CHITIETGIOHANG
        where SOLUONG = 0;
      ";
      break;
    case 'delete':
      $sql = "
        delete from CHITIETGIOHANG
        where MAGH = {$_SESSION['CART_ID']} and MASP = {$_GET['id']} and MAKC = {$_GET['sizeId']}
      ";
      break;
  }
  if ($db->multi_query($sql))
    header('location: ../views/cart.php');
}

function addToCart($data)
{
  if(!isset($_SESSION['CART_ID']))
    errorPrompt(
      'HOMEPAGE',
      'Hãy đăng nhập để thêm vào giỏ hàng!',
      "../views/detail.php?id={$data['id']}"
    );

  global $db;

  if (empty($data['size']))
    errorPrompt(
      'HOMEPAGE',
      'Vui lòng chọn kích cỡ!',
      "../views/detail.php?id={$data['id']}"
    );
  else {
    $checkCartSQL = "
      select * from CHITIETGIOHANG
      where MAGH = {$_SESSION['CART_ID']} and MASP = {$_POST['id']} and MAKC = {$_POST['size']}
    ";
    $checkResult = $db->query($checkCartSQL);
    
    if($db->rows_count($checkResult) > 0){
      warningPrompt(
        'HOMEPAGE',
        'Đã tồn tại sản phẩm trong giỏ hàng!', //
        "../views/detail.php?id={$data['id']}"
      );
    }
    else {
      $insertCartSQL = "
      insert into CHITIETGIOHANG (MAGH,MASP,MAKC,SOLUONG,GIA)
      values ({$_SESSION['CART_ID']}, {$_POST['id']}, {$_POST['size']}, 1, {$_POST['price']})
      ";
    }

    if ($db->query($insertCartSQL))
      successPrompt(
        'HOMEPAGE',
        'Thêm thành công!',
        "../views/detail.php?id={$data['id']}"
      );
   }
}
