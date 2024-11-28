<?php
  session_start();
  unset($_SESSION['USER']);
  header("location: ../views/homepage.php");
?>