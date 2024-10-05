<?php
  include 'menuBtn.php';

function header_render($mode) {

    $menuBtn = menuBtn_render();
    $searchBar = "
      <div class='search-bar'>
        <label class='search-bar__label' for='search-bar-input'>
          <img class='search-bar__icon' src='public/img/search_icon.svg' alt='Search Bar'>
        </label>
        <input type='text' name='search' id='search-bar-input' placeholder='Tìm Kiếm'/>
      </div>
    ";
    $cartBtn = "
      <a class='cartBtn' id='cart' href='src/views/detail.php'>
        <img src='public/img/cart_icon.svg' alt='Cart Button'>
      </a>
    ";
    $userBtn = "
      <div class='userBtn'>
        <img src='public/img/user_icon.svg' alt='User Button'>
      </div>
    ";

    return
      "<header class='header'>
        <div class='header-wrap wide'>
          <div class='logo'>
            <img class='logo__icon' src='public/img/logo_icon.svg' alt='Kickz Logo'>
            <span class='logo__brand'>Kickz</span>
          </div>
          $menuBtn
          $searchBar
          $cartBtn
          $userBtn
        </div>
      </header>";
  }
?>