<?php
require_once("../models/Database.php");
include_once("components/components.php");
session_start();

$header_html = header_render("breadcrumb", false, 'browse.php');
$footer_html = footer_render();

$db = new Database();

$cart_html = cart_render();

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
    <?php echo notify('HOMEPAGE'); ?>
    <?php echo $header_html ?>
    <main class='main'>
      <div class='wide'>
        <form action='../controllers/checkoutController.php' method='post' id="cart-list" class='row'>
          <?php echo $cart_html; ?>
        </form>
      </div>
    </main>
    <?php echo $footer_html; ?>
  </div>
</body>

</html>

<?php
function cart_render()
{
  global $db;

  $isEmpty = false;
  $productCardList_html = "";
  $totalPrice = 0;
  $receiptPrice = 0;
  $infoInputs_html = getInfoInputs();

  if (isset($_SESSION['CART_ID'])) {
    $sql = "
      select CHITIETGIOHANG.*, SANPHAM.TENSP, KICHCO.MAKC, KICHCO.COGIAY, HINHANH.FILE
      from CHITIETGIOHANG
      inner join SANPHAM
      on CHITIETGIOHANG.MASP = SANPHAM.MASP
      inner join KICHCO
      on CHITIETGIOHANG.MAKC = KICHCO.MAKC and CHITIETGIOHANG.MASP = KICHCO.MASP
      inner join HINHANH
      on CHITIETGIOHANG.MASP = HINHANH.MASP
      where MAGH = {$_SESSION['CART_ID']} and MAHA = 1
    ";

    $result = $db->query($sql);

    if ($db->rows_count($result) > 0) {
      while ($row = $db->fetch($result)) {
        $totalPrice += ($row['GIA'] * $row['SOLUONG']);
        $productCardList_html .= productCard_render($row, 'cart');
      }
      $receiptPrice = formatPrice($totalPrice + 100000);
      $totalPrice = formatPrice($totalPrice);
    } else {
      return "
        <div class='col c-12 cart-reminder'>
          <h1>Giỏ hàng trống<h1>
          <h3>Hãy thêm sản phẩm vào giỏ hàng!</h3>
        </div>
      ";
    }
  } else {
    $isEmpty = true;
  }

  if ($isEmpty)
    return "
      <div class='col c-12 cart-reminder'>
        <h1>Giỏ hàng trống<h1>
        <h3>Hãy đăng nhập để thêm sản phẩm vào giỏ hàng!</h3>
      </div>
    ";
  else
    return "
      <div class='col c-8'>
        <ul class='cart-list'>
          <h2 class='cart-list__title'>Giỏ Hàng</h2>
          $productCardList_html
        </ul>
      </div>
      <div class='col c-4'>
        <div class='checkout flex'>
          <div class='checkout__price-list flex'>
            <div class='price-list__item'>
              <div class='price-list-item__name'>Tổng Tiền Sản Phẩm</div>
                <div class='price-list-item__price'>
                  $totalPrice
                </div>
              </div>
              <div class='price-list__item'>
                <div class='price-list-item__name'>Phí Vận Chuyển</div>
                <div class='price-list-item__price'>100.000đ</div>
              </div>
            </div>
            <div class='checkout__total-price flex font-semibold'>
              <div class='checkout-total-price__name'>Tổng Tiền</div>
              <div class='checkout-total-price__price'>
                $receiptPrice
              </div>
            </div>
            $infoInputs_html
          <button id='checkout-btn' type='submit' class='checkout__checkout-btn btn btn-primary font-semibold'>Xác Nhận Đơn Hàng</button>
        </div>
      </div>
    ";
}
function getInfoInputs()
{
  if (isset($_SESSION['USER']))
    return "
      <div class='checkout__info font-semibold'>
        <div class='checkout-info__title'>Thông Tin Người Mua & Nhận</div>
        <div class='form-control flex flex-center checkout-info__input-wrap'>
          <label>Họ Tên:</label>
          <input class='form-input checkout-info__input' name='name' value='{$_SESSION['USER']['INFO']['HOTEN']}' />
        </div>
        <div class='form-control flex flex-center checkout-info__input-wrap'>
          <label>SĐT:</label>
          <input class='form-input checkout-info__input' name='phone' value='{$_SESSION['USER']['INFO']['SDT']}' />
        </div>
        <div class='form-control flex flex-center checkout-info__input-wrap'>
          <label>Email:</label>
          <input class='form-input checkout-info__input' name='email' value='{$_SESSION['USER']['INFO']['EMAIL']}' />
        </div>
        <div class='form-control flex flex-center checkout-info__input-wrap'>
          <label>Địa Chỉ:</label>
          <textarea class='form-input checkout-info__input' name='address'>{$_SESSION['USER']['INFO']['DCHI']}</textarea>
        </div>
        <div class='form-control flex flex-center checkout-info__input-wrap'>
          <label>Ghi Chú:</label>
          <textarea class='form-input checkout-info__input' name='note' placeholder='Ghi Chú'></textarea>
        </div>
      </div>
    ";
  else
    return "";
}
?>