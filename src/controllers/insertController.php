<?php
require_once("../models/Database.php");
session_start();

$supportedModes = [
  'product',
  'manufacturer',
  'size',
  'category',
  'image'
];

if(!isset($_POST['mode']) || !in_array($_POST['mode'], $supportedModes)) {
  $_SESSION['UPLOAD']['ERROR_PROMPT']="Đã xảy ra lỗi, vui lòng thử lại sau!";
  header("location: ../admin/insert_admin.php?mode={$_POST['mode']}");
}

$db = new Database();
$mode = ucfirst($_POST['mode']);

switch($_POST['mode']) {
  case 'product':
    case 'manufacturer':
    case 'size':
    case 'category':
      "insert$mode"();
      break;
    case 'image':
      break;
    default:
      break;
}

function insertProduct() {
  echo "avc";
}

function insertManufacturer() {
  echo "avc";
}

function insertSize() {
  echo "avc";
}

function insertCategory() {
  echo "avc";
}

function insertImage() {
  echo "avc";
}

?>