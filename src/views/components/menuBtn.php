<?php
function menuBtn_render() {
  $categoryList = "
    <ul class='category-list'>
      <li class='category-header'>Nam</li>
      <li class='category-item'>Nike</li>
      <li class='category-item'>Adidas</li>
      <li class='category-item'>Puma</li>
      <li class='category-item'>Converse</li>
      <li class='category-item'>Ananas</li>
    </ul>
  ";

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

