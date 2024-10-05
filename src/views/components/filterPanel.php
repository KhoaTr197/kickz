<?php
  function filterPanel_render() {
    return "
      <div id='filter-panel' class='col l-2 c-12 no-gutter'>
        <div class='filter-panel-wrap'>
          <ul class='filter-list' id='brand'>
            <h3 class='filter-list__title'>Nhãn Hàng</h3>
            <li class='filter-list__item'>
              <label class='checkbox'>
                <div class='checkbox-wrap'>
                  <input type='checkbox' name='brand' id='filter-Adidas' value='Adidas'>
                  <span class='checkmark'></span>
                </div>
                <span class='checkbox-label'>Adidas</span>
              </label>
            </li>
            <li class='filter-list__item'>
              <label class='checkbox'>
                <div class='checkbox-wrap'>
                  <input type='checkbox' name='brand' id='filter-Nike' value='Nike'>
                  <span class='checkmark'></span>
                </div>
                <span class='checkbox-label'>Nike</span>
              </label>
            </li>
            <li class='filter-list__item'>
              <label class='checkbox'>
                <div class='checkbox-wrap'>
                  <input type='checkbox' name='brand' id='filter-Converse' value='Converse'>
                  <span class='checkmark'></span>
                </div>
                <span class='checkbox-label'>Converse</span>
              </label>
            </li>
            <li class='filter-list__item'>
              <label class='checkbox'>
                <div class='checkbox-wrap'>
                  <input type='checkbox' name='brand' id='filter-Puma' value='Puma'>
                  <span class='checkmark'></span>
                </div>
                <span class='checkbox-label'>Puma</span>
              </label>
            </li>
          </ul>
          <ul class='filter-list' id='type'>
            <h3 class='filter-list__title'>Loại</h3>
            <li class='filter-list__item'>
              <label class='checkbox'>
                <div class='checkbox-wrap'>
                  <input type='checkbox' name='type[]' id='' value='sport'>
                  <span class='checkmark'></span>
                </div>
                <span class='checkbox-label'>Thể Thao</span>
              </label>
            </li>
            <li class='filter-list__item'>
              <label class='checkbox'>
                <div class='checkbox-wrap'>
                  <input type='checkbox' name='type[]' id='' value='fashion'>
                  <span class='checkmark'></span>
                </div>
                <span class='checkbox-label'>Thời Trang</span>
              </label>
            </li>
            <li class='filter-list__item'>
              <label class='checkbox'>
                <div class='checkbox-wrap'>
                  <input type='checkbox' name='type[]' id='' value='sneaker'>
                  <span class='checkmark'></span>
                </div>
                <span class='checkbox-label'>Sneaker</span>
              </label>
            </li>
          </ul>
          <ul class='filter-list' id='price'>
            <h3 class='filter-list__title'>Giá Tiền</h3>
            <li class='filter-list__item'>
              <label class='checkbox'>
                <div class='checkbox-wrap'>
                  <input type='checkbox' name='price[]' id='' value='less-1000000'>
                  <span class='checkmark'></span>
                </div>
                <span class='checkbox-label'>Dưới 1.000.000đ</span>
              </label>
            </li>
            <li class='filter-list__item'>
              <label class='checkbox'>
                <div class='checkbox-wrap'>
                  <input type='checkbox' name='price[]' id='' value='between-1000000-5000000'>
                  <span class='checkmark'></span>
                </div>
                <span class='checkbox-label'>Từ 1.000.000đ - 5.000.000đ</span>
              </label>
            </li>
            <li class='filter-list__item'>
              <label class='checkbox'>
                <div class='checkbox-wrap'>
                  <input type='checkbox' name='price[]' id='' value='between-5000000-10000000'>
                  <span class='checkmark'></span>
                </div>
                <span class='checkbox-label'>Từ 5.000.000đ - 10.000.000đ</span>
              </label>
            </li>
            <li class='filter-list__item'>
              <label class='checkbox'>
                <div class='checkbox-wrap'>
                  <input type='checkbox' name='price[]' id='' value='more-10000000'>
                  <span class='checkmark'></span>
                </div>
                <span class='checkbox-label'>Trên 10.000.000đ</span>
              </label>
            </li>
          </ul>
        </div>
      </div>
    ";
  }
?>