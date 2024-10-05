<?php
include 'productCard.php';

function productList_render() {
  $ProductCard = productCard_render();

  return "
    <div id='product-list' class='col l-10 c-12'>
      <div class='row no-gutter'>
        $ProductCard
        $ProductCard
        $ProductCard
        $ProductCard
        $ProductCard
        $ProductCard
        $ProductCard
        $ProductCard
        $ProductCard
        $ProductCard
        $ProductCard
        $ProductCard
        $ProductCard
        $ProductCard
        $ProductCard
        <div class='showmore c-12'>
          <div class='showmore-btn btn'>
            Xem Thêm
          </div>
        </div>
      </div>
    </div>
  ";
}
?>