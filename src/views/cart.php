<?php
require_once("../models/Database.php");
include_once("components/components.php");

$header_html = header_render("breadcrumb");
$footer_html = footer_render();

$db = new Database();
$sql = "
    select *
    from product
  ";
$result = $db->query($sql);
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

<body onunload="return myFunction()">
  <div id="app" class="grid">
    <?php echo $header_html ?>
    <main class='main'>
      <div class='wide'>
        <form action='../controllers/checkout.php' method='post' id="cart-list" class='row'>
          <div class="col c-8">
            <ul class="cart-list">
              <h2 class='cart-list__title'>Giỏ Hàng</h2>
              <?php
              while ($row = $db->fetch($result)) {
                echo productCard_render($row, 'cart');
              }
              ?>
            </ul>
          </div>
          <div class="col c-4">
            <div class="checkout flex">
              <div class="checkout__price-list flex">
                <div class="price-list__item">
                  <div class="price-list-item__name">Tổng Tiền Sản Phẩm</div>
                  <div class="price-list-item__price">16.000.000đ</div>
                </div>
                <div class="price-list__item">
                  <div class="price-list-item__name">Phí Vận Chuyển</div>
                  <div class="price-list-item__price">100.000đ</div>
                </div>
              </div>
              <div class="checkout__total-price flex font-semibold">
                <div class="checkout-total-price__name">Tổng Tiền</div>
                <div class="checkout-total-price__price">16.100.000đ</div>
              </div>
              <button id='checkout-btn' type="submit" class="checkout__checkout-btn btn btn-primary font-semibold">Xác Nhận Đơn Hàng</button>
            </div>
          </div>
        </form action='../controllers/checkout.php' method='post'>
      </div>
    </main>
    <?php echo $footer_html; ?>
  </div>
</body>

</html>