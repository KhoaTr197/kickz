<?php
function header_render($mode, $hasLogon = false, $prev_link = "homepage.php")
{
  switch ($mode) {
    case 'navbar':
      $categoryList_html = "";
      $len = count($_SESSION['CATEGORY_LIST']);

      for($i=0; $i < $len; $i+=2) {
        $categoryList_html .= "<ul class='category-list'>";
        for($j=0; $j < 2; $j++) {
          $categoryList_html .= "
            <li class='category-item'>
              <a href='browse.php?category={$_SESSION['CATEGORY_LIST'][$i+$j]['MADM']}'>{$_SESSION['CATEGORY_LIST'][$i+$j]['TENDM']}</a>
            </li>
          ";
        }
        $categoryList_html .= "</ul>";
      }

      $menuBtn = "
        <div class='menu-btn btn flex-center' id='menu'>
          <img class='menu-btn__icon' src='../../public/img/menu_icon.svg' alt='Menu Button'>
          <span class='menu-btn__txt'>Danh Mục</span>
        </div>
        <div class='menu-modal' id='menu-modal'>
          <div class='menu-modal-wrap wide'>
            $categoryList_html
          </div>
        </div>
      ";
      $searchBar = "
        <div class='search-bar rounded'>
          <label class='search-bar__label flex-center' for='search-bar-input'>
            <img class='search-bar__icon' src='../../public/img/search_icon.svg' alt='Search Bar'>
          </label>
          <input type='text' name='search' id='search-bar-input' placeholder='Tìm Kiếm'/>
        </div>
      ";
      $cartBtn = "
        <a class='cartBtn' id='cart' href='cart.php'>
          <img src='../../public/img/cart_icon.svg' alt='Cart Button'>
        </a>  
      ";
      $userBtn = "
        <a class='userBtn' id='user' href='user.php'>
          <img src='../../public/img/user_icon.svg' alt='User Button'>
        </a>
      ";
      $loginBtn = "
        <a href='./login.php' class='loginBtn btn btn-primary flex-center'>
          Đăng Nhập 
        </a>
      ";
      return
        "<header class='header-container'>
            <div class='header-wrap wide flex-center'>
              <a href='homepage.php' class='logo flex-center'>
                <img class='logo__icon' src='../../public/img/logo_icon.svg' alt='Kickz Logo'>
              </a>
              $menuBtn
              $searchBar
              $cartBtn" .
        ($hasLogon ? $userBtn : $loginBtn)
        . "</div>
          </header>";
    case 'breadcrumb':
      return "
          <header class='header-container'>
            <div class='header-wrap wide'>
            <a class='returnBtn' href='$prev_link'>
              <img class='return__icon' src='../../public/img/arrow-left_icon.svg' alt='Back to previous page'>
            </a>
            </div>
          </header>
        ";
    case 'login':
      return "
        <header class='header-container'>
          <div class='header-wrap wide flex-center'>
          <a class='flex-center' href='http://localhost/kickz/src/views/homepage.php'>
            <img src='../../public/img/logo_icon.svg' alt='Back to Homepage'>
          </a>
          </div>
        </header>
      ";
  }
}
