<?php
require_once("../models/Database.php");
require_once("promptController.php");
require_once("formValidation.php");
session_start();

//Kiem tra thong tin Nguoi Mua
if(empty($_POST['name'])){
  return errorPrompt(
    'HOMEPAGE',
    'Họ tên không hợp lệ!',
    "../views/cart.php"
  );
}
else if(!phoneNumberValidation($_POST['phone'])){
  return errorPrompt(
    'HOMEPAGE',
    'Số điện thoại không hợp lệ!',
    "../views/cart.php"
  );
}
else if(!emailValidation($_POST['email'])){
  return errorPrompt(
    'HOMEPAGE',
    'Email không hợp lệ!',
    "../views/cart.php"
  );
}
else if(empty($_POST['address'])){
  return errorPrompt(
    'HOMEPAGE',
    'Địa chỉ không hợp lệ!',
    "../views/cart.php"
  );
}

$db = new Database;

//Kiem tra GIOHANG
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

//kiem tra du so luong khong
while($data = $db->fetch($searchCartResult)){
  $checkQuantitySQL = "
  select SOLUONG
  from SANPHAM inner join KICHCO
  on SANPHAM.MASP = KICHCO.MASP
  where KICHCO.MASP = ? and KICHCO.MAKC = ?
  ";
  $stmt = $db->prepare($checkQuantitySQL);
  mysqli_stmt_bind_param($stmt, 'ii', $data['MASP'], $data['MAKC']);
  $db->stmt_execute($stmt);
  $productResult = $db->stmt_get_result($stmt);

  if($db->fetch($productResult)['SOLUONG'] < $data['SOLUONG'])
    return errorPrompt(
      'HOMEPAGE',
      'Sản phẩm không đủ số lượng để mua!',
      "../views/cart.php"
    );
}
$db->data_seek($searchCartResult, 0);
//Tao HOADON
while ($data = $db->fetch($searchCartResult)) {
  $insertReceiptDetailSQL .= "
    insert into CHITIETHOADON (MASP,MAHD,MAKC,SOLUONG,GIA)
    values ({$data['MASP']},?,{$data['MAKC']},{$data['SOLUONG']},{$data['GIA']});
  ";
  $totalPrice += $data['GIA']*$data['SOLUONG'] + 100000;
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