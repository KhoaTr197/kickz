<?php
require_once("../models/Database.php");
include_once("components/components.php");
session_start();

$header_html = header_render("breadcrumb");
$footer_html = footer_render();

$db = new Database();
$sql = "
    select *
    from HOADON
    inner join TRANGTHAI
    on HOADON.MATT = TRANGTHAI.MATT
    where MATK = {$_SESSION['USER']['INFO']['MATK']}
    order by HOADON.MATT asc
  ";
$result = $db->query($sql);

$receiptList_html = receiptList_render($result);
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
    <?php echo $header_html; ?>
    <main class='main'>
      <div class='wide'>
        <div class='row' id="user-modal">
          <div class="col c-3">
            <ul class="sidebar rounded-lg flex">
              <li class="sidebar__item active" id="personal-info_sidebar">
                <img class='sidebar-item__icon' src="../../public/img/user_icon.svg">
                Thông Tin Cá Nhân
              </li>
              <li class="sidebar__item" id="receipt_sidebar">
                <img class='sidebar-item__icon' src="../../public/img/receipt_icon.svg">
                Đơn Hàng
              </li>
              <a href="../controllers/logoutController.php?mode=user" class='sidebar__item'>
                <img class='sidebar-item__icon' src="../../public/img/logout_icon.svg">
                Đăng Xuất
              </a>
            </ul>
          </div>
          <div class="col c-9">
            <div class="user-panel">
              <li class="user-panel__item active" id="personal-info_modal">
                <div class="personal-info-wrap">
                  <h2 class="personal-info__title flex">
                    Thông Tin Cá Nhân
                    <a href="edit.php?mode=info" class="personal-title__edit-btn rounded font-medium flex-center">Sửa</a>
                  </h2>
                  <ul class="personal-info__list">
                    <li class="personal-list__item">
                      <div class="personal-list-item__key">Tên Tài Khoản:</div>
                      <div class="personal-list-item__value"><?php echo $_SESSION['USER']['INFO']['TENTK']; ?></div>
                    </li>
                    <li class="personal-list__item">
                      <div class="personal-list-item__key">Họ Tên:</div>
                      <div class="personal-list-item__value"><?php echo $_SESSION['USER']['INFO']['HOTEN']; ?></div>
                    </li>
                    <li class="personal-list__item">
                      <div class="personal-list-item__key">Email:</div>
                      <div class="personal-list-item__value"><?php echo $_SESSION['USER']['INFO']['EMAIL']; ?></div>
                    </li>
                    <li class="personal-list__item">
                      <div class="personal-list-item__key">SĐT:</div>
                      <div class="personal-list-item__value"><?php echo $_SESSION['USER']['INFO']['SDT']; ?></div>
                    </li>
                    <li class="personal-list__item">
                      <div class="personal-list-item__key">Mật Khẩu:</div>
                      <a href="edit.php?mode=password" class="personal-list-item__change-pass-btn btn rounded-lg font-medium">Đổi Mật Khẩu</a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="user-panel__item " id="receipt_modal">
                <div class="receipt-wrap">
                  <h2 class="receipt__title">Đơn Hàng</h2>
                  <?php echo $receiptList_html; ?>
                </div>
              </li>
            </div>
          </div>
        </div>
      </div>
    </main>
    <?php echo $footer_html; ?>
  </div>
</body>

</html>

<?php
function receiptList_render($result)
{
  global $db;
  $status = [
    '1' => 'pending',
    '2' => 'pending',
    '3' => 'pending',
    '4' => 'success',
    '10' => 'error',
  ];
  $html = "<ul class='receipt__list'>";

  while ($row = $db->fetch($result)) {
    $receiptDetailData = $db->query("
      select CHITIETHOADON.*, SANPHAM.TENSP, KICHCO.MAKC, KICHCO.COGIAY, HINHANH.FILE
      from CHITIETHOADON
      inner join SANPHAM
      on CHITIETHOADON.MASP = SANPHAM.MASP
      inner join KICHCO
      on CHITIETHOADON.MAKC = KICHCO.MAKC and CHITIETHOADON.MASP = KICHCO.MASP
      inner join HINHANH
      on CHITIETHOADON.MASP = HINHANH.MASP
      where MAHD = {$row['MAHD']} and MAHA = 1
    ");

    $receiptDetailList_html = "<ul class='receipt-list-item__detail-list'>";

    while ($detailRow = $db->fetch($receiptDetailData)) {
      $productImageData = base64_encode($detailRow['FILE']);
      $price = formatPrice($detailRow['GIA']);

      $receiptDetailList_html .= "
        <li class='receipt-detail-list__item flex'>
          <div class='receipt-detail-list-item__img-wrap flex flex-center'>
            <img class='receipt-detail-list-item__img' src='data:image/jpeg;base64,$productImageData'>
          </div>
          <div class='receipt-detail-list-item__info flex'>
            <div class='receipt-detail-list-item__name font-medium'>
              {$detailRow['TENSP']}
            </div>
            <div class='receipt-detail-list-item__size font-normal'>
              Size: {$detailRow['COGIAY']}
            </div>
          </div>
          <div class='receipt-detail-list-item__info flex'>
            <div class='receipt-detail-list-item__price font-medium'>$price</div>
            <div class='receipt-detail-list-item__quantity font-normal'>SL: {$detailRow['SOLUONG']}</div>
          </div>

        </li>
      ";
    }

    $receiptDetailList_html .= "</ul>";

    $receiptPrice = formatPrice($row['TONGTIEN']);

    $receiptStatus = '';
    $btnDisable = '';

    if($row['MATT'] == 1){
      $btnDisable = "
        <a href='../controllers/disableController.php?mode=order&id={$row['MAHD']}' class='receipt-list-item__cancel-btn btn btn-error rounded font-medium flex-center'>Huỷ đơn hàng</a>
      ";
    }

    if($row['MATT'] == 10){
      $receiptStatus = 'receipt-list__item--disabled';
    } 

    $html .= "
      <li class='receipt-list__item $receiptStatus'>
        <div class='receipt-list-item__header flex'>
          <div class='receipt-list-item__title'>
            <h3 class='receipt-list-item-title__id'>Đơn Hàng #{$row['MAHD']}</h3>
            <h4 class='receipt-list-item-title__date font-normal'>Ngày mua hàng: {$row['NGLAPHD']}</h4>
          </div>
          <div class='receipt-list-item__status'>
            Trạng thái: 
            <span class='receipt-status--{$status[$row['MATT']]}'>{$row['TENTT']}<span>
          </div>
        </div>
        <div class='receipt-list-item__customer flex'>
          <div class='receipt-list-item__customer-info'>
            <p class='font-normal'>
              <span class='font-medium'>Họ Tên: </span>
              {$row['HOTENKH']}
            </p>
            <p class='font-normal'>
              <span class='font-medium'>Địa Chỉ:</span>
              {$row['DCHI']}
            </p>
            <p class='font-normal'>
              <span class='font-medium'>SĐT:</span>
              {$row['SDT']}
            </p>
            <p class='font-normal'>
              <span class='font-medium'>Email:</span>
              {$row['EMAIL']}
            </p>
          </div>
        </div>
        <div class='receipt-list-item__detail'>
          $receiptDetailList_html
        </div>
        <div class='receipt-list-item__price flex'>
          <span>Tổng Tiền</span>
          <span>$receiptPrice</span>
        </div>
        $btnDisable
      </li>
    ";
  }

  $html .= "</ul>";


  return $html;
}
?>