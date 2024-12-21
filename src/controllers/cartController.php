<?php
require_once("../models/Database.php");
require_once("promptController.php");
session_start();

$db = new Database();

//Thuc thi tac vu dua tren phuong thuc request
if (isset($_SERVER['REQUEST_METHOD'])) {
  switch ($_SERVER['REQUEST_METHOD']) {
    //Them San Pham vao Gio Hang
    case 'POST':
      addToCart($_POST);
      break;
    //Dieu chinh so luong trong Gio Hang
    case 'GET':
      cartHandle($_GET);
      break;
  }
}

//Xu li thay doi so luong trong Gio Hang
function cartHandle()
{
  global $db;

  $sql = "";
  switch ($_GET['mode']) {
    //Tang so luong
    case 'increase':
      $sql = "
        update CHITIETGIOHANG
        set SOLUONG = SOLUONG + 1
        where MAGH = {$_SESSION['CART_ID']} and MASP = {$_GET['id']} and MAKC = {$_GET['sizeId']}
      ";
      break;
    //Giam so luong
    case 'decrease':
      $sql = "
        update CHITIETGIOHANG
        set SOLUONG = SOLUONG - 1
        where MAGH = {$_SESSION['CART_ID']} and MASP = {$_GET['id']} and MAKC = {$_GET['sizeId']} and SOLUONG > 0;

        delete from CHITIETGIOHANG
        where SOLUONG = 0;
      ";
      break;
    //Xoa San Pham khoi Gio Hang
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
//Xu ly them San Pham vao Gio Hang
function addToCart($data)
{
  if(!isset($_SESSION['CART_ID']))
    errorPrompt(
      'HOMEPAGE',
      'Hãy đăng nhập để thêm vào giỏ hàng!',
      "../views/detail.php?id={$data['id']}"
    );

  global $db;

  $checkInOperation = "
    select * from SANPHAM
    where MASP = {$_POST['id']} and TRANGTHAI = 1
  ";

  if(empty($db->fetch($db->query($checkInOperation)))){
    return errorPrompt(
      'HOMEPAGE',
      'Sản phẩm đã ngừng kinh doanh, vui lòng chọn sản phẩm khác!', 
      "../views/detail.php?id={$data['id']}"
    );
  }

  if (empty($data['size']))
    return errorPrompt(
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
      return warningPrompt(
        'HOMEPAGE',
        'Đã tồn tại sản phẩm trong giỏ hàng!', 
        "../views/detail.php?id={$data['id']}"
      );
    }

    $checkQuantityOfSize = "
      select * from KICHCO
      where MASP = {$_POST['id']} and MAKC = {$_POST['size']}
    ";

    if($db->fetch($db->query($checkQuantityOfSize))['SOLUONG']==0){
      return errorPrompt(
        'HOMEPAGE',
        'Đã hết hàng, vui lòng chọn kích cỡ khác!', 
        "../views/detail.php?id={$data['id']}"
      );
    }
      
    $insertCartSQL = "
    insert into CHITIETGIOHANG (MAGH,MASP,MAKC,SOLUONG,GIA)
    values ({$_SESSION['CART_ID']}, {$_POST['id']}, {$_POST['size']}, 1, {$_POST['price']})
    ";

    if ($db->query($insertCartSQL))
      successPrompt(
        'HOMEPAGE',
        'Thêm thành công!',
        "../views/detail.php?id={$data['id']}"
      );
   }
}
