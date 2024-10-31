$(document).ready(function() {  
  $('#menu').click(function() {
    $("#menu-modal").toggle();
  })

  $('.sidebar__item').click(function() {
    const sidebarItem = this.id.split('_');

    $('.sidebar__item').removeClass('active');
    $(this).addClass('active');

    $(`.user-panel__item`).removeClass('active');
    $(`#${sidebarItem[0]}_modal`).addClass('active');
  })

  $('.quantity-btn__minus').click(function() {
    this.parentNode.querySelector(".quantity-btn__input").stepDown();
  })

  $('.quantity-btn__add').click(function() {
    this.parentNode.querySelector(".quantity-btn__input").stepUp();
  })
})