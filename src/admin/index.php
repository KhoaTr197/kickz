<?php
require_once("../models/Database.php");
session_start();
if(empty($_SESSION['ADMIN']) && empty($_SESSION['ADMIN']['HAS_LOGON'])) {
  header("location: login_admin.php");
}

$db = new Database();
$productListSQL = "
  select SANPHAM.*, HANGSANXUAT.TENHSX
  from SANPHAM inner join HANGSANXUAT
  on SANPHAM.MAHSX = HANGSANXUAT.MAHSX
";
$manufacturerListSQL = "
  select *
  from HANGSANXUAT
";
$receiptListSQL = "
  select *
  from SANPHAM
";
$userListSQL = "
  select *
  from SANPHAM
";

if(isset($_GET['search']) && isset($_GET['mode'])) {
  $search=$_GET['search'];
  if(!empty($search))
    switch($_GET['mode']) {
      case 'product':
        $productListSQL .= "
        where TENSP like '%$search%' or
              MOTA like '%$search%' or
              MASP like $search";
        break;
      case 'receipt':
        $receiptListSQL .= "
        where HOTENKH like '%$search%' or
              MAHD like $search";
        break;
      case 'user':
        $userListSQL .= "
        where TENTK like '%$search%' or
              HOTEN like '%$search%' or
              MATK like $search";
        break;
    }
}
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
              <li class="sidebar__item <?php echo (isset($_GET['mode'])) ? '' : 'active';?>" id="admin-info_sidebar">
                Thông Tin Admin
              </li>
              <li class="sidebar__item <?php echo (isset($_GET['mode']) && $_GET['mode']=='product') ? 'active' : '';?>" id="product-list_sidebar">
                Danh Sách Sản Phẩm
              </li>
              <li class="sidebar__item <?php echo (isset($_GET['mode']) && $_GET['mode']=='size') ? 'active' : '';?>" id="size-list_sidebar">
                Danh Sách Kích Cỡ
              </li>
              <li class="sidebar__item <?php echo (isset($_GET['mode']) && $_GET['mode']=='manufacturer') ? 'active' : '';?>" id="manufacturer-list_sidebar">
                Danh Sách Hãng
              </li>
              <li class="sidebar__item <?php echo (isset($_GET['mode']) && $_GET['mode']=='category') ? 'active' : '';?>" id="category-list_sidebar">
                Danh Sách Danh Mục
              </li>
              <li class="sidebar__item <?php echo (isset($_GET['mode']) && $_GET['mode']=='image') ? 'active' : '';?>" id="image-list_sidebar">
                Danh Sách Hình Ảnh 
              </li>
              <li class="sidebar__item <?php echo (isset($_GET['mode']) && $_GET['mode']=='receipt') ? 'active' : '';?>" id="receipt-list_sidebar">
                Danh Sách Đơn Hàng
              </li>
              <li class="sidebar__item <?php echo (isset($_GET['mode']) && $_GET['mode']=='user') ? 'active' : '';?>" id="user-list_sidebar">
                Danh Sách Người Dùng
              </li>
              <a class='sidebar__item' href="../controllers/logout.php" >
                <img class='sidebar-item__icon' src="../../public/img/logout_icon.svg">
                Đăng Xuất
              </a>
            </ul>
        </div>
        <div class="col c-10">
            <div class="user-panel">
              <div class="user-panel__item <?php echo (isset($_GET['mode'])) ? '' : 'active';?>" id="admin-info_modal">
                <div class="personal-info-wrap">
                  <h2 class="personal-info__title flex">
                    Thông Tin Cá Nhân
                    <a href="edit_admin.php?mode=info" class="personal-title__edit-btn rounded font-medium flex-center">Sửa</a>
                  </h2>
                  <ul class="personal-info__list">
                    <li class="personal-list__item">
                      <div class="personal-list-item__key">Tên Tài Khoản:</div>
                      <div class="personal-list-item__value"><?php echo $_SESSION['ADMIN']['INFO']['TENTK'];?></div>
                    </li>
                    <li class="personal-list__item">
                      <div class="personal-list-item__key">Mật Khẩu:</div>
                      <a href="edit_admin.php?mode=password" class="personal-list-item__change-pass-btn btn rounded-lg font-medium">Đổi Mật Khẩu</a>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="user-panel__item <?php echo (isset($_GET['mode']) && $_GET['mode']=='product') ? 'active' : '';?>" id="product-list_modal">
                <div class="user-panel__header flex">
                  <div class="user-panel-header__action flex">
                    <a class="user-panel__add-btn btn btn-primary flex-center" href="addPage_admin.php">
                      <img src='../../public/img/plus_icon.svg'>
                      Thêm
                    </a>
                    <a class="user-panel__add-list-btn btn flex-center" href="importPage_admin.php?mode=product">Thêm Danh Sách</a>
                  </div>
                  <form class='search-bar rounded'>
                    <label class='search-bar__label flex-center' for='search-bar-input'>
                      <img class='search-bar__icon' src='../../public/img/search_icon.svg' alt='Search Bar'>
                    </label>
                    <input type='text' name='search' id='search-bar-input' placeholder='Tìm Kiếm'/>
                    <input type='hidden' name='mode' value='product'/>
                  </form>
                </div>
                <table class="list-table table table-striped table-bordered">
                  <?php
                    $result = $db->query($productListSQL);

                    echo
                      "<tr>
                        <th>Mã</th>
                        <th>Tên</th>
                        <th>Giá</th>
                        <th>Mô Tả</th>
                        <th>Đánh Giá</th>
                        <th>Hãng Sản Xuất</th>
                        <th>Ngày Sản Xuất</th>
                        <th colspan='2'>Thao Tác</th>
                      </tr>";

                    while($row = $db->fetch($result)) {
                      $price=number_format($row['GIA'], 0, '', '.')."đ";

                      echo
                      "<tr>
                        <td>{$row['MASP']}</td>
                        <td>{$row['TENSP']}</td>
                        <td>$price</td>
                        <td>{$row['MOTA']}</td>
                        <td>{$row['SOSAO']}</td>
                        <td>{$row['TENHSX']}</td>
                        <td>{$row['NGLAPSP']}</td>
                        <td class='table-action'>
                          <div class='table-action-wrap flex-center'>
                            <form class='table-action' action='#' method='post'>
                              <button class='btn' name='id' value='{$row['MASP']}'>Sửa</button>
                            </form>
                            <form class='table-action' action='#' method='post'>
                              <button class='btn' name='id' value='{$row['MASP']}'>Xóa</button>
                            </form>
                          </div>
                        </td>
                      </tr>";
                    }    
                  ?>           
                </table>
              </div>
              <div class="user-panel__item <?php echo (isset($_GET['mode']) && $_GET['mode']=='size') ? 'active' : '';?>" id="size-list_modal">
              </div>
              <div class="user-panel__item <?php echo (isset($_GET['mode']) && $_GET['mode']=='manufacturer') ? 'active' : '';?>" id="manufacturer-list_modal">
                <div class="user-panel__header flex">
                  <div class="user-panel-header__action flex">
                    <a class="user-panel__add-btn btn btn-primary flex-center" href="addPage_admin.php">
                      <img src='../../public/img/plus_icon.svg'>
                      Thêm
                    </a>
                    <a class="user-panel__add-list-btn btn flex-center" href="importPage_admin.php?mode=manufacturer">Thêm Danh Sách</a>
                  </div>
                  <form class='search-bar rounded'>
                    <label class='search-bar__label flex-center' for='search-bar-input'>
                      <img class='search-bar__icon' src='../../public/img/search_icon.svg' alt='Search Bar'>
                    </label>
                    <input type='text' name='search' id='search-bar-input' placeholder='Tìm Kiếm'/>
                    <input type='hidden' name='mode' value='product'/>
                  </form>
                </div>
                <table class="list-table table table-striped table-bordered">
                  <?php
                    $result = $db->query($manufacturerListSQL);

                    echo
                      "<tr>
                        <th>Mã</th>
                        <th>Tên</th>
                        <th colspan='2'>Thao Tác</th>
                      </tr>";

                    while($row = $db->fetch($result)) {
                      echo
                      "<tr>
                        <td>{$row['MAHSX']}</td>
                        <td>{$row['TENHSX']}</td>
                        <td class='table-action'>
                          <div class='table-action-wrap flex-center'>
                            <form class='table-action' action='#' method='post'>
                              <button class='btn' name='id' value='{$row['MAHSX']}'>Sửa</button>
                            </form>
                            <form class='table-action' action='#' method='post'>
                              <button class='btn' name='id' value='{$row['MAHSX']}'>Xóa</button>
                            </form>
                          </div>
                        </td>
                      </tr>";
                    }    
                  ?>           
                </table>
              </div>          
              <div class="user-panel__item <?php echo (isset($_GET['mode']) && $_GET['mode']=='category') ? 'active' : '';?>" id="category-list_modal">
              </div>
              <div class="user-panel__item <?php echo (isset($_GET['mode']) && $_GET['mode']=='image') ? 'active' : '';?>" id="image-list_modal">
                <div class="user-panel__header flex">
                  <div class="user-panel-header__action flex">
                    <a class="user-panel__add-btn btn btn-primary flex-center" href="addPage_admin.php?mode=image">
                      <img src='../../public/img/plus_icon.svg'>
                      Thêm
                    </a>
                    <a class="user-panel__add-list-btn btn flex-center" href="importPage_admin.php?mode=image">Thêm Danh Sách</a>
                  </div>
                  <form class='search-bar rounded'>
                    <label class='search-bar__label flex-center' for='search-bar-input'>
                      <img class='search-bar__icon' src='../../public/img/search_icon.svg' alt='Search Bar'>
                    </label>
                    <input type='text' name='search' id='search-bar-input' placeholder='Tìm Kiếm'/>
                    <input type='hidden' name='mode' value='product'/>
                  </form>
                </div>
              </div>
              <div class="user-panel__item <?php echo (isset($_GET['mode']) && $_GET['mode']=='receipt') ? 'active' : '';?>" id="receipt-list_modal">
                <div class="user-panel__header flex">
                  <form class='search-bar rounded'>
                    <label class='search-bar__label flex-center' for='search-bar-input'>
                      <img class='search-bar__icon' src='../../public/img/search_icon.svg' alt='Search Bar'>
                    </label>
                    <input type='text' name='search' id='search-bar-input' placeholder='Tìm Kiếm'/>
                    <input type='hidden' name='mode' value='receipt'/>
                  </form>
                </div>
                <table class="list-table table table-striped table-bordered">
                  <?php
                    $result = $db->query($receiptListSQL);

                    echo
                      "<tr>
                        <th>id</th>
                        <th>name</th>
                        <th>price</th>
                        <th>description</th>
                        <th>rating</th>
                        <th>manufactured date</th>
                      </tr>";

                    while($row = $db->fetch($result)) {
                      $id=$row['id'];
                      $name=$row['name'];
                      $price=number_format($row['price'], 0, '', '.')."đ";
                      $description=$row['description'];
                      $rating=$row['rating'];
                      $manufacturedDate	=$row['manufactured_date'];

                      echo
                        "<tr>
                          <td>$id</td>
                          <td>$name</td>
                          <td>$price</td>
                          <td>$description</td>
                          <td>$rating</td>
                          <td>$manufacturedDate</td>
                        </tr>";
                    }    
                  ?>           
                </table>
              </div>
              <div class="user-panel__item <?php echo (isset($_GET['mode']) && $_GET['mode']=='user') ? 'active' : '';?>" id="user-list_modal">
                <div class="user-panel__header flex">
                  <form class='search-bar rounded'>
                    <label class='search-bar__label flex-center' for='search-bar-input'>
                      <img class='search-bar__icon' src='../../public/img/search_icon.svg' alt='Search Bar'>
                    </label>
                    <input type='text' name='search' id='search-bar-input' placeholder='Tìm Kiếm'/>
                    <input type='hidden' name='mode' value='user'/>
                  </form>
                </div>
                <table class="list-table table table-striped table-bordered">
                  <?php
                    $result = $db->query($userListSQL);

                    echo
                      "<tr>
                        <th>id</th>
                        <th>name</th>
                        <th>price</th>
                        <th>description</th>
                        <th>rating</th>
                        <th>manufactured date</th>
                      </tr>";

                    while($row = $db->fetch($result)) {
                      $id=$row['id'];
                      $name=$row['name'];
                      $price=number_format($row['price'], 0, '', '.')."đ";
                      $description=$row['description'];
                      $rating=$row['rating'];
                      $manufacturedDate	=$row['manufactured_date'];

                      echo
                        "<tr>
                          <td>$id</td>
                          <td>$name</td>
                          <td>$price</td>
                          <td>$description</td>
                          <td>$rating</td>
                          <td>$manufacturedDate</td>
                        </tr>";
                    }    
                  ?>           
                </table>
              </div>
            </div>
        </div>
      </div>
  </div>
</body>
</html>