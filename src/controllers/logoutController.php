<?php
  include_once ("../models/Database.php");
  session_start();
  $db = new Database();
  if(isset($_COOKIE['REMEMBER'])){
    $updateUserSQL = "
      update NGUOIDUNG
      set MAXACTHUC = NULL
      where MATK = {$_SESSION['USER']['INFO']['MATK']}
    ";
    $db->query($updateUserSQL);
    setcookie("REMEMBER", "", time() - (24 * 60 * 60 * 3), "/kickz");
  }
  if($_GET['mode']=='user') {
    unset($_SESSION['USER']);
    unset($_SESSION['ADMIN_HOMEPAGE']);
    unset($_SESSION['CART_ID']);
  } else {
    unset($_SESSION['ADMIN']);
    unset($_SESSION['ADMIN_HOMEPAGE']);
  }
  header("location: ../views/homepage.php");
?>