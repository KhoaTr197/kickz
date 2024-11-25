$(document).ready(function() {  
  $('#menu').click(function() {
    $("#menu-modal").toggle();
  })

  $('.filter-list__item input').click(function(e) {
    e.stopPropagation();

    const url = new URL(window.location.href);
    const queryStr = $(this).val().split("=");

    if(url.searchParams.has(queryStr[0])) {
      url.searchParams.delete(queryStr[0]);
      console.log(url.toString());
      if($(this)[0].checked)
        url.searchParams.append(queryStr[0], queryStr[1]);
    } else {
      url.searchParams.append(queryStr[0], queryStr[1]);
    }
    
    window.location.href = url.toString();
  })
  
  $('.carousel-gallery__img').click(function() {
    $(this).siblings().removeClass('active');
    $(this).addClass('active');
    $('.carousel-preview__img')[0].src = `${$(this)[0].src}`;
  })

  $('.size-item').click(function() {
    $(this).siblings().removeClass('active');
    $(this).addClass('active');
    console.log($('.detail-panel input[name=size]').val($(this).val()));
  })

  $('.sidebar__item').click(function() {
    const sidebarItem = this.id.split('_');

    $('.sidebar__item').removeClass('active');
    $(this).addClass('active');

    $(`.user-panel__item`).removeClass('active');
    $(`#${sidebarItem[0]}_modal`).addClass('active');
  })

  $('.quantity-btn__minus').click(function() {
    let element = $(this).siblings('.quantity-btn__input')[0];
    element.stepDown();
    element.dispatchEvent(new Event('change'));
  })

  $('.quantity-btn__add').click(function() {
    let element = $(this).siblings('.quantity-btn__input')[0];
    element.stepUp();
    element.dispatchEvent(new Event('change'));
  })

  $(document).on('click', '.size-option__delete-btn', function() {
    $(this).parent().remove();
  })

  $('.gallery-list__item').hover(
    function() {
      $(this).find('.gallery-list-item__action-btn').show();
    },
    function() {
      $(this).find('.gallery-list-item__action-btn').hide();
    },
  )
})

