<?php
  function productList_render() {
    $productCard_html = productCard_render();
    return "
      <div id='product-list' class='col l-10 c-12'>
        <div class='row no-gutter'>
          $productCard_html
          $productCard_html
          $productCard_html
          $productCard_html
          $productCard_html
          $productCard_html
          <div class='showmore c-12'>
            <div class='showmore-btn btn-smooth btn-primary'>
              Xem Thêm
            </div>
          </div>
        </div>
      </div>
    ";
  }
?>