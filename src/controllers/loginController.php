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
          MATKHAU = '$password' and
          TRANGTHAI = 1
  ";
  $userData = $db->fetch($db->query($checkUserSQL));
  
  if($userData != 0 ) {
    $_SESSION['USER']['HAS_LOGON'] = true;
    $_SESSION['USER']['INFO'] = $userData;

    if(isset($_POST['isremember'])) {
      $token = bin2hex(random_bytes(16));
      $hashed_token = password_hash($token, PASSWORD_DEFAULT);
      $updateUserSQL = "
        update NGUOIDUNG
        set MAXACTHUC = '".$hashed_token."'
        where tentk = '".$username."'
      ";
      $db->query($updateUserSQL);
      setcookie("REMEMBER", $token, time() + (24 * 60 * 60 * 3), "/kickz");
    }

    $checkCartSQL = "
      select *
      from GIOHANG
      where MATK = {$userData['MATK']}
    ";
    $cartResult = $db->rows_count($db->query($checkCartSQL));

    if($cartResult == 0) {
      $createCartSQL = "
        insert into GIOHANG (MAGH, MATK)
        values (NULL, {$userData['MATK']})
      ";
      $db->query($createCartSQL);
      $_SESSION['CART_ID']=$db->get_last_id();
    } else {
      $selectCartSQL = "
        select MAGH
        from GIOHANG
        where MATK = {$userData['MATK']}
      ";
      $_SESSION['CART_ID']=$db->fetch($db->query($selectCartSQL))['MAGH'];
    }

    successPrompt(
      'HOMEPAGE',
      'Đăng Nhập Thành Công!',
      "../views/browse.php"
    );
  } else {
    errorPrompt(
      'LOGIN',
      'Tên Tài Khoản Hoặc Mật Khẩu không chính xác!',
      "../views/login.php"
    );
  }
?>