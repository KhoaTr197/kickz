<?php
  require_once("../models/Database.php");
  session_start();

  if($_SERVER['REQUEST_METHOD'] != 'POST') 
    header("location: ../views/login.php");

  $userID = $_SESSION['LOGIN']['INFO']['id'];
  $new_username = $_POST['username'];
  $new_fullname = $_POST['fullname'];
  $new_email = $_POST['email'];
  $new_phone = $_POST['phone'];

  $db = new Database();
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
?>