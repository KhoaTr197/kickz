<?php
require_once("../models/Database.php");
include_once("components/components.php");
session_start();

if(!isset($_GET['id']))
  header("location: browse.php");

$db = new Database();

$header_html = header_render("breadcrumb", false, "{$_SESSION['URL_BACKUP']}");
$footer_html = footer_render();

$productData = getProductData();
$carousel_html = carousel_render();
$sizeList_html = sizeList_render();
$ratings_html = rating_render();

$oldPrice = $productData['KHUYENMAI'] != 0 ? formatPrice($productData['GIA']) : '';

$newPrice = formatPrice($productData['GIA'] - $productData['KHUYENMAI']);

$newPriceNoFormat = $productData['GIA'] - $productData['KHUYENMAI'];

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
        <?php
        echo "
            <div class='product-detail row'>
              <div class='col c-7'>
                <div class='detail-carousel'>
                  <div class='carousel__preview flex-center'>
                    {$carousel_html['previewImage']}
                  </div>
                  <div class='carousel__gallery flex-center'>
                    {$carousel_html['images']}
                  </div>
                </div>
              </div>
              <div class='col c-5'>
                <form class='detail-panel flex' method='post' action='../controllers/cartController.php'>
                  <input name='id' value={$productData['MASP']} hidden>
                  <input name='size' value='' hidden>
                  <input name='price' value=$newPriceNoFormat hidden>
                  <div class='detail-panel__name font-medium'>
                    {$productData['TENSP']}
                    <div class='detail__ratings flex'>
                      $ratings_html
                    </div>
                  </div>
                  <div class='detail-panel__price'>
                    <div class='price--old font-normal'>$oldPrice</div>
                    <div class='price--new'>$newPrice</div>
                  </div>
                  <div class='detail-panel__size'>
                    <p class='size-title font-normal'>Kích Cỡ</p>
                    <ul class='size-list flex'>
                      $sizeList_html
                    </ul>
                  </div>
                  <button class='detail-panel__action-btn' name='mode' value='addToCart'>
                    <div class='add-cart-btn btn btn-primary flex-center font-semibold'>
                      <img src='../../public/img/add-cart_icon.svg'>
                      <span>Thêm Vào Giỏ Hàng</span>
                    </div>
                  </button>
                </form>
              </div>
              <div class='col c-12'>
                <div class='detail-description flex'>
                  <div class='detail-description__title'>Mô Tả Chi Tiết</div>
                  <div class='detail-description__info'>
                    <div class='brand'>Hãng: {$productData['TENHSX']}</div>
                    <div class='date'>Ngày Ra Mắt: {$productData['NGSX']}</div>
                  </div>
                  <div class='detail-description__description font-normal'>{$productData['MOTA']}</div>
                </div>
              </div>
            </div>
          ";
        ?>
      </div>
  </main>
  <?php echo $footer_html; ?>
  </div>
</body>

</html>

<?php
function getProductData()
{
  global $db;

  $productSQL = "
    select *
    from SANPHAM inner join HANGSANXUAT
    on SANPHAM.MAHSX = HANGSANXUAT.MAHSX
    where MASP = {$_GET['id']}
  ";

  return $db->fetch($db->query($productSQL));
}
function carousel_render()
{
  global $db;
  $imageSQL = "
    select *
    from HINHANH
    where MASP = {$_GET['id']}
  ";

  $imageSQLResult = $db->query($imageSQL);
  $previewImage = "";
  $images = "";
  while ($row = $db->fetch($imageSQLResult)) {
    $imageData = base64_encode($row['FILE']);

    if ($row['MAHA'] == 1) {
      $previewImage = "<img class='carousel-preview__img' id='carousel-{$row['MAHA']}' src='data:image/jpeg;base64,$imageData'>";
      $images .= "<img class='carousel-gallery__img active' id='carousel-{$row['MAHA']}' src='data:image/jpeg;base64,$imageData'>";
    } else {
      $images .= "<img class='carousel-gallery__img' id='carousel-{$row['MAHA']}' src='data:image/jpeg;base64,$imageData'>";
    }
  }

  return [
    'previewImage' => $previewImage,
    'images' => $images
  ];
}
function sizeList_render()
{
  global $db;

  $sizeSQL = "
    select *
    from KICHCO
    where MASP = {$_GET['id']}
  ";
  $html = "";

  $sizeSQLResult = $db->query($sizeSQL);
  while ($row = $db->fetch($sizeSQLResult)) {
    $html .= "
      <li class='size-item btn flex-center' value={$row['MAKC']} >
        <span class='size-item__size '>{$row['COGIAY']}</span>
        <span class='size-item__quantity font-bold'>SL: {$row['SOLUONG']}</span>
      </li>
    ";
  }

  return $html;
}
function rating_render()
{
  global $productData;
  $html = "";

  for ($i = 0; $i < 5; $i++) {
    if ($i < $productData['SOSAO'])
      $html .= "<img src='../../public/img/star_icon.svg'>";
    else
      $html .= "<img src='../../public/img/faded-star_icon.svg'>";
  }

  return $html;
}
?>