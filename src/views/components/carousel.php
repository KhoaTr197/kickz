<?php
function carousel_render() {
  return "
    <div class='carousel col c-7' id='carousel'>
      <div class='carousel__preview flex-center'>
        <img src='public/img/shoe-right-side-test.png'>
      </div>
      <div class='carousel__gallery flex-center'>
        <img class='active' src='public/img/shoe-right-side-test.png' width='128' height='96'>
        <img src='public/img/shoe-right-side-test.png'>
        <img src='public/img/shoe-right-side-test.png'>
        <img src='public/img/shoe-right-side-test.png'>
      </div>
    </div>
  ";
}
?>
