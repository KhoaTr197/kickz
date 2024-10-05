<?php
  include 'menuBtn.php';
  include 'searchBar.php';
  include 'cartBtn.php';
  include 'userBtn.php';
  
  function header_render($mode) {

    $menuBtn = menuBtn_render();
    $searchBar = searchBar_render();
    $cartBtn = cartBtn_render();
    $userBtn = userBtn_render();

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