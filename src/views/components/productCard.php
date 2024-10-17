<?php
  function productCard_render() {
    return "
      <div class='col l-3 c-6'>
        <div class='product-card rounded'>
          <div class='product-card__img-wrap'>
            <img height='144px' width='224px' src='https://images.stockx.com/images/Air-Jordan-3-Retro-OG-SP-A-Ma-Maniere-Black-Violet-Ore-Womens-Product.jpg?fit=fill&bg=FFFFFF&w=224&h=160&auto=compress&dpr=2&trim=color&updated_at=1724151308&fm=webp&q=60' alt='Shoes Img'>
          </div>
          <div class='product-card__brand'>
            <img src='../../public/img/brand_test.png' alt='Shoes Img'>
          </div>
          <div class='product-card__name-wrap'>
            <p class='product-card__name'>
              Jordan 3 Retro OG SP A Ma Maniére While You Were Sleeping (Women's)
            </p>
          </div>
          <div class='product-card__price--old'>4.999.999đ</div>
          <div class='font-bold product-card__price--new'>3.699.999đ</div>
          <div class='product-card__wishlist-btn'>
            <img src='../../public/img/heart_icon.svg' alt='Add to Wishlist'>
          </div>
        </div>
      </div>
    ";
  }
?>