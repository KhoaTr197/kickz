<?php
  require_once("src/models/Database.php");
  session_start();

  $db = new Database();

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