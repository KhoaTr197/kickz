<?php
  include_once("components/components.php");
  session_start();

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
    <?php echo $header_html;?>
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
                <a href="../controllers/logout.php" class='sidebar__item'>
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
                        <div class="personal-list-item__value"><?php echo $_SESSION['LOGIN']['INFO']['username'];?></div>
                      </li>
                      <li class="personal-list__item">
                        <div class="personal-list-item__key">Họ Tên:</div>
                        <div class="personal-list-item__value"><?php echo $_SESSION['LOGIN']['INFO']['fullname'];?></div>
                      </li>
                      <li class="personal-list__item">
                        <div class="personal-list-item__key">Email:</div>
                        <div class="personal-list-item__value"><?php echo $_SESSION['LOGIN']['INFO']['email'];?></div>
                      </li>
                      <li class="personal-list__item">
                        <div class="personal-list-item__key">SĐT:</div>
                        <div class="personal-list-item__value"><?php echo $_SESSION['LOGIN']['INFO']['phone'];?></div>
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
                    <ul class="receipt__list">
                      <li class="receipt-list__item">Đơn Hàng 1</li>
                      <li class="receipt-list__item">Đơn Hàng 2</li>
                      <li class="receipt-list__item">Đơn Hàng 3</li>
                    </ul>
                  </div>
                </li>
              </div>
            </div>
          </div>
        </div>
      </main>
    <?php echo $footer_html;?>
  </div>
</body>
</html>