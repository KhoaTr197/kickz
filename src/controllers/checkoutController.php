<?php
require_once("../models/Database.php");
require_once("promptController.php");
session_start();

$db = new Database;

$searchCartSQL = "
  select *
  from CHITIETGIOHANG
  where MAGH = {$_SESSION['CART_ID']}
";
$clearCartSQL = "
  delete from CHITIETGIOHANG
  where MAGH = {$_SESSION['CART_ID']};
";

$insertReceiptDetailSQL = "";
$searchCartResult = $db->query($searchCartSQL);
$totalPrice = 0;

while ($data = $db->fetch($searchCartResult)) {
  $insertReceiptDetailSQL .= "
    insert into CHITIETHOADON (MASP,MAHD,MAKC,SOLUONG,GIA)
    values ({$data['MASP']},?,{$data['MAKC']},{$data['SOLUONG']},{$data['GIA']});
  ";
  $totalPrice += $data['GIA']*$data['SOLUONG'];
}

$currentDate = date('Y-m-d');
$createReceiptSQL = "
  insert into HOADON (MAHD,MATK,TONGTIEN,HOTENKH,EMAIL,SDT,DCHI,GHICHU,NGLAPHD,MATT)
  values (NULL, {$_SESSION['USER']['INFO']['MATK']},{$totalPrice},'{$_POST['name']}','{$_POST['email']}','{$_POST['phone']}','{$_POST['address']}','{$_POST['note']}','$currentDate',1)
";

if($db->query($createReceiptSQL)) {
  $newestReceiptId = $db->get_last_id();

  $insertReceiptDetailSQL = str_replace('?', $newestReceiptId, $insertReceiptDetailSQL);
  $insertReceiptDetailSQL .= $clearCartSQL;

  if($db->multi_query($insertReceiptDetailSQL)) {
    successPrompt(
      'HOMEPAGE',
      'Mua hàng thành công!',
      "../views/browse.php"
    );
  }
  else
    errorPrompt(
      'HOMEPAGE',
      'Đã có lỗi xảy ra, xin vui lòng thử lại!',
      "../views/cart.php"
    );
}
else
  errorPrompt(
    'HOMEPAGE',
    'Đã có lỗi xảy ra, xin vui lòng thử lại!',
    "../views/cart.php"
  );