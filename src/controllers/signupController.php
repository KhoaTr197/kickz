<?php
  require_once("../models/Database.php");
  session_start();

  if($_SERVER['REQUEST_METHOD'] != 'POST') 
    header("location: ../views/login.php");

  $username = $_POST['username'];
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];

  function passwordValidation($pass) {
    $pattern = "/^(?=.*[A-Za-z])(?=.*\d).{8,}$/";
    return preg_match($pattern, $pass);
  }

  if(!passwordValidation($password)) {
    $_SESSION['SIGNUP_ERROR_PROMPT']='Mật Khẩu không hợp lệ';
    header("location: ../views/signup.php");
  }
  else if($password != $confirm_password) {
    $_SESSION['SIGNUP_ERROR_PROMPT']='Mật Khẩu không trùng khớp';
    header("location: ../views/signup.php");
  }
  else {
    header("location: ../views/homepage.php");
  }

?>