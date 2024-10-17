<?php
include 'carousel.php';

function sizeTable_render() {
  return "
    <div class='detail-panel__size'>
      <p class='size-title'>Kích Cỡ</p>
      <ul class='size-list'>
        <li class='size-item btn flex-center'>40</li>
        <li class='size-item btn flex-center'>40.5</li>
        <li class='size-item btn-primary flex-center'>41</li>
        <li class='size-item btn flex-center'>41.5</li>
        <li class='size-item btn flex-center'>42</li>
        <li class='size-item btn flex-center'>42.5</li>
      </ul>
    </div>
  ";
}

function ratings_render() {
  return "
    <div class='detail__ratings flex'>
      <img src='public/img/star_icon.svg' >
      <img src='public/img/star_icon.svg' >
      <img src='public/img/star_icon.svg' >
      <img src='public/img/star_icon.svg' >
      <img src='public/img/star_icon.svg' >
    </div>
  ";
}

function productDetail_render() {
  $Carousel = carousel_render();
  $Ratings = ratings_render();
  $SizeTable = sizeTable_render();
  $DetailPanel = "
    <div class='detail-panel flex col c-5'>
      <div class='detail-panel__name'>
        Jordan 3 Retro OG SP A Ma Maniére While You Were Sleeping (Women's)
        $Ratings
      </div>
      <div class='detail-panel__price'>
        <div class='price--old'>4.999.999đ</div>
        <div class='price--new'>3.699.999đ</div>
      </div>
      $SizeTable
      <div class='detail-panel__action-btn'>
        <div class='add-cart-btn btn-primary flex-center'>
          <img src='public/img/add-cart_icon.svg'>
          Thêm Vào Giỏ Hàng
        </div>
        <div class='wishlist-btn btn flex-center'>
          <img src='public/img/heart_icon.svg'>
        </div>
      </div>
    </div>
  ";

  return "
    <div class='product-detail' id='product-detail'>
      <div class='wide'>
        <div class='product-detail__overview row'>
          $Carousel
          $DetailPanel
        </div>
        <div class='product-detail__description row'>
          <div class='product-detail__description-wrap flex c-12'>
            <div class='title'>Mô Tả Chi Tiết</div>
            <div class='brand'>Hãng: NIKE</div>
            <div class='date'>Ngày Ra Mắt: 20/08/2024</div>
            <div class='description'>The Air Jordan 3 Retro OG SP A Ma Maniére While You Were Sleeping (Women’s) là một sự tiếp nối tuyệt đẹp của mối hợp tác nổi tiếng giữa A Ma Maniére và Jordan Brand. Nổi tiếng với thẩm mỹ sang trọng và kể chuyện, A Ma Maniére mang đến một kiệt tác khác với màu sắc đen, tím ore và pewter phẳng này. Là một phần của bộ sưu tập \"While You Were Sleeping\" lớn hơn, đôi giày vẫn trung thành với phong cách đặc trưng của thương hiệu với chất liệu cao cấp và chi tiết thiết kế chu đáo. Sự phát hành này mang theo cùng một tiêu chuẩn cao đã làm cho đôi giày đầu tiên A Ma Maniére Jordan 3 trở thành một cổ điển ngay lập tức.</div>
            </div>
          </div>
      </div>
    </div>
  ";
}
?>