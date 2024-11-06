<?php
  require_once("../models/Database.php");
  require_once("formValidation.php");
  session_start();

  if($_SERVER['REQUEST_METHOD'] != 'POST') 
    header("location: ../views/edit.php");
  
  $db = new Database();
  $_SESSION['EDIT']=[];

  switch($_POST['mode']) {
    case 'info':
      updateInfo($db);
      break;
    case 'password':
      updatePassword($db);
      break;
    case 'admin-info':
      updateAdminInfo($db);
      break;
    case 'admin-password':
      updateAdminPassword($db);
      break; 
  }

  function updateInfo($db) {
    $userID = $_SESSION['LOGIN']['INFO']['id'];
    $new_username = $_POST['username'];
    $new_fullname = $_POST['fullname'];
    $new_email = $_POST['email'];
    $new_phone = $_POST['phone'];

    $updateSql = "
      update user
      set username = '$new_username', fullname = '$new_fullname', email = '$new_email', phone = '$new_phone'
      where id = $userID
    ";
    $db->query($updateSql);
  
    $_SESSION['LOGIN']['INFO'] = $db->fetch($db->query("
      select *
      from user
      where id = $userID
    "));

    header("location: ../views/user.php");
  }

  function updatePassword($db) {
    $userID = $_SESSION['LOGIN']['INFO']['id'];
    $current_password = md5($_POST['current_password']);
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if(empty($current_password) || empty($new_password) || empty($confirm_password)) {
      $_SESSION['EDIT'] = [
        'PROMPT' => 'Vui lòng điền vào biểu mẫu này'
      ];
      header("location: ../views/edit.php?mode=password");
    } else {
      $selectPassSQl = "
        select *
        from user
        where password = '$current_password'
      ";
      $result = $db->fetch($db->query($selectPassSQl));

      if($result == 0) {
        $_SESSION['EDIT'] = [
          'PROMPT' => 'Mật Khẩu hiện tại không chính xác'
        ];
        header("location: ../views/edit.php?mode=password");
      }
      else if(!passwordValidation($new_password)) {
        $_SESSION['EDIT'] = [
          'PROMPT' => 'Mật Khẩu mới không hợp lệ'
        ];
        header("location: ../views/edit.php?mode=password");
      }
      else if($new_password != $confirm_password) {
        $_SESSION['EDIT'] = [
          'PROMPT' => 'Mật Khẩu mới không trùng khớp'
        ];
        header("location: ../views/edit.php?mode=password");
      }
      else {
        $new_password = md5($new_password);
        $updatePassSQl = "
          update user
          set password = '$new_password'
          where id = $userID
        ";
        $db->query($updatePassSQl);
        header("location: ../views/user.php");
      }
    }
  }

  function updateAdminInfo($db) {
    $new_username = $_POST['username'];

    $updateSql = "
      update admin
      set username = '$new_username'
    ";
    
    if(!$db->query($updateSql)) {
      $_SESSION['EDIT'] = [
        'PROMPT' => 'Đã xảy ra lỗi, vui lòng thử lại sau!'
      ];
      header("location: ../admin/edit_admin.php");
    }
    else {
      header("location: ../admin/index.php");
    }
  }

  function updateAdminPassword($db) {
    $current_password = md5($_POST['current_password']);
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if(empty($current_password) || empty($new_password) || empty($confirm_password)) {
      $_SESSION['EDIT'] = [
        'PROMPT' => 'Vui lòng điền vào biểu mẫu này'
      ];
      header("location: ../admin/edit_admin.php?mode=password");
    } else {
      $selectPassSQl = "
        select *
        from admin
      ";
      $result = $db->query($selectPassSQl);

      if(!$result) {
        $_SESSION['EDIT'] = [
          'PROMPT' => 'Đã xảy ra lỗi, vui lòng thử lại sau!'
        ];
        header("location: ../admin/edit_admin.php?mode=password");
      }

      $result = $db->fetch($result);

      if($result == 0) {
        $_SESSION['EDIT'] = [
          'PROMPT' => 'Mật Khẩu hiện tại không chính xác'
        ];
        header("location: ../admin/edit_admin.php?mode=password");
      }
      else if(!passwordValidation($new_password)) {
        $_SESSION['EDIT'] = [
          'PROMPT' => 'Mật Khẩu mới không hợp lệ'
        ];
        header("location: ../admin/edit_admin.php?mode=password");
      }
      else if($new_password != $confirm_password) {
        $_SESSION['EDIT'] = [
          'PROMPT' => 'Mật Khẩu mới không trùng khớp'
        ];
        header("location: ../admin/edit_admin.php?mode=password");
      }
      else {
        $new_password = md5($new_password);
        $updatePassSQl = "
          update admin
          set password = '$new_password'
        ";
        $db->query($updatePassSQl);
        header("location: ../admin/index.php");
      }
    }
  }

?>