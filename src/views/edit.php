<?php
include_once("../views/components/components.php");
session_start();

if (!isset($_GET['mode']) || !getForm())
  header("location: user.php");

$header_html = header_render("breadcrumb", false, "user.php");

$formTitle;
$formInputs;
$queryStr = urldecode($_SERVER['QUERY_STRING']);

$error = '';

if (!empty($_SESSION) && !empty($_SESSION['EDIT']['PROMPT']['MSG'])) {
  $error = "<div class='form-error flex rounded'>" . $_SESSION['EDIT']['PROMPT']['MSG'] . "</div>";
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
    <?php echo $header_html; ?>
    <main class='main'>
      <div class='wide'>
        <div class='row'>
          <div class="col c-o-3 c-6 flex-center">
            <form class='form' id='edit-form' action='../controllers/editController.php' method='post'>
              <input name="queryStr" value=<?php echo $queryStr ?> hidden />
              <?php
              echo $error;
              unset($_SESSION['EDIT']['PROMPT']);
              ?>
              <h2 class='form-title font-medium'><?php echo $formTitle; ?></h2>
              <div class='form-control-wrap'>
                <?php echo $formInputs; ?>
              </div>
              <button class='form-submit-btn btn btn-primary' type='submit' name="mode" value=<?php echo $_GET['mode']; ?>>Xác Nhận</button>
            </form>
          </div>
        </div>
      </div>
    </main>
  </div>
</body>

</html>

<?php
function getForm()
{
  global $formTitle, $formInputs;

  switch ($_GET['mode']) {
    case 'info':
      $formTitle = 'Sửa Thông Tin Cá Nhân';
      $formInputs = "
        <div class='form-control'>
          <input class='form-input' type='text' placeholder='Tên Tài Khoản' name='username' value={$_SESSION['USER']['INFO']['TENTK']} readonly/>
          <input class='form-input' type='text' placeholder='Họ Tên' name='fullname' value='{$_SESSION['USER']['INFO']['HOTEN']}' />
          <input class='form-input' type='email' placeholder='Email' name='email' value={$_SESSION['USER']['INFO']['EMAIL']} />
          <input class='form-input' type='tel' placeholder='Số Điện Thoại' name='phone' value={$_SESSION['USER']['INFO']['SDT']} />
          <input class='form-input' type='text' placeholder='Địa Chỉ' name='address' value='{$_SESSION['USER']['INFO']['DCHI']}' />
        </div>
      ";
      break;
    case 'password':
      $formTitle = 'Đổi Mật Khẩu';
      $formInputs = "
        <div class='form-control'>
          <input class='form-input' type='password' placeholder='Mật Khẩu Hiện Tại' name='currentPassword' />
          <input class='form-input' type='password' placeholder='Mật Khẩu Mới' name='newPassword' />
          <input class='form-input' type='password' placeholder='Xác Nhận Mật Khẩu' name='confirmPassword' />
          <div class='form-reminder'>Mật khẩu dài ít nhất 8 ký tự, chứa số, chữ cái in hoa, không chứa khoảng trắng, ký tự đặc biệt</div>
        </div>
      ";
      break;
    default:
      return false;
  }
  return true;
}
?>