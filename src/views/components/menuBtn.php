<?php
include 'categoryList.php';

function menuBtn_render() {
  $categoryList = categoryList_render();
  return "
    <div class='menu-btn' id='menu'>
    <img class='menu-btn__icon' src='public/img/menu_icon.svg' alt='Menu Button'>
    <span class='menu-btn__txt'>Danh Mục</span>
  </div>
  <div class='menu-modal' id='menu-modal'>
    <div class='menu-modal-wrap wide'>
    $categoryList
    $categoryList
    $categoryList
    $categoryList
    $categoryList
    $categoryList
    </div>
  </div>";
}
?>

