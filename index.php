<?php
  require_once("src/models/Database.php");
  session_start();

  $db = new Database();

  if(isset($_COOKIE['REMEMBER'])){
    $token = $_COOKIE['REMEMBER'];
    $getUsersHaveTokenSQL = "
      select * from NGUOIDUNG where MAXACTHUC IS NOT NULL
    ";
    $result = $db->query($getUsersHaveTokenSQL);
    while ($user = $db->fetch($result)){
      if(password_verify($token, $user['MAXACTHUC'])){
        $getUserDataSQL = "
          select * from NGUOIDUNG 
          where MATK = '".$user['MATK']."'
        ";
        $userData = $db->fetch($db->query($getUserDataSQL));
        $_SESSION['USER']['HAS_LOGON'] = true;
        $_SESSION['USER']['INFO'] = $userData;

        
        $selectCartSQL = "
          select MAGH
          from GIOHANG
          where MATK = {$userData['MATK']}
        ";
        $_SESSION['CART_ID']=$db->fetch($db->query($selectCartSQL))['MAGH'];
        
        break;
      }
    }
  }

  $categorySQL = "select * from DANHMUC";
  $manufacturerSQL = "select MAHSX, TENHSX from HANGSANXUAT";
  $categoryListArr = [];
  $manufacturerListArr = [];

  $categoryList = $db->query($categorySQL);

  while($row = $db->fetch($categoryList)) {
    array_push($categoryListArr, $row);
  }
  
  $_SESSION['CATEGORY_LIST'] = $categoryListArr;

  $manufacturerList = $db->query($manufacturerSQL);

  while($row = $db->fetch($manufacturerList)) {
    array_push($manufacturerListArr, $row);
  }
  
  $_SESSION['MANUFACTURER_LIST'] = $manufacturerListArr;

  $_SESSION['URL_BACKUP'] = "src/views/homepage.php";

  header("location: src/views/homepage.php");
?>