<?php
  require_once("promptController.php");
  require_once("../models/Database.php");
  session_start();

  if($_SERVER['REQUEST_METHOD'] != 'POST') 
    header("location: ../views/login.php");

  $username = $_POST['username'];
  $password = md5($_POST['password']);

  $db = new Database();
  $checkUserSQL = "
    select *
    from NGUOIDUNG
    where TENTK = '$username' and
          MATKHAU = '$password'
  ";
  $userData = $db->fetch($db->query($checkUserSQL));

  $checkCartSQL = "
    select *
    from GIOHANG
    where MATK = {$userData['MATK']}
  ";
  $cartResult = $db->rows_count($db->query($checkCartSQL));
    
  if($userData != 0) {
    $_SESSION['USER']['HAS_LOGON'] = true;
    $_SESSION['USER']['INFO'] = $userData;

    if($cartResult == 0) {
      $createCartSQL = "
        insert into GIOHANG (MAGH, MATK)
        values (NULL, {$userData['MATK']})
      ";
      $db->query($createCartSQL);
      $_SESSION['CART_ID']=$db->get_last_id();
    }

    successPrompt(
      'HOMEPAGE',
      'Đăng Nhập Thành Công!',
      "../views/homepage.php"
    );
  } else {
    errorPrompt(
      'LOGIN',
      'Tên Tài Khoản Hoặc Mật Khẩu không chính xác!',
      "../views/login.php"
    );
  }
?>