<?php
  require_once("../models/Database.php");
  require_once("formValidation.php");
  session_start();

  if($_SERVER['REQUEST_METHOD'] != 'POST') 
    header("location: ../views/login.php");

  $username = $_POST['username'];
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];

  $_SESSION['SIGNUP'] = [];

  if(!passwordValidation($password)) {
    $_SESSION['SIGNUP'] = [
      'ERROR_PROMPT' => 'Mật Khẩu không hợp lệ'
    ];
    header("location: ../views/signup.php");
  }
  else if($password != $confirm_password) {
    $_SESSION['SIGNUP'] = [
      'ERROR_PROMPT' => 'Mật Khẩu không trùng khớp'
    ];
    header("location: ../views/signup.php");
  }
  else {
    header("location: ../views/login.php");
  }

?>