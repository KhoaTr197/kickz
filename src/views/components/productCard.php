<?php
  include_once('../utils/utils.php');
  function productCard_render($data, $mode='browse') {
    switch($mode) {
      case 'browse':
        $id = $data['MASP'];
        $name = $data['TENSP'];
        $price = formatPrice($data['GIA']);
        $productImageData = base64_encode($data['FILE']);
        $manufacturerImageData = base64_encode($data['LOGO']);

        return "
          <div class='col l-3 c-6'>
            <a class='product-card rounded' id='product-$id'>
              <div class='product-card__img-wrap flex flex-center'>
                <img src='data:image/jpeg;base64,$productImageData'>
              </div>
              <div class='product-card__brand'>
                <img src='data:image/jpeg;base64,$manufacturerImageData'>
              </div>
              <div class='product-card__name-wrap'>
                <p class='product-card__name'>
                  $name
                </p>
              </div>
              <div class='product-card__price--old'>4.999.999đ</div>
              <div class='font-bold product-card__price--new'>$price</div>
            </a>
          </div>
        ";
      case 'cart':
        $id = $data['id'];
        $name = $data['name'];
        $price = formatPrice($data['price']);

        return "
        <div class='cart-list__item flex rounded' id='product-$id'>
          <img src='https://images.stockx.com/images/Air-Jordan-3-Retro-OG-SP-A-Ma-Maniere-Black-Violet-Ore-Womens-Product.jpg?fit=fill&bg=FFFFFF&w=120&h=100&auto=compress&dpr=1&trim=color&updated_at=1724151308&fm=webp&q=60'>
          <div class='cart-info flex'>
            <div class='cart-info__name font-medium'>
              $name
            </div>
            <div class='cart-info__quantity-btn flex-center rounded'>
              <button class='quantity-btn__minus flex-center' type='button'>
                <img src='../../public/img/minus_icon.svg'/>
              </button>
              <input class='quantity-btn__input font-medium' type='number' min='0' value='1' name='product-quantity-$id' />
              <button class='quantity-btn__add flex-center' type='button'>
                <img src='../../public/img/plus_icon.svg'/>                     
              </button>
            </div>
          </div>
          <div class='cart-info flex'>
            <a class='cart-info__delete-btn' href='#'>
              <img src='../../public/img/trashcan_icon.svg'>
            </a>
            <div class='cart-info__price font-medium'>$price</div>
          </div>
        </div>";
    }
  }

?>