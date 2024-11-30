<?php
require_once("promptController.php");
require_once("../models/Database.php");

session_start();

$db = new Database();

$updateProductSQL = "
    update SANPHAM
    set TRANGTHAI = 1
    where MASP = {$_GET['id']}
  ";

if ($db->query($updateProductSQL))
  errorPrompt(
    'ADMIN_HOMEPAGE',
    'Kích hoạt thành công!',
    "../admin/index.php?mode={$_GET['mode']}&page={$_GET['page']}"
  );
else
  errorPrompt(
    'ADMIN_HOMEPAGE',
    'Đã xảy ra lỗi, vui lòng thử lại sau!',
    "../admin/index.php?mode={$_GET['mode']}&page={$_GET['page']}"
  );
