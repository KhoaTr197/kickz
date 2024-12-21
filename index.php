<?php
  require_once("src/models/Database.php");
  session_start();

  $db = new Database();

  //Kiem tra $_COOKIE va lay du lieu cho $_SESSION
  if(isset($_COOKIE['kickz_session_id'])) {
    $getUserSQL = "
      select *
      from NGUOIDUNG inner join SESSION
      on NGUOIDUNG.MATK = SESSION.MATK
      where MASS = '{$_COOKIE['kickz_session_id']}'
    ";

    $userData = $db->fetch($db->query($getUserSQL));

    $_SESSION['USER']['HAS_LOGON'] = true;
    $_SESSION['USER']['INFO'] = $userData;

    $checkCartSQL = "
      select *
      from GIOHANG
      where MATK = {$userData['MATK']}
    ";
    $cartResult = $db->rows_count($db->query($checkCartSQL));

    if($cartResult == 0) {
      $createCartSQL = "
        insert into GIOHANG (MAGH, MATK)
        values (NULL, {$userData['MATK']})
      ";
      $db->query($createCartSQL);
      $_SESSION['CART_ID']=$db->get_last_id();
    } else {
      $selectCartSQL = "
        select MAGH
        from GIOHANG
        where MATK = {$userData['MATK']}
      ";
      $_SESSION['CART_ID']=$db->fetch($db->query($selectCartSQL))['MAGH'];
    }
  }

  //Truy van 1 so du lieu cho Danh Muc cua Header
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

  //Gan URL cho nut chuyen huong trang truoc (Back to Previous)
  $_SESSION['URL_BACKUP'] = "src/views/homepage.php";

  //Chuyen huong toi trang chu
  header("location: src/views/homepage.php");
?>