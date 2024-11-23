<?php
  require_once("promptController.php");
  require_once("../models/Database.php");
  session_start();

  if($_SERVER['REQUEST_METHOD'] != 'POST') 
    header("location: ../views/login.php");

  $username = $_POST['username'];
  $password = md5($_POST['password']);

  $db = new Database();
  $sql = "
    select *
    from NGUOIDUNG
    where TENTK = '$username' and
          MATKHAU = '$password'
  ";
  $result = $db->fetch($db->query($sql));
    
  if($result != 0) {
    $_SESSION['USER']['HAS_LOGON'] = true;
    $_SESSION['USER']['INFO'] = $result;
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