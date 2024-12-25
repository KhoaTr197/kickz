<?php
  include_once("../views/components/components.php");
  require_once("../models/Database.php");
  session_start();

  //Kiem tra mode va Lay code HTML Edit Form
  if(!isset($_GET['mode']) || !getForm())
    header("location: index.php?mode=admin-info");

  $header_html = header_render("breadcrumb", false, "index.php?mode={$_GET['mode']}&page=1");

  $formTitle;
  $formInputs;

  $error='';

<<<<<<< HEAD
  print_r($_SESSION['UPLOAD']);

  if(!empty($_SESSION) && !empty($_SESSION['UPLOAD']['PROMPT']['MSG'])) {
    $error="<div class='form-error flex rounded'>".$_SESSION['UPLOAD']['PROMPT']['MSG']."</div>";
=======
  //Tao code HTML khi co loi
  if(!empty($_SESSION) && !empty($_SESSION['UPLOAD']['PROMPT'])) {
    $error="<div class='form-error flex rounded'>".$_SESSION['UPLOAD']['PROMPT']."</div>";
>>>>>>> origin/main
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
            <form class="form" action="../controllers/insertController.php" method="post" enctype="multipart/form-data">
              <?php 
                echo $error;
                unset($_SESSION['UPLOAD']['PROMPT']);
              ?>
              <h2 class='form-title font-medium'><?php echo $formTitle;?></h2>
              <div class='form-control-wrap'>
                <?php echo $formInputs; ?>
              </div>
              <button class='form-submit-btn btn btn-primary font-medium' type='submit' name="mode" value=<?php echo $_GET['mode']; ?> >Thêm</button>
            </form>
          </div>
        </div>
      </div>
    </main>
  </div>
</body>
</html>

<?php
//Lay Form theo mode
function getForm() {
  global $formTitle, $formInputs;

  switch($_GET['mode']) {
    case "product":
      $db= new Database;

      $manufactureSQL="select MAHSX, TENHSX from HANGSANXUAT";
      $categorySQL="select MADM, TENDM from DANHMUC";

      $manufactureInputs="";
      $categoryInputs="";

      $result = $db->query($manufactureSQL);

      while($row = $db->fetch($result)) {
        $manufactureInputs .= "<option value='{$row['MAHSX']}'>{$row['TENHSX']}</option>";
      }

      $result = $db->query($categorySQL);

      while($row = $db->fetch($result)) {
        $categoryInputs .= "
          <label class='category-list__item checkbox'>
            <div class='checkbox-wrap'>
              <input type='checkbox' name='category[]' value='{$row['MADM']}'>
              <span class='checkmark'></span>
            </div>
            <span class='checkbox-label'>{$row['TENDM']}</span>
          </label>
        ";
      }

      $formTitle="Thêm Sản Phẩm";
      $formInputs = "
        <div class='form-control'>
          <h3 class='form-title font-medium'>Thông Tin Sản Phẩm</h3>
          <input class='form-input' type='text' placeholder='Tên Sản Phẩm' name='name' required/>
          <input class='form-input' type='number' placeholder='Giá Tiền' name='price' required/>
          <input class='form-input' type='number' placeholder='Khuyến Mãi' name='discount' />
          <textarea class='form-input' type='text' placeholder='Mô Tả Chi Tiết' name='description'></textarea>
          <input class='form-input' type='number' min='0' max='5' placeholder='Đánh Giá' name='rating' />
          <input class='form-input' type='date' placeholder='Ngày Sản Xuất' name='date'/>
          <select class='form-input' name='manufacturer' required>
            <option  disabled selected hidden>-- Chọn Hãng --</option>
            $manufactureInputs
          </select>
        </div>
        <div class='form-control'>
          <h3 class='form-title font-medium'>Danh Mục</h3>
          <div class='category-list'>
            $categoryInputs
          </div>
        </div>
      ";
      break;
    case "manufacturer":
      $formTitle="Thêm Hãng";
      $formInputs="
        <div class='form-control'>
          <input class='form-input' type='text' placeholder='Tên Hãng' name='name' required/>
          <div class='form-reminder'>Tải Hình Ảnh Hãng (Chỉ hỗ trợ file JPG)</div>
          <div class='form-reminder'>Cần đặt tền file theo đúng định dạng:</div>
          <div class='form-reminder'>+ Hãng: manufacturer-[MAHSX].jpg</div>
          <input class='form-input flex-center' type='file' name='image' required>
        </div>";
      break;
    case "category":
      $formTitle="Thêm Danh Mục";
      $formInputs="
        <div class='form-control'>
          <input class='form-input' type='text' placeholder='Tên Danh Mục' name='name' required/>
        </div>";
      break;
    case "size":
      $formTitle="Thêm Kích Cỡ & Số Lượng";
      $formInputs="
        <div class='form-control'>
          <input class='form-input' type='number' placeholder='Mã Sản Phẩm' name='id' required/>
          <input class='form-input' type='number' placeholder='Kích Cỡ' name='size' min=34 max=43 required/>
          <input class='form-input' type='number' placeholder='Số Lượng' name='quantity' min=0 required/>
        </div>
      ";
      break;
    case "image":
      $formTitle="Thêm Hình Ảnh";
      $formInputs="
        <div class='form-control'>
          <div class='form-reminder'>Tải Hình Ảnh (Chỉ hỗ trợ file JPG)</div>
          <div class='form-reminder'>Cần đặt tền file theo đúng định dạng:</div>
          <div class='form-reminder'>+ Sản Phẩm: product-[MASP]-[BEN].jpg</div>
          <input class='form-input flex-center' type='file' name='image' required>
        </div>
      ";
      break;
    default:
      return false;
  }
  return true;
}

?>