<?php
  require_once("../models/Database.php");
  session_start();

  if($_SERVER['REQUEST_METHOD'] != 'POST') 
    header("location: ../views/login.php");

  $username = $_POST['username'];
  $password = md5($_POST['password']);

  $db = new Database();
  $sql = "
    select *
    from user
    where username = '$username' and
          password = '$password'
  ";
  $result = $db->fetch($db->query($sql));
  
  $_SESSION['LOGIN'] = [];
  
  if($result == 0) {
    $_SESSION['LOGIN'] = [
      'ERROR_PROMPT' => 'Tên Tài Khoản Hoặc Mật Khẩu không chính xác'
    ];
    header("location: ../views/login.php");
  } else {
    $_SESSION['LOGIN'] += [
      'HAS_LOGON' => true,
      'INFO' => $result
    ];

    header("location: ../views/homepage.php");
  }
?>