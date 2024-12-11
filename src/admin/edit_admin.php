<?php
  require_once("../models/Database.php");
  include_once("../views/components/components.php");
  session_start();
  if(!isset($_GET['mode']) || !getForm())
    header("location: index.php?mode=admin-info");

  if($_GET['mode'] === 'admin-password' || $_GET['mode'] === 'admin-info')
    $header_html = header_render("breadcrumb", false, "index.php?mode=admin-info");
  else
    $header_html = header_render("breadcrumb", false, "index.php?mode={$_GET['mode']}&page={$_GET['page']}");

  $formTitle;
  $formInputs;
  $queryStr = urldecode($_SERVER['QUERY_STRING']);
 
  $error='';


  if(!empty($_SESSION) && !empty($_SESSION['EDIT']['PROMPT']['MSG'])) {
    $error="<div class='form-error flex rounded'>".$_SESSION['EDIT']['PROMPT']['MSG']."</div>";
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
              <form class='form' id='edit-form' action='../controllers/editController.php' method='post' enctype="multipart/form-data">
                <input name="queryStr" value=<?php echo $queryStr?> hidden />
                <?php 
                  echo $error;
                  unset($_SESSION['EDIT']['PROMPT']);
                ?>
                <h2 class='form-title font-medium'><?php echo $formTitle;?></h2>
                <div class='form-control-wrap'>
                  <?php echo $formInputs; ?>
                </div>
                <button class='form-submit-btn btn btn-primary' type='submit' name="mode" value=<?php echo $_GET['mode']; ?> >Xác Nhận</button>
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

  $db = new Database;

  switch($_GET['mode']) {
    case 'admin-info':
      $formTitle = 'Sửa Thông Tin';
      $formInputs = "
        <div class='form-control'>
          <input name='id' value={$_SESSION['ADMIN']['INFO']['MAQTV']} hidden/>
          <input class='form-input' type='text' placeholder='Tên Tài Khoản' name='username' value='{$_SESSION['ADMIN']['INFO']['TENTK']}' />
        </div>
      ";
      break;
    case 'admin-password':
      $formTitle = 'Đổi Mật Khẩu';
      $formInputs = "
        <div class='form-control'>
          <input name='id' value={$_SESSION['ADMIN']['INFO']['MAQTV']} hidden/>
          <input class='form-input' type='password' placeholder='Mật Khẩu Hiện Tại' name='currentPassword' />
          <input class='form-input' type='password' placeholder='Mật Khẩu Mới' name='newPassword' />
          <input class='form-input' type='password' placeholder='Xác Nhận Mật Khẩu' name='confirmPassword' />
          <div class='form-reminder'>Mật khẩu dài ít nhất 8 ký tự, chứa số, chữ cái in hoa, không chứa khoảng trắng, ký tự đặc biệt</div>
        </div>
      ";
      break;
    case "product":
      $productSQL="
        select SANPHAM.*, HANGSANXUAT.MAHSX, GROUP_CONCAT(DANHMUC.MADM SEPARATOR ', ') as DANHMUC
        from SANPHAM
        inner join HANGSANXUAT
        on SANPHAM.MAHSX = HANGSANXUAT.MAHSX
        left join PHANLOAI
        on SANPHAM.MASP = PHANLOAI.MASP
        left join DANHMUC
        on PHANLOAI.MADM = DANHMUC.MADM
        where SANPHAM.MASP = {$_GET['id']}
        group by SANPHAM.MASP
      ";
      $manufactureSQL="select MAHSX, TENHSX from HANGSANXUAT";
      $categorySQL="select MADM, TENDM from DANHMUC";
  
      $productData=$db->fetch($db->query($productSQL));
      $manufactureInputs="";
      $categoryInputs="";
      
      $result = $db->query($manufactureSQL);

      while($row = $db->fetch($result)) {
        $isSelected = $productData['MAHSX'] == $row['MAHSX'] ? 'selected' : '';
        $manufactureInputs .= "<option value='{$row['MAHSX']}' $isSelected>{$row['TENHSX']}</option>";
      }

      $result = $db->query($categorySQL);

      while($row = $db->fetch($result)) {
        $isChecked = str_contains($productData['DANHMUC'], $row['MADM']) ? 'checked' : '';
        $categoryInputs .= "
          <label class='category-list__item checkbox'>
            <div class='checkbox-wrap'>
              <input type='checkbox' name='category[]' value='{$row['MADM']}' $isChecked>
              <span class='checkmark'></span>
            </div>
            <span class='checkbox-label'>{$row['TENDM']}</span>
          </label>
        ";
      }

      $formTitle = 'Sửa Thông Tin Sản Phẩm';
      $formInputs = "
        <div class='form-control'>
          <h3 class='form-title font-medium'>Thông Tin Sản Phẩm</h3>
          <input class='form-input' name='id' value='{$productData['MASP']}' hidden/>
          <input class='form-input' type='text' placeholder='Tên Sản Phẩm' name='name' value='{$productData['TENSP']}' required/>
          <input class='form-input' type='number' min=0 placeholder='Giá Tiền' name='price' value='{$productData['GIA']}'/>
          <input class='form-input' type='number' min=0 max=100 placeholder='Khuyến Mãi' name='discount' value='{$productData['KHUYENMAI']}'/>
          <textarea class='form-input' type='text' placeholder='Mô Tả Chi Tiết' name='description'>{$productData['MOTA']}</textarea>
          <input class='form-input' type='number' min='0' max='5' placeholder='Đánh Giá' name='rating' value='{$productData['SOSAO']}'/>
          <input class='form-input' type='date' placeholder='Ngày Sản Xuất' name='date' value='{$productData['NGSX']}'/>
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
      $manufacturerSQL = "select * from HANGSANXUAT where MAHSX = {$_GET['id']}";
      $manufacturerData = $db->fetch($db->query($manufacturerSQL));
      $imageData = base64_encode($manufacturerData['LOGO']);

      $formTitle = 'Sửa Thông Tin Hãng';
      $formInputs = "
        <div class='form-control'>
          <input name='id' value={$manufacturerData['MAHSX']} hidden/>
          <input class='form-input' type='text' placeholder='Tên Hãng' name='name' value={$manufacturerData['TENHSX']} required/>
          <div class='preview'>
            <h4>Hình ảnh hiện tại</h4>
            <img src='data:image/jpeg;base64,$imageData'>
          </div>
          <div class='form-reminder'>Tải Hình Ảnh Hãng (Chỉ hỗ trợ file JPG)</div>
          <div class='form-reminder'>Cần đặt tền file theo đúng định dạng:</div>
          <div class='form-reminder'>+ Hãng: manufacturer-[MAHSX].jpg</div>
          <input class='form-input flex-center' type='file' name='image' required>
        </div>
      ";
      break;
    case "category":
      $categorySQL = "select * from DANHMUC where MADM = {$_GET['id']}";
      $categoryData = $db->fetch($db->query($categorySQL));


      $formTitle = 'Sửa Thông Tin Danh Mục';
      $formInputs = "
        <div class='form-control'>
          <input name='id' value={$_GET['id']} hidden/>
          <input class='form-input' type='text' placeholder='Tên Danh Mục' name='name' value={$categoryData['TENDM']} required/>
        </div>
      ";
      break;
    case "size":
      $sizeSQL = "select * from KICHCO where MASP = {$_GET['productId']} and MAKC = {$_GET['id']}";
      $sizeData = $db->fetch($db->query($sizeSQL));

      $formTitle = 'Sửa Thông Tin Kích Cỡ & Số Lượng';
      $formInputs = "
        <div class='form-control'>
          <input class='form-input' type='number' placeholder='Mã Sản Phẩm' name='id' value={$sizeData['MAKC']} hidden/>
          <input class='form-input' type='number' placeholder='Mã Sản Phẩm' name='productId' value={$sizeData['MASP']} readonly/>
          <input class='form-input' type='number' placeholder='Kích Cỡ' name='size' min=34 max=43 value={$sizeData['COGIAY']} readonly/>
          <input class='form-input' type='number' placeholder='Số Lượng' name='quantity' min=0 value={$sizeData['SOLUONG']} required/>
        </div>
      ";
      break;
    case "image":
      $imageSQL = "select * from HINHANH where MASP = {$_GET['productId']} and MAHA = {$_GET['id']}";
      $imageData = $db->fetch($db->query($imageSQL));
      $image = base64_encode($imageData['FILE']);

      $formTitle = 'Sửa Hình Ảnh';
      $formInputs = "
        <div class='form-control'>
          <input name='id' value='{$imageData['MAHA']}' hidden>
          <input name='productId' value='{$imageData['MASP']}' hidden>
          <div class='preview'>
            <h4>Hình ảnh hiện tại</h4>
            <img src='data:image/jpeg;base64,$image'>
          </div>
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