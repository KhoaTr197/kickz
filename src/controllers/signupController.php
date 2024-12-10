<?php
  require_once("promptController.php");
  require_once("../models/Database.php");
  require_once("formValidation.php");
  session_start();

  $db = new Database();

  if($_SERVER['REQUEST_METHOD'] != 'POST') 
    header("location: ../views/login.php");

  $username = $_POST['username'];
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];

  if(!usernameValidation($_POST['username'])){
    errorPrompt(
      'SIGNUP',
      'Tên đăng nhập không hợp lệ!',
      "../views/signup.php"  
    );
  }
  else if(empty($_POST['fullname'])) {
    errorPrompt(
      'SIGNUP',
      'Họ tên không hợp lệ!',
      "../views/signup.php"  
    );
  }
  else if(!emailValidation($_POST['email'])){
    errorPrompt(
      'SIGNUP',
      'Email không hợp lệ!',
      "../views/signup.php"  
    );
  }
  else if(!phoneNumberValidation($_POST['phone'])){
    errorPrompt(
      'SIGNUP',
      'Số điện thoại không hợp lệ!',
      "../views/signup.php"  
    );
  }
  else if(!passwordValidation($password)) {
    errorPrompt(
      'SIGNUP',
      'Mật khẩu không hợp lệ!',
      "../views/signup.php"  
    );
  }
  else if($password != $confirm_password) {
    errorPrompt(
      'SIGNUP',
      'Mật khẩu không trùng khớp!',
      "../views/signup.php"  
    );
  }
  else {
    global $db;

    $checkUserSQL = "
    select * from NGUOIDUNG where TENTK = '".$_POST['username']."'
    ";
    $userData = $db->fetch($db->query($checkUserSQL));
    if(!empty($userData)) {
      return errorPrompt(
        'SIGNUP',
        'Tên đăng nhập đã tồn tại!',
        "../views/signup.php"  
      );
    }

    $checkUserSQL = "
    select * from NGUOIDUNG where EMAIL = '".$_POST['email']."'
    ";
    $userData = $db->fetch($db->query($checkUserSQL));
    if(!empty($userData)) {
      return errorPrompt(
        'SIGNUP',
        'Email đã tồn tại!',
        "../views/signup.php"  
      );
    }

    $checkUserSQL = "
    select * from NGUOIDUNG where SDT = '".$_POST['phone']."'
    ";
    $userData = $db->fetch($db->query($checkUserSQL));
    if(!empty($userData)) {
      return errorPrompt(
        'SIGNUP',
        'Số điện thoại đã tồn tại!',
        "../views/signup.php"  
      );
    }

    $insertSQL = "
    insert into NGUOIDUNG (MATK, TENTK, HOTEN, EMAIL, SDT, MATKHAU, NGLAPTK, TRANGTHAI)
    values ('NULL', '".$_POST['username']."', '".$_POST['fullname']."', '".$_POST['email']."', 
    '".$_POST['phone']."', '".md5($password)."', '".date('Y-m-d')."', 1)
    ";

    if($db->query($insertSQL)){
      successPrompt(
        'LOGIN',
        'Đăng ký thành công!',
        "../views/login.php"
      );
    }
    else {
      errorPrompt(
        'SIGNUP',
        'Đăng ký không thành công!',
        "../views/signup.php"  
      );
    }
    
  }

?>