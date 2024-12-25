<?php
require_once("../models/Database.php");
require_once("../utils/utils.php");
include_once("../views/components/components.php");
session_start();

if (!isset($_GET['id']))
  header("location: index.php?mode=receipt");

//Tao code HTML nhung thanh phan
$header_html = header_render("breadcrumb", false, "index.php?mode=receipt");
$footer_html = footer_render();

$db = new Database();
//Lay du lieu HOADON
$sql = "
    select *
    from HOADON
    inner join TRANGTHAI
    on HOADON.MATT = TRANGTHAI.MATT
    where MAHD = {$_GET['id']}
  ";
$result = $db->query($sql);

$receiptDetail_html = receiptDetail_render($result);
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
    <?php echo $header_html; ?>
    <main class='main'>
      <div class='wide'>
        <div class='row' id="user-modal">
            <div class="col c-12">
            <?=$receiptDetail_html;?>
            </div>
        </div>
      </div>
    </main>
    <?php echo $footer_html; ?>
  </div>
</body>

</html>
<?php
//Tao code HTML cho DS HOADON
function receiptDetail_render($result)
{
  global $db;
  $status = [
    '1' => 'pending',
    '2' => 'pending',
    '3' => 'pending',
    '4' => 'success',
    '5' => 'pending',
    '10' => 'error',
  ];
  $html = "<ul class='receipt__list'>";

  while ($row = $db->fetch($result)) {
    //Lay CT noi dung HOADON
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

    //In noi dung HOADON
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

    //Chen noi dung Nguoi Mua
    $html .= "
      <li class='receipt-list__item'>
        <div class='receipt-list-item__header flex'>
          <div class='receipt-list-item__title'>
            <h3 class='receipt-list-item-title__id'>Đơn Hàng #{$row['MAHD']}</h3>
            <h4 class='receipt-list-item-title__date font-normal'>Ngày mua hàng: ".formatDate($row['NGLAPHD'])."</h4>
          </div>
          <div class='receipt-list-item__status'>
            Trạng thái: 
            <span class='receipt-status--{$status[$row['MATT']]}'>{$row['TENTT']}<span>
          </div></div>
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
        <div class='price-list__item'>
          <div class='price-list-item__name'>Phí Vận Chuyển</div>
          <div class='price-list-item__price'>100.000đ</div>
        </div>
        <div class='receipt-list-item__price flex'>
          <span>Tổng Tiền</span>
          <span>$receiptPrice</span>
        </div>
      </li>
    ";
  }

  $html .= "</ul>";


  return $html;
}
?>