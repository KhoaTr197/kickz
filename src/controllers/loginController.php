<?php
  include("../models/Database.php");
  session_start();

  if($_SERVER['REQUEST_METHOD'] != 'POST') 
    header("location: ../views/login.php");

  $db = new Database();
  $sql = "
    select username, password
    from user
    where role = 'admin'
  ";
  $result = $db->fetch($db->query($sql));

  $username = $_POST['username'];
  $password = $_POST['password'];
  
  if($username != $result['username'] || $password != $result['password']) {
    $_SESSION['LOGIN_ERROR_PROMPT']='Tên Tài Khoản Hoặc Mật Khẩu không chính xác';
    header("location: ../views/login.php");
  } else {
    $_SESSION['HAS_LOGON']=true;
    header("location: ../views/homepage.php");
  }
?>