<?php
  session_start();
  unset($_SESSION['USER']);
  unset($_SESSION['CART_ID']);
  header("location: ../views/homepage.php");
?>