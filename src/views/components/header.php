<?php
function header_render($mode, $hasLogon = false, $prev_link = "homepage.php")
{
  
  switch ($mode) {
    case 'navbar':
      $manufacturerList_html = categoryList_render('manufacturer');
      $categoryList_html = categoryList_render('category');
      $ratingList_html = categoryList_render('rating');

      $menuBtn = "
        <div class='menu-btn btn flex-center' id='menu'>
          <img class='menu-btn__icon' src='../../public/img/menu_icon.svg' alt='Menu Button'>
          <span class='menu-btn__txt'>Danh Mục</span>
        </div>
        <div class='menu-modal' id='menu-modal'>
          <div class='menu-modal-wrap wide'>
            $manufacturerList_html
            $categoryList_html
            $ratingList_html
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
function categoryList_render($mode) {
  $newQueryStr="";
  $html = "";

  switch ($mode) {
    case 'manufacturer':
      foreach($_GET as $key => $value) {
        if($key == 'manufacturer') continue;
        $newQueryStr .= "$key=$value&";
      }
      $html .= "
        <ul class='category-group'>
          <li class='category-header'>Danh Mục</li>
          <ul class='category-list flex'>
      ";
      foreach($_SESSION['MANUFACTURER_LIST'] as $manufacturer) {
        $html .= "
          <li class='category-item font-normal'>
            <a href='browse.php?{$newQueryStr}manufacturer={$manufacturer['MAHSX']}'>{$manufacturer['TENHSX']}</a>
          </li>
        ";
      }
      $html .= "</ul></ul>";
      break;
    case 'category':
      foreach($_GET as $key => $value) {
        if($key == 'category') continue;
        $newQueryStr .= "$key=$value&";
      }
      $html .= "
        <ul class='category-group'>
          <li class='category-header'>Hãng</li>
          <ul class='category-list flex'>
      ";
      foreach($_SESSION['CATEGORY_LIST'] as $category) {
        $html .= "
          <li class='category-item font-normal'>
            <a href='browse.php?{$newQueryStr}rating=1category={$category['MADM']}'>{$category['TENDM']}</a>
          </li>
        ";
      }
      $html .= "</ul></ul>";
      break;
    case 'discount':
      break;
    case 'rating':
      foreach($_GET as $key => $value) {
        if($key == 'rating') continue;
        $newQueryStr .= "$key=$value&";
      }
      $html .= "
        <ul class='category-group'>
          <li class='category-header'>Đánh Giá</li>
          <ul class='category-list flex'>
            <li class='category-item font-normal'>
              <a href='browse.php?{$newQueryStr}rating=1'>1 Sao</a>
            </li>
            <li class='category-item font-normal'>
              <a href='browse.php?{$newQueryStr}rating=2'>2 Sao</a>
            </li>
            <li class='category-item font-normal'>
              <a href='browse.php?{$newQueryStr}rating=3'>3 Sao</a>
            </li>
            <li class='category-item font-normal'>
              <a href='browse.php?{$newQueryStr}rating=4'>4 Sao</a>
            </li>
            <li class='category-item font-normal'>
              <a href='browse.php?{$newQueryStr}rating=5'>5 Sao</a>
            </li>
          </ul>
        </ul>";
      break;
  }

  return $html;
}
?>