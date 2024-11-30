<?php
  session_start();
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