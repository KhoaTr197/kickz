<?php
  include_once('../utils/utils.php');
  function productCard_render($data, $mode='browse') {
    switch($mode) {
      case 'browse':
        $id = $data['MASP'];
        $name = $data['TENSP'];
        $oldPrice = $data['KHUYENMAI'] != 0 ? formatPrice($data['GIA']) : '';
        $newPrice = formatPrice($data['GIA'] - $data['KHUYENMAI']);
        $productImageData = base64_encode($data['FILE']);
        $manufacturerImageData = base64_encode($data['LOGO']);

        return "
          <div class='col l-3 c-6'>
            <a class='product-card rounded' id='product-$id' href='detail.php?id=$id'>
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
              <div class='product-card__price--old'>$oldPrice</div>
              <div class='font-bold product-card__price--new'>$newPrice</div>
            </a>
          </div>
        ";
      case 'cart':
        $productId = $data['MASP'];
        $sizeId = $data['MAKC'];
        $name = $data['TENSP'];
        $size = $data['COGIAY'];
        $price = formatPrice($data['GIA']);
        $productImageData = base64_encode($data['FILE']);
        $quantity = $data['SOLUONG'];

        return "
        <div class='cart-list__item flex rounded' id='product-$productId'>
          <div class='cart-list-item__img-wrap flex flex-center'>
            <img class='cart-list-item__img' src='data:image/jpeg;base64,$productImageData'>
          </div>
          <div class='cart-info flex'>
            <div class='cart-info__name font-medium'>
              $name
            </div>
            <div class='cart-info__size font-medium'>
              (Size: $size)
            </div>
            <div class='cart-info__quantity-btn flex-center rounded'>
              <a class='quantity-btn__minus flex-center' href='../controllers/cartController.php?mode=decrease&id=$productId&sizeId=$sizeId'>
                <img src='../../public/img/minus_icon.svg'/>
              </a>
              <input class='quantity-btn__input font-medium' type='number' min='0' name='quantity' value='$quantity' readonly/>
              <a class='quantity-btn__add flex-center' href='../controllers/cartController.php?mode=increase&id=$productId&sizeId=$sizeId'>
                <img src='../../public/img/plus_icon.svg'/>                     
              </a>
            </div>
          </div>
          <div class='cart-info flex'>
            <a class='cart-info__delete-btn' href='../controllers/cartController.php?mode=delete&id=$productId&sizeId=$sizeId'>
              <img src='../../public/img/trashcan_icon.svg'>
            </a>
            <div class='cart-info__price font-medium'>$price</div>
          </div>
        </div>";
    }
  }

?>