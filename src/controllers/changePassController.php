<?php
  require_once("../models/Database.php");
  require_once("formValidation.php");
  session_start();

  if($_SERVER['REQUEST_METHOD'] != 'POST') 
    header("location: ../views/changePass.php");

  $userID = $_SESSION['LOGIN']['INFO']['id'];
  $current_password = md5($_POST['current_password']);
  $new_password = $_POST['new_password'];
  $confirm_password = $_POST['confirm_password'];

  $_SESSION['EDIT']=[];

  $db = new Database;
  $updatePassSQl = "
    select *
    from user
    where password = '$current_password'
  ";
  $result = $db->query($updatePassSQl);

  if($result == 0) {
    $_SESSION['EDIT'] = [
      'PROMPT' => 'Mật Khẩu hiện tại không chính xác'
    ];
    header("location: ../views/changePass.php");
  }
  else if($new_password != $confirm_password) {
    $_SESSION['EDIT'] = [
      'PROMPT' => 'Mật Khẩu mới không trùng khớp'
    ];
    header("location: ../views/changePass.php");
  } else if(!passwordValidation($new_password)) {
    $_SESSION['EDIT'] = [
      'PROMPT' => 'Mật Khẩu mới không hợp lệ'
    ];
    header("location: ../views/changePass.php");
  } else {
    $new_password = md5($new_password);
    $updatePassSQl = "
      update user
      set password = '$new_password'
      where id = $userID
    ";
    $db->query($updatePassSQl);
  
    header("location: ../views/user.php");
  }

?>