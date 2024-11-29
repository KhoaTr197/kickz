<?php
  require_once("../models/Database.php");
  include_once("components/components.php");
  session_start();

  if(!isset($_SESSION['CATEGORY_LIST']) || !isset($_SESSION['MANUFACTURER_LIST']))
    header("location: ../../index.php");

  if($_SESSION['URL_BACKUP'] != $_SERVER['REQUEST_URI']) 
    $_SESSION['URL_BACKUP'] = $_SERVER['REQUEST_URI'];

  $header_html = header_render("navbar", isset($_SESSION['USER']['HAS_LOGON']) ? $_SESSION['USER']['HAS_LOGON'] : false);
  $breadcrumbsNav_html = breadcrumbsNav_render();
  $filterPanel = filterPanel_render();
  $footer_html = footer_render();
  
  $db = new Database();
  $sql = getSQL();
  
  $limit = 16;
  $paging = paging($db, $sql, $limit);

  $newSQl = $paging['sql'];
  $result = $db->query($newSQl);
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
            <div class='row' id="browse">
              <?php echo $filterPanel; ?>
              <div id='product-list' class='col l-10 c-12'>
                <?php echo $breadcrumbsNav_html; ?>
                <div class='row no-gutter'>
                  <?php             
                    while ($row = $db->fetch($result)) {
                      echo productCard_render($row);
                    }
                  ?>
                </div>
                <div class="flex-center" id="pagination">
                  <?php echo $paging['html'];?>
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
function getSQL() {
  $result = "
    select SANPHAM.*, HINHANH.*, HANGSANXUAT.LOGO
    from SANPHAM
    inner join HINHANH
    on SANPHAM.MASP = HINHANH.MASP
    inner join HANGSANXUAT
    on SANPHAM.MAHSX = HANGSANXUAT.MAHSX
  ";
  $filter = "where HINHANH.MAHA = 1 ";

  if(isset($_GET['manufacturer'])) {
    $filter .= "
      and HANGSANXUAT.MAHSX = {$_GET['manufacturer']}
    ";
  }

  if(isset($_GET['category'])) {
    $result .= "
      inner join PHANLOAI
      on SANPHAM.MASP = PHANLOAI.MASP
    ";
    $filter .= "
      and PHANLOAI.MADM = {$_GET['category']}
    ";
  }

  if(isset($_GET['price'])) {
    $price = explode('-', $_GET['price']);

    switch($price[0]) {
      case 'less':
        $filter .= "and SANPHAM.GIA < {$price[1]}";
        break;
      case 'more':
        $filter .= "and SANPHAM.GIA > {$price[1]}";
        break;
      default:
        $filter .= "and SANPHAM.GIA between {$price[0]} and {$price[1]}";
        break;
    }
  }

  if(isset($_GET['rating'])) {
    $filter .= "
      and SANPHAM.SOSAO = {$_GET['rating']}
    ";
  }

  if(isset($_GET['search'])) {
    $filter .= "
      and SANPHAM.TENSP like '%{$_GET['search']}%'
    ";
  }

  return $result.$filter;
}
function breadcrumbsNav_render() {
  $nav="";

  if(isset($_GET['category']))
    foreach($_SESSION['CATEGORY_LIST'] as $category) {
      if($_GET['category'] == $category['MADM'])
        $nav .= "<a href='browse.php'>Trang Chủ</a> / <span class='breadcrumb-nav__item'>{$category['TENDM']}</span>";
    }
  else if(isset($_GET['manufacturer']))
  foreach($_SESSION['MANUFACTURER_LIST'] as $manufacturer) {
    if($_GET['manufacturer'] == $manufacturer['MAHSX'])
      $nav .= "<a href='browse.php'>Trang Chủ</a> / <span class='breadcrumb-nav__item'>{$manufacturer['TENHSX']}</span>";
  }
  
  
  return "
    <div class='row no-gutter'>
      <div class='col c-12'>
        <div class='breadcrumb-nav font-normal'>         
          $nav
        </div>
      </div>
    </div>
  ";
}
?>