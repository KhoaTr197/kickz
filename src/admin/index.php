<?php
require_once("../models/Database.php");
include_once("../views/components/components.php");
include_once("../utils/utils.php");

session_start();

if (empty($_SESSION['ADMIN']) && empty($_SESSION['ADMIN']['HAS_LOGON'])) {
  header("location: login_admin.php");
}

$search = "";
if (isset($_GET['search']) && isset($_GET['mode'])) {
  $search = urldecode($_GET['search']);
}

$db = new Database();

$sql = [
  'product' => "
    select SANPHAM.MASP, SANPHAM.TENSP, SANPHAM.GIA, SANPHAM.KHUYENMAI, SANPHAM.MOTA, SANPHAM.SOSAO,SANPHAM.NGSX, SANPHAM.TRANGTHAI, HANGSANXUAT.TENHSX, GROUP_CONCAT(DANHMUC.TENDM SEPARATOR ', ') as DANHMUC
    from SANPHAM
    inner join HANGSANXUAT
    on SANPHAM.MAHSX = HANGSANXUAT.MAHSX
    left join PHANLOAI
    on SANPHAM.MASP = PHANLOAI.MASP
    left join DANHMUC
    on PHANLOAI.MADM = DANHMUC.MADM
    where CONCAT(SANPHAM.MASP, TENSP, GIA, KHUYENMAI, MOTA, SOSAO, NGSX, TRANGTHAI, TENHSX) like '%$search%'
    group by SANPHAM.MASP
    having GROUP_CONCAT(DANHMUC.TENDM SEPARATOR ', ') like '%$search%'
  ",
  'manufacturer' => "
    select *
    from HANGSANXUAT
    where CONCAT(TENHSX, MAHSX) like '%$search%'
  ",
  'size' => "
    select *
    from KICHCO
    where CONCAT(MASP, MAKC, COGIAY, SOLUONG) like '%$search%'
    order by MASP asc, MAKC asc
  ",
  'category' => "
    select *
    from DANHMUC
    where CONCAT(MADM, TENDM) like '%$search%'
  ",
  'image' => "
    select *
    from HINHANH
    where CONCAT(MASP, MAHA) like '%$search%'
    order by MASP
  ",
  'receipt' => "
    select MAHD, MATK, TONGTIEN, HOTENKH, EMAIL, SDT, DCHI, GHICHU, NGLAPHD, TRANGTHAI.*
    from HOADON inner join TRANGTHAI
    on HOADON.MATT = TRANGTHAI.MATT
    where CONCAT(MAHD,MATK,TONGTIEN,HOTENKH,EMAIL,SDT,DCHI,GHICHU,NGLAPHD) like '%$search%'
  ",
  'user' => "
    select MATK,TENTK,HOTEN,EMAIL,SDT,NGLAPTK,TRANGTHAI	
    from NGUOIDUNG
    where CONCAT(MATK, TENTK, HOTEN, EMAIL, SDT, NGLAPTK, TRANGTHAI) LIKE '%$search%'
  "
];

$userPanel_html = userPanel_render(isset($_GET['mode']) ? $_GET['mode'] : "admin-info");
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
    <div class="row no-gutters" id="admin">
      <?php echo notify('ADMIN_HOMEPAGE'); ?>
      <div class='col c-2'>
        <ul class="sidebar flex">
          <a href="../views/homepage.php" class="homepage-btn flex-center">
            <img src="../../public/img/logo_icon.svg">
          </a>
          <a class="sidebar__item <?php echo (isset($_GET['mode']) && $_GET['mode'] == 'admin-info') ? 'active' : ''; ?>" id="admin-info_sidebar" href="?mode=admin-info">
            Thông Tin Admin
          </a>
          <a class="sidebar__item <?php echo (isset($_GET['mode']) && $_GET['mode'] == 'product') ? 'active' : ''; ?>" id="product-list_sidebar" href="?mode=product&page=1">
            Danh Sách Sản Phẩm
          </a>
          <a class="sidebar__item <?php echo (isset($_GET['mode']) && $_GET['mode'] == 'size') ? 'active' : ''; ?>" id="size-list_sidebar" href="?mode=size&page=1">
            Danh Sách Kích Cỡ
          </a>
          <a class="sidebar__item <?php echo (isset($_GET['mode']) && $_GET['mode'] == 'manufacturer') ? 'active' : ''; ?>" id="manufacturer-list_sidebar" href="?mode=manufacturer&page=1">
            Danh Sách Hãng
          </a>
          <a class="sidebar__item <?php echo (isset($_GET['mode']) && $_GET['mode'] == 'category') ? 'active' : ''; ?>" id="category-list_sidebar" href="?mode=category&page=1">
            Danh Sách Danh Mục
          </a>
          <a class="sidebar__item <?php echo (isset($_GET['mode']) && $_GET['mode'] == 'image') ? 'active' : ''; ?>" id="image-list_sidebar" href="?mode=image&page=1">
            Danh Sách Hình Ảnh
          </a>
          <a class="sidebar__item <?php echo (isset($_GET['mode']) && $_GET['mode'] == 'receipt') ? 'active' : ''; ?>" id="receipt-list_sidebar" href="?mode=receipt&page=1">
            Danh Sách Đơn Hàng
          </a>
          <a class="sidebar__item <?php echo (isset($_GET['mode']) && $_GET['mode'] == 'user') ? 'active' : ''; ?>" id="user-list_sidebar" href="?mode=user&page=1">
            Danh Sách Người Dùng
          </a>
          <a class='sidebar__item' href="../controllers/logoutController.php?mode=admin">
            <img class='sidebar-item__icon' src="../../public/img/logout_icon.svg">
            Đăng Xuất
          </a>
        </ul>
      </div>
      <div class="col c-10">
        <?php echo $userPanel_html; ?>
      </div>
    </div>
  </div>
  </div>
</body>

</html>


<?php
function userPanel_render($mode)
{
  $userPanelHeader_html = userPanelHeader_render($mode);
  $userPanelContent_html = userPanelContent_render($mode);

  return "
    <div class='user-panel'>
      $userPanelHeader_html
      $userPanelContent_html
    </div>
  ";
}

function userPanelContent_render($mode)
{
  $html = "";
  switch ($mode) {
    case "admin-info": {
        $html .= "
        <div class='user-panel__content active' id='admin-info_modal'>
        <div class='user-panel-item__content personal-info-wrap'>
          <h2 class='personal-info__title flex'>
            Thông Tin Cá Nhân
            <a href='edit_admin.php?mode=admin-info' class='personal-title__edit-btn rounded font-medium flex-center'>Sửa</a>
          </h2>
          <ul class='personal-info__list'>
            <li class='personal-list__item'>
              <div class='personal-list-item__key'>Tên Tài Khoản:</div>
              <div class='personal-list-item__value'>{$_SESSION['ADMIN']['INFO']['TENTK']}</div>
            </li>
            <li class='personal-list__item'>
              <div class='personal-list-item__key'>Mật Khẩu:</div>
              <a href='edit_admin.php?mode=admin-password' class='personal-list-item__change-pass-btn btn rounded-lg font-medium'>Đổi Mật Khẩu</a>
            </li>
          </ul>
        </div>
      </div>
      ";
        break;
      }
    default:
      $html .= userPanelTable_render($mode);
      break;
  }
  return "
    <div class='user-panel__content'>
      $html
    </div>
  ";
}

function userPanelTable_render($mode)
{
  global $db, $sql;

  $tableRows_html = "";
  $filterList_html = "";
  $filterList = [
    'none' => 'Tất Cả'
  ];

  switch($mode) {
    case 'receipt': {
      if(isset($_GET['status']) and $_GET['status'] != 'none')
        $sql['receipt'] .= " and TRANGTHAI.MATT = {$_GET['status']}";

      $statusListResult = $db->query("select * from TRANGTHAI");
      while ($row = $db->fetch($statusListResult)) {
        $filterList[$row['MATT']] = $row['TENTT'];
      }
    }
      break;
    default:
      break;
  }

  $paging = paging($db, $sql[$mode]);
  $newSQL = $paging['sql'];
  $result = $db->query($newSQL);

  $tableRows_html .= "<tr>";
  while ($column = $db->fetch_field($result)) {
    if($column->name == 'MATT')
      continue;
    $tableRows_html .= "<th>" . formatSQLColumnsName($column->name) . "</th>";
  }
  $tableRows_html .= "
    <th colspan='2'>Thao Tác</th>
  </tr>";
  while ($row = $db->fetch($result)) {
    $tableRows_html .= "<tr>";
    foreach ($row as $key => $value) {
      switch ($key) {
        case 'MATT':
          break;
        case 'LOGO':
        case 'FILE':
          $imageData = base64_encode($value);
          $tableRows_html .= "<td><img src='data:image/jpeg;base64,$imageData'></td>";
          break;
        case 'GIA':
        case 'TONGTIEN':
          $tableRows_html .= "<td>" . formatPrice($value) . "</td>";
          break;
        case 'NGSX':
        case 'NGLAPHD':
          $tableRows_html .= "<td>" . formatDate($value) . "</td>";
          break;
        case 'TRANGTHAI':
          $tableRows_html .= "<td>" . formatStatus($value, $mode) . "</td>";
          break;
        default:
          $tableRows_html .= "<td>$value</td>";
          break;
      }
    }
    $queryStr = getQueryStr($row, $mode);

    $tableRows_html .= tableActionBtn_render($mode, $queryStr, $row);
    $tableRows_html .= "</tr>";
  }

  $filterList_html = filterPanel_render(['status'=>$filterList], 'button', 'row');

  return "
    $filterList_html
    <table class='list-table table table-striped table-bordered'>
      $tableRows_html
    </table>
    {$paging['html']}
  ";
}

function userPanelHeader_render($mode)
{
  $addBtn = '';
  $searchBar = '';

  switch ($mode) {
    case "admin-info":
      return '';
      break;
    case "receipt":
    case "user":
      $searchBar = "
        <form class='search-bar rounded'>
          <label class='search-bar__label flex-center' for='search-bar-input'>
            <img class='search-bar__icon' src='../../public/img/search_icon.svg' alt='Search Bar'>
          </label>
          <input type='text' name='search' id='search-bar-input' placeholder='Tìm Kiếm' value=''/>
          <input type='hidden' name='mode' value='$mode' />
        </form>
      ";
      break;
    default:
      $addBtn = "
        <div class='user-panel-header__action flex'>
          <a class='user-panel__add-btn btn btn-primary flex-center' href='insert_admin.php?mode=$mode'>
            <img src='../../public/img/plus_icon.svg'>
            Thêm
          </a>
          <a class='user-panel__add-list-btn btn flex-center' href='import_admin.php?mode=$mode'>Thêm Danh Sách</a>
        </div>
      ";
      $searchBar = "
        <form class='search-bar rounded'>
          <label class='search-bar__label flex-center' for='search-bar-input'>
            <img class='search-bar__icon' src='../../public/img/search_icon.svg' alt='Search Bar'>
          </label>
          <input type='text' name='search' id='search-bar-input' placeholder='Tìm Kiếm' value=''/>
          <input type='hidden' name='mode' value='$mode' />
        </form>
      ";
  }
  return "
    <div class='user-panel__header flex flex-center'>    
      $addBtn
      $searchBar
    </div>
  ";
}

function tableActionBtn_render($mode, $queryStr, $row) {
  $html="";

  $editBtn="
    <a class='btn btn-secondary' href='edit_admin.php?$queryStr'>Sửa</a>
  ";
  $disableBtn="
    <a class='table-action__disable-btn btn btn-error' href='../controllers/disableController.php?$queryStr'>Xóa</a>
  ";
  $enableBtn="
    <a class='table-action__enable-btn btn btn-primary' href='../controllers/enableController.php?$queryStr'>Kích hoạt</a>
  ";

  switch($mode) {
    case 'product':
      if(isset($row['TRANGTHAI']) and $row['TRANGTHAI'] == 0)
        $html .= "
        <td class='table-action-wrap'>
          <div class='table-action flex flex-center'>
            <a class='btn btn-secondary' href='edit_admin.php?$queryStr'>Sửa</a>
            $enableBtn
          </div>
        </td>
        ";
      else
        $html .= "
          <td class='table-action-wrap'>
            <div class='table-action flex flex-center'>
              $editBtn
              $disableBtn
            </div>
          </td>
        ";
      break;
    case 'receipt': {
      switch ($row['MATT']) {
        case 1:
          $html .= "
            <td class='table-action-wrap table-action--receipt'>
              <div class='table-action flex flex-center'>
                <a class='btn btn-secondary' href='../controllers/receiptController.php?$queryStr' >Phê Duyệt</a>
              </div>
            </td>
          ";
          break;
        case 2:
          $html .= "
            <td class='table-action-wrap table-action--receipt'>
              <div class='table-action flex flex-center'>
                <a class='btn btn-secondary' href='../controllers/receiptController.php?$queryStr' >Chuẩn bị hàng</a>
              </div>
            </td>
          ";
          break;
        case 3:
          $html .= "
            <td class='table-action-wrap table-action--receipt'>
              <div class='table-action flex flex-center'>
                <a class='btn btn-secondary' href='../controllers/receiptController.php?$queryStr&nextStatus=5' >Trả hàng</a>
                <a class='btn btn-secondary' href='../controllers/receiptController.php?$queryStr&nextStatus=4' >Đã giao</a>
              </div>
            </td>
          ";
          break;
        case 10:
          break;
      }
      break;
    }
    case 'user':
      break;
    default:
      $html .= "
        <td class='table-action-wrap'>
          <div class='table-action flex flex-center'>
            $editBtn
            $disableBtn
          </div>
        </td>
      ";
      break;
  }
  return $html;
}

function getQueryStr($row, $mode)
{
  $prevQueryStr="";
  foreach($_GET as $key => $value) {
    $prevQueryStr .= "$key=$value&";
  }
  switch ($mode) {
    case 'product':
      return "$prevQueryStr&id={$row['MASP']}";
    case 'manufacturer':
      return "$prevQueryStr&id={$row['MAHSX']}";
    case 'category':
      return "$prevQueryStr&id={$row['MADM']}";
    case 'size':
      return "$prevQueryStr&id={$row['MAKC']}&productId={$row['MASP']}";
    case 'image':
      return "$prevQueryStr&id={$row['MAHA']}&productId={$row['MASP']}";
    case 'receipt':
      return "$prevQueryStr&id={$row['MAHD']}&currStatus={$row['MATT']}";
  }
}

?>