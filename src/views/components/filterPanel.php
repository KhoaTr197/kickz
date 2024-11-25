<?php
function filterPanel_render()
{
  
  $priceList_html = filterList_render("price");
  $manufacturerList_html = filterList_render("manufacturer");

  return "
      <div id='filter-panel' class='col l-2 c-12 no-gutter'>
        <div class='filter-panel-wrap'>
          $priceList_html     
        </div>
      </div>
    ";
}
function filterList_render($mode) {
  $newQueryStr = "";
  $priceList = [
    'less-1000000' => 'Dưới 1.000.000đ',
    '1000000-5000000' => 'Từ 1.000.000đ - 5.000.000đ',
    '5000000-10000000' => 'Từ 5.000.000đ - 10.000.000đ',
    'more-10000000' => 'Trên 10.000.000đ'
  ];
  $html = "";

  switch($mode) {
    case 'price':
      foreach($_GET as $key => $value) {
        if($key == 'price') continue;
        $newQueryStr .= "$key=$value&";
      }
      $html .= "
      <ul class='filter-list' id='price'>
        <h3 class='filter-list__title font-medium'>Giá Tiền</h3>
      ";
      foreach ($priceList as $price => $title) {
        $isChecked = (isset($_GET['price']) and $price === $_GET['price']) ? 'checked' : '';
        $html .= "
            <li class='filter-list__item'>
              <label class='checkbox'>
                <div class='checkbox-wrap'>
                  <input type='checkbox' value='price=$price' $isChecked>
                  <span class='checkmark'></span>
                </div>
                <span class='checkbox-label'>$title</span>
              </label>
            </li>
          ";
      }
      $html .= "</ul>";
      break;
  }

  return $html;
}
?>