<?php
  include_once("components/components.php");

  $header_html = header_render("navbar");
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
          <div class='row'>
            <div class='landing-page'>
              <div class='landing-page-wrap wide'>
                <div class='landing-text'>
                    <div class='landing-text__title'>Tìm Đôi Giày Mơ Ước Của Bạn</div>
                    <div class='landing-text__detail'>Cửa hàng chúng tôi cung cấp nhiều loại giày đáp ứng được yêu cầu của bạn</div>
                    <p class='landing-text__btn rounded-lg btn-primary'>
                      <a href='browse.php'>Tìm Hiểu Thêm</a>
                    </p>
                </div>
                  
                <img id='landing-img' src='../../public/img/landing_img.png' alt='Landing Image'>
              
                <ul class='trust-badge-list'>
                  <li class='trust-badge'>
                    <div class='trust-badge-icon-wrap flex-center rounded-lg'>
                      <img src='../../public/img/verify_icon.svg' alt='Verification Icon'>
                    </div>
                    <div class='trust-badge-text'>
                      <div class='trust-badge-text__title'>Thanh Toán Bảo Mật</div>
                      <div class='trust-badge-text__detail'>Bảo mật trên đơn hàng</div>
                    </div>
                  </li>
                  <li class='trust-badge'>
                    <div class='trust-badge-icon-wrap flex-center rounded-lg'>
                      <img src='../../public/img/clock_icon.svg' alt='Verification Icon'>
                    </div>
                    <div class='trust-badge-text'>
                      <div class='trust-badge-text__title'>Hỗ Trợ 24/7</div>
                      <div class='trust-badge-text__detail'>Liên hệ bất kì lúc nào</div>
                    </div>
                  </li>
                  <li class='trust-badge'>
                    <div class='trust-badge-icon-wrap flex-center rounded-lg'>
                      <img src='../../public/img/delivery_icon.svg' alt='Verification Icon'>
                    </div>
                    <div class='trust-badge-text'>
                      <div class='trust-badge-text__title'>Giao Hàng Nhanh</div>
                      <div class='trust-badge-text__detail'>Nhanh hơn bạn tưởng</div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </main>
    <?php echo $footer_html; ?>
  </div>
</body>
</html>