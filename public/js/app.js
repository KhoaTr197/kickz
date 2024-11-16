$(document).ready(function() {  
  $('#menu').click(function() {
    $("#menu-modal").toggle();
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

  $('#admin .add-size__btn').click(function() {
    const size = $('#admin .add-size__input')[0].value;

    if(size<34 || size>43) return alert("Giá trị phải từ 34 đến 43!");
    if($(`#size-${size}`).length > 0) return alert("Giá trị không được trùng!");

    let element = `
      <div class="size-option flex">
        <label for="size-${size}">Size ${size}:</label>
        <input class='size-option__input form-input' type="number" id="size-${size}" name='size-${size}' min="0" value="0">
        <button class="size-option__delete-btn" type="button">
          <img src="../../public/img/trashcan_icon.svg">
        </button>
      </div>
    `

    $('#admin .size-list').append(element);
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

