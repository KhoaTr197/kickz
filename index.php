<?php
  require_once("src/models/Database.php");
  session_start();

  $db = new Database();

  $categorySQL = "select * from DANHMUC";
  $categoryList = $db->query($categorySQL);
  $arr = [];

  while($row = $db->fetch($categoryList)) {
    array_push($arr, $row);
  }
  
  $_SESSION['CATEGORY_LIST'] = $arr;

  if($_GET['page'])
    echo $_GET['page'];
  else
    header("location: {$_SERVER['REQUEST_URI']}?page=1");

  header("location: src/views/homepage.php");
?>