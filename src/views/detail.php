<?php 
  include "components/components.php";
      
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
  <script src="public/js/jquery-3.7.1.min.js"></script>
  <title>Kickz</title>
</head>
<body>
  <div id="app" class="grid">
    <?php echo $header_html?>
    <main class='main'>
      <div class='wide'>
        <div class='product-detail row'>
          <div class='detail-carousel col c-7'>
            <div class='carousel__preview flex-center'>
              <img src='../../public/img/shoe-right-side-test.jpg'>
            </div>
            <div class='carousel__gallery flex-center'>
              <img class='active' src='../../public/img/shoe-right-side-test.jpg' width='128' height='96'>
              <img src='../../public/img/shoe-right-side-test.jpg'>
              <img src='../../public/img/shoe-right-side-test.jpg'>
              <img src='../../public/img/shoe-right-side-test.jpg'>
            </div>
          </div>
          <div class='detail-panel flex col c-5'>
            <div class='detail-panel__name font-medium'>
              Jordan 3 Retro OG SP A Ma Maniére While You Were Sleeping (Women's)
              <div class='detail__ratings flex'>
                <img src='../../public/img/star_icon.svg' >
                <img src='../../public/img/star_icon.svg' >
                <img src='../../public/img/star_icon.svg' >
                <img src='../../public/img/star_icon.svg' >
                <img src='../../public/img/star_icon.svg' >
              </div>
            </div>
            <div class='detail-panel__price'>
              <div class='price--old font-normal'>4.999.999đ</div>
              <div class='price--new'>3.699.999đ</div>
            </div>
            <div class='detail-panel__size'>
              <p class='size-title font-normal'>Kích Cỡ</p>
              <ul class='size-list flex'>
                <li class='size-item btn flex-center'>40</li>
                <li class='size-item btn flex-center'>40.5</li>
                <li class='size-item btn-primary flex-center'>41</li>
                <li class='size-item btn flex-center'>41.5</li>
                <li class='size-item btn flex-center'>42</li>
                <li class='size-item btn flex-center'>42.5</li>
              </ul>
            </div>
            <div class='detail-panel__action-btn'>
              <div class='add-cart-btn btn btn-primary flex-center font-semibold'>
                <img src='../../public/img/add-cart_icon.svg'>
                <span>Thêm Vào Giỏ Hàng</span>
              </div>
              <div class='wishlist-btn btn flex-center'>
                <img src='../../public/img/heart_icon.svg'>
              </div>
            </div>
          </div>
          <div class='detail-description flex col c-12'>
            <div class='detail-description__title'>Mô Tả Chi Tiết</div>
            <div class='detail-description__info'>
              <div class='brand'>Hãng: NIKE</div>
              <div class='date'>Ngày Ra Mắt: 20/08/2024</div>
            </div>
            <div class='detail-description__description font-normal'>The Air Jordan 3 Retro OG SP A Ma Maniére While You Were Sleeping (Women’s) là một sự tiếp nối tuyệt đẹp của mối hợp tác nổi tiếng giữa A Ma Maniére và Jordan Brand. Nổi tiếng với thẩm mỹ sang trọng và kể chuyện, A Ma Maniére mang đến một kiệt tác khác với màu sắc đen, tím ore và pewter phẳng này. Là một phần của bộ sưu tập \"While You Were Sleeping\" lớn hơn, đôi giày vẫn trung thành với phong cách đặc trưng của thương hiệu với chất liệu cao cấp và chi tiết thiết kế chu đáo. Sự phát hành này mang theo cùng một tiêu chuẩn cao đã làm cho đôi giày đầu tiên A Ma Maniére Jordan 3 trở thành một cổ điển ngay lập tức.</div>
            </div>
          </div>
        </div>
      </div>
    </main>
    <?php echo $footer_html?>
  </div>
  <script src="../../public/js/app.js"></script>
</body>
</html>