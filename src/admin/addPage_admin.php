<?php
  include_once("../views/components/components.php");
  session_start();

  $header_html = header_render("breadcrumb", false, "index.php");
  $error='';

  if(!empty($_SESSION) && !empty($_SESSION['UPLOAD']['PROMPT'])) {
    $error="<div class='form-error flex rounded'>".$_SESSION['UPLOAD']['PROMPT']."</div>";
  }
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
  <script src="../../public/js/jquery-3.7.1.min.js"></script>
  <script src="../../public/js/app.js"></script>
  <title>Kickz</title>
</head>
<body>
  <div id="app" class="grid">
    <?php echo $header_html;?>
    <main class='main' id="admin">
      <div class='wide'>
        <div class='row'>
          <div class="col c-12 flex-center">
            <form class="form" action="add_admin.php" method="post" enctype="multipart/form-data">
              <?php 
                echo $error;
                unset($_SESSION['LOGIN']['ERROR_PROMPT']);
              ?>
              <h2 class='form-title font-medium'>Thêm Sản Phẩm</h2>
              <div class='form-control-wrap'>
                <div class="form-control">
                  <h3 class='form-title font-medium'>Thông Tin Sản Phẩm</h3>
                  <input class='form-input' type='text' placeholder='Tên Sản Phẩm' name='name' value='Converse Chuck Norris' />
                  <input class='form-input' type='number' placeholder='Giá Tiền' name='price' value='1990000'/>
                  <input class='form-input' type='number' placeholder='Khuyến Mãi' name='discount' value='0' />
                  <textarea class='form-input' type='text' placeholder='Mô Tả Chi Tiết' name='description'>Edgy this week, sporty next. Ten years from now? TBD. No matter how (or when) your style changes, you can always come back to the classic. The original Chuck Taylor All Star—an icon for every era.</textarea>
                  <select class='form-input' name="manufacturer">
                    <option value="" disabled selected hidden>-- Chọn Hãng --</option>
                    <option value="Nike">Nike</option>
                    <option value="Adidas">Adidas</option>
                    <option value="Converse" selected>Converse</option>
                    <option value="Reebok">Reebok</option>
                  </select>
                  <input class='form-input flex-center' type="file" name="image[]" id='image' multiple>
                </div>
                <div class="form-control">
                  <h3 class='form-title font-medium'>Kích Cỡ & Số Lượng</h3>
                  <div class="size-list">
                  <div class="size-option flex">
                    <label for="size-34">Size 34:</label>
                    <input class='size-option__input form-input' type="number" id="size-34" name='size-34' min="0" value="12">
                    <button class="size-option__delete-btn" type="button">
                      <img src="../../public/img/trashcan_icon.svg">
                    </button>
                  </div>
                  <div class="size-option flex">
                    <label for="size-35">Size 35:</label>
                    <input class='size-option__input form-input' type="number" id="size-35" name='size-35' min="0" value="24">
                    <button class="size-option__delete-btn" type="button">
                      <img src="../../public/img/trashcan_icon.svg">
                    </button>
                  </div>
                  <div class="size-option flex">
                    <label for="size-36">Size 36:</label>
                    <input class='size-option__input form-input' type="number" id="size-36" name='size-36' min="0" value="21">
                    <button class="size-option__delete-btn" type="button">
                      <img src="../../public/img/trashcan_icon.svg">
                    </button>
                  </div>
                  </div>
                  <div class="add-size flex">
                    <input class='add-size__input form-input' type="number" min="32" max="43">
                    <button class='add-size__btn btn btn-primary font-medium'type="button">Thêm Size</button>
                  </div>
                </div>
              </div>
              <button class='form-submit-btn btn btn-primary font-medium' type='submit'>Thêm</button>
            </form>
          </div>
        </div>
      </div>
    </main>
  </div>
</body>
</html>