<?php
require_once("../models/Database.php");
include_once("../views/components/components.php");
include_once("../utils/utils.php");

session_start();
if (empty($_SESSION['ADMIN']) && empty($_SESSION['ADMIN']['HAS_LOGON'])) {
  header("location: login_admin.php");
}

$db = new Database();

$sql = [
  'product' => '
    select SANPHAM.*, HANGSANXUAT.TENHSX
    from SANPHAM inner join HANGSANXUAT
    on SANPHAM.MAHSX = HANGSANXUAT.MAHSX
  ',
  'manufacturer' => '
    select *
    from HANGSANXUAT
  ',
  'size' => '
    select *
    from KICHCO
  ',
  'category' => '
    select *
    from DANHMUC
  ',
  'image' => '
    select *
    from HINHANH
  ',
  'receipt' => '
    select *
    from HOADON
  ',
  'user' => '
    select *
    from NGUOIDUNG
  '
];

if (isset($_GET['search']) && isset($_GET['mode'])) {
  $search = $_GET['search'];
}

$current_page = isset($_GET["page"]) ? $_GET["page"] : 1;

$userPanelHtml = userPanel_render(isset($_GET['mode']) ? $_GET['mode'] : "admin-info");
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
          <a class="sidebar__item <?php echo (isset($_GET['mode']) && $_GET['mode'] == 'image') ? 'active' : ''; ?>" id="image-list_sidebar" href="?mode=image">
            Danh Sách Hình Ảnh
          </a>
          <a class="sidebar__item <?php echo (isset($_GET['mode']) && $_GET['mode'] == 'receipt') ? 'active' : ''; ?>" id="receipt-list_sidebar" href="?mode=receipt&page=1">
            Danh Sách Đơn Hàng
          </a>
          <a class="sidebar__item <?php echo (isset($_GET['mode']) && $_GET['mode'] == 'user') ? 'active' : ''; ?>" id="user-list_sidebar" href="?mode=user&page=1">
            Danh Sách Người Dùng
          </a>
          <a class='sidebar__item' href="../controllers/logout.php">
            <img class='sidebar-item__icon' src="../../public/img/logout_icon.svg">
            Đăng Xuất
          </a>
        </ul>
      </div>
      <div class="col c-10">
          <?php echo $userPanelHtml; ?>
        </div>
      </div>
    </div>
  </div>
</body>
</html>


<?php
function userPanel_render($mode) {
  $userPanelHeaderHtml = userPanelHeader_render($mode);
  $userPanelContentHtml = userPanelContent_render($mode);

  return "
    <div class='user-panel'>
      $userPanelHeaderHtml
      $userPanelContentHtml
    </div>
  ";
}

function userPanelContent_render($mode) {
  global $db, $sql, $current_page;

  if($mode!=="admin-info") {
    $paging = paging($db, $sql[$mode], $current_page);
    $newSQL = $paging['sql'];
    $result = $db->query($newSQL);
  }

  $html = "";
  switch($mode) {
    case "admin-info": {
      $html .= "
        <div class='user-panel__content active' id='admin-info_modal'>
        <div class='user-panel-item__content personal-info-wrap'>
          <h2 class='personal-info__title flex'>
            Thông Tin Cá Nhân
            <a href='edit_admin.php?mode=info' class='personal-title__edit-btn rounded font-medium flex-center'>Sửa</a>
          </h2>
          <ul class='personal-info__list'>
            <a class='personal-list__item'>
              <div class='personal-list-item__key'>Tên Tài Khoản:</div>
              <div class='personal-list-item__value'>{$_SESSION['ADMIN']['INFO']['TENTK']}</div>
            </a>
            <a class='personal-list__item'>
              <div class='personal-list-item__key'>Mật Khẩu:</div>
              <a href='edit_admin.php?mode=password' class='personal-list-item__change-pass-btn btn rounded-lg font-medium'>Đổi Mật Khẩu</a>
            </a>
          </ul>
        </div>
      </div>
      ";
      break;
    }
    case "image": {
      $html = "<div class='user-panel__content'><ul class='gallery-list flex flex-center'>";

      while ($row = $db->fetch($result)) {
        $imageData = base64_encode($row['URL']);

        $html .= "
          <a class='gallery-list__item rounded flex-center'>
            <img src='data:image/jpeg;base64,$imageData'>
            <span class='gallery-list-item__title'>SP-{$row['MASP']}-{$row['MAHA']}</span>
            <span class='gallery-list-item__action-btn'>Edit</span>
          </a>";
      }

      $html .= "
        </ul>
        {$paging['html']}
        </div>
      ";
      break;
    }
    default: {
      $html = "<div class='user-panel__content'><table class='list-table table table-striped table-bordered'><tr>";

      while($column = $db->fetch_field($result)) {
        $html .= "<th>".formatSQLColumnsName($column->name)."</th>";
      }

      $html .= "
        <th colspan='2'>Thao Tác</th>
      </tr>";

      while ($row = $db->fetch($result)) {
        $html.="<tr>";
        foreach($row as $key => $value) {
          if($key==='LOGO') {
            $imageData = base64_encode($value);
            $html .= "<td><img src='data:image/jpeg;base64,$imageData'></td>";
          }
          else {
            $html .= "<td>$value</td>";
          }
        }
        $html.="</tr>";
      }
      $html .= "
        </table>
          {$paging['html']}
        </div>
      ";
      break;
    }
  }
  return $html;
}

function userPanelHeader_render($mode) {
  $addBtn = '';
  $searchBar = '';

  switch($mode) {
    case "admin-info":
      break;
    case "receipt":
    case "user":
      $searchBar = "
        <form class='search-bar rounded'>
          <label class='search-bar__label flex-center' for='search-bar-input'>
            <img class='search-bar__icon' src='../../public/img/search_icon.svg' alt='Search Bar'>
          </label>
          <input type='text' name='search' id='search-bar-input' placeholder='Tìm Kiếm' />
          <input type='hidden' name='mode' value='$mode' />
        </form>
      ";
      break;
    default:
      $addBtn = "
        <div class='user-panel-header__action flex'>
          <a class='user-panel__add-btn btn btn-primary flex-center' href='add_admin.php?mode=$mode'>
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
          <input type='text' name='search' id='search-bar-input' placeholder='Tìm Kiếm' />
          <input type='hidden' name='mode' value='$mode' />
        </form>
      ";
  }
  return "
    <div class='user-panel__header flex'>    
      $addBtn
      $searchBar
    </div>
  ";
}
?>