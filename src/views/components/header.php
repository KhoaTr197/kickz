<?php
function header_render($mode) {

    $menuBtn = "
      <div class='menu-btn' id='menu'>
        <img class='menu-btn__icon' src='../../public/img/menu_icon.svg' alt='Menu Button'>
        <span class='menu-btn__txt'>Danh Mục</span>
      </div>
      <div class='menu-modal' id='menu-modal'>
        <div class='menu-modal-wrap wide'>
          <ul class='category-list'>
            <li class='category-header'>Nam</li>
            <li class='category-item'>Nike</li>
            <li class='category-item'>Adidas</li>
            <li class='category-item'>Puma</li>
            <li class='category-item'>Converse</li>
            <li class='category-item'>Ananas</li>
          </ul>
          <ul class='category-list'>
            <li class='category-header'>Nam</li>
            <li class='category-item'>Nike</li>
            <li class='category-item'>Adidas</li>
            <li class='category-item'>Puma</li>
            <li class='category-item'>Converse</li>
            <li class='category-item'>Ananas</li>
          </ul>
          <ul class='category-list'>
            <li class='category-header'>Nam</li>
            <li class='category-item'>Nike</li>
            <li class='category-item'>Adidas</li>
            <li class='category-item'>Puma</li>
            <li class='category-item'>Converse</li>
            <li class='category-item'>Ananas</li>
          </ul>
          <ul class='category-list'>
            <li class='category-header'>Nam</li>
            <li class='category-item'>Nike</li>
            <li class='category-item'>Adidas</li>
            <li class='category-item'>Puma</li>
            <li class='category-item'>Converse</li>
            <li class='category-item'>Ananas</li>
          </ul>
          <ul class='category-list'>
            <li class='category-header'>Nam</li>
            <li class='category-item'>Nike</li>
            <li class='category-item'>Adidas</li>
            <li class='category-item'>Puma</li>
            <li class='category-item'>Converse</li>
            <li class='category-item'>Ananas</li>
          </ul>
          <ul class='category-list'>
            <li class='category-header'>Nam</li>
            <li class='category-item'>Nike</li>
            <li class='category-item'>Adidas</li>
            <li class='category-item'>Puma</li>
            <li class='category-item'>Converse</li>
            <li class='category-item'>Ananas</li>
          </ul>
        </div>
      </div>
    ";
    $searchBar = "
      <div class='search-bar'>
        <label class='search-bar__label' for='search-bar-input'>
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
      <div class='userBtn'>
        <img src='../../public/img/user_icon.svg' alt='User Button'>
      </div>
    ";
    $loginBtn = "
      <a href='./login.php' class='loginBtn btn btn-primary flex-center'>
        Đăng Nhập 
      </a>
    ";

    switch($mode) {
      case 'navbar':
        return
          "<header class='header'>
            <div class='header-wrap wide'>
              <a href='#' class='logo flex-center'>
                <img class='logo__icon' src='../../public/img/logo_icon.svg' alt='Kickz Logo'>
              </a>
              $menuBtn
              $searchBar
              $cartBtn
              $loginBtn
            </div>
          </header>";
      case 'breadcrumb':
        return "
          <header class='header'>
            <div class='header-wrap wide'>
            <a class='returnBtn' href='homepage.php'>
              <img class='return__icon' src='../../public/img/arrow-left_icon.svg' alt='Back to previous page'>
            </a>
            </div>
          </header>
        ";
      case 'login':
        return "
        <header class='header'>
          <div class='header-wrap wide flex-center'>
          <a class='flex-center' href='homepage.php'>
            <img src='../../public/img/logo_icon.svg' alt='Back to Homepage'>
          </a>
          </div>
        </header>
      ";
    }
  }
?>