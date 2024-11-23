<?php
  include_once("../views/components/components.php");
  ini_set('max_file_uploads', '200');
  session_start();

  if(!isset($_GET['mode']) || !getForm())
    header("location: index.php?mode=admin-info");

  $header_html = header_render("breadcrumb", false, "index.php?mode={$_GET['mode']}&page=1");

  $formTitle;
  $formInputs;

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
            <form id='importFormAdmin' class="form" action="../controllers/importController.php" method="post" enctype="multipart/form-data">
              <?php 
                echo $error;
                unset($_SESSION['UPLOAD']['PROMPT']);
              ?>
              <h2 class='form-title font-medium'><?php echo $formTitle;?></h2>
              <div class='form-control-wrap'>
                <?php echo $formInputs; ?>
              </div>
              <button class='form-submit-btn btn btn-primary font-medium' name="mode" value=<?php echo $_GET['mode'];?> type='submit'>Thêm</button>
            </form>
          </div>
        </div>
      </div>
    </main>
  </div>
</body>
</html>

<?php

function getForm() {
  global $formTitle, $formInputs;

  switch($_GET['mode']) {
    case 'product':
      $formTitle = 'Thêm Danh Sách Sản Phẩm';
      $formInputs = "
        <div class='form-control'>
          <div class='form-reminder'>Tải file chứa thông tin Danh Sách Sản Phẩm (Chỉ hỗ trợ file CSV)</div>
          <input class='form-input flex-center' type='file' name='data[]'>
          <div class='form-reminder'>Tải file chứa thông tin Danh Sách Phân Loại (Chỉ hỗ trợ file CSV)</div>
          <input class='form-input flex-center' type='file' name='data[]'>
        </div>
      ";
      break;
    case 'size':
      $formTitle = 'Thêm Danh Sách Kích Cỡ & Số Lượng';
      $formInputs = "
        <div class='form-control'>
          <div class='form-reminder'>Tải file chứa thông tin Danh Sách Kích Cỡ & Số Lượng (Chỉ hỗ trợ file CSV)</div>
          <input class='form-input flex-center' type='file' name='data'>
        </div>
      ";
      break;
    case 'category':
      $formTitle = 'Thêm Danh Sách Danh Mục';
      $formInputs = "
        <div class='form-control'>
          <div class='form-reminder'>Tải file chứa thông tin Danh Sách Danh Mục (Chỉ hỗ trợ file CSV)</div>
          <input class='form-input flex-center' type='file' name='data'>
        </div>
      ";
      break;
    case 'manufacturer':
      $formTitle = 'Thêm Danh Sách Hãng';
      $formInputs = "
        <div class='form-control'>
          <div class='form-reminder'>Tải file chứa thông tin Danh Sách Hãng (Chỉ hỗ trợ file CSV)</div>
          <input class='form-input flex-center' type='file' name='data'>
          <div class='form-reminder'>Tải Danh Sách Hình Ảnh Hãng (Chỉ hỗ trợ file JPG, Tối đa 100 file mỗi lượt)</div>
          <div class='form-reminder'>Cần đặt tền file theo đúng định dạng:</div>
          <div class='form-reminder'>+ Hãng: manufacturer-[MAHSX].jpg</div>                        
          <input class='form-input flex-center' type='file' name='image[]' multiple>
        </div>
      ";
      break;
    case 'image':
      $formTitle='Thêm Danh Sách Hình Ảnh';
      $formInputs = "
        <div class='form-control'>
          <div class='form-reminder'>Tải Danh Sách Hình Ảnh (Chỉ hỗ trợ file JPG, Tối đa 100 file mỗi lượt)</div>
          <div class='form-reminder'>Cần đặt tền file theo đúng định dạng:</div>
          <div class='form-reminder'>+ Sản Phẩm: product-[MASP]-[BEN].jpg</div>
          <input class='form-input flex-center' type='file' name='image[]' multiple>
        </div>
      ";
      break;
    default:
      return false;
  }
  return true;
}
?>