<?php
  include_once("components/components.php");

  $header_html = header_render("breadcrumb");
  $footer_html = footer_render();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../../public/css/base.css">
  <link rel="stylesheet" href="../../public/css/grid.css">
  <link rel="stylesheet" href="../../public/css/main.css">
  <script src="../../public/js/jquery-3.7.1.min.js"></script>
  <script src="../../public/js/app.js"></script>
  <title>Kickz</title>
</head>
<body>
  <div id="app" class="grid">
    <?php echo $header_html?>
      <main class='main'>
        <div class='wide'>
          <div class='row'>
            <div class="cart-list col c-8">
              <h2 class='cart-list__title'>Giỏ Hàng</h2>
              <div class='cart-list__item flex rounded'>
                <img src="https://images.stockx.com/images/Air-Jordan-3-Retro-OG-SP-A-Ma-Maniere-Black-Violet-Ore-Womens-Product.jpg?fit=fill&bg=FFFFFF&w=120&h=100&auto=compress&dpr=1&trim=color&updated_at=1724151308&fm=webp&q=60">
                <div class="cart-info-1 flex">
                  <div class="cart-info-1__name font-medium">
                    Jordan 3 Retro OG SP A Ma Maniére While You Were Sleeping (Women's)
                  </div>
                  <div class="cart-info-1__quantity-btn flex-center rounded">
                    <button class="quantity-btn__minus flex-center">
                      <img src='../../public/img/minus_icon.svg'/>
                    </button>
                    <input class="quantity-btn__input font-medium" type="number" min='0' value='1' />
                    <button class="quantity-btn__add flex-center">
                      <img src='../../public/img/plus_icon.svg'/>                     
                    </button>
                  </div>
                </div>
                  <div class="cart-info-2 flex">
                    <a class="cart-info-2__delete-btn" href='#'>
                      <img src="../../public/img/trashcan_icon.svg">
                    </a>
                    <div class="cart-info-2__price font-medium">3.699.999đ</div>
                </div>
              </div>            
            </div>
            <div class="col c-4">456</div>
          </div>
        </div>
      </main>
    <?php echo $footer_html; ?>
  </div>
</body>
</html>