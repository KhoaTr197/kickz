<?php
  include_once("components/components.php");
  session_start();

  $header_html = header_render("breadcrumb", false, "user.php");

  $error='';

  if(!empty($_SESSION) && !empty($_SESSION['EDIT']['PROMPT'])) {
    $error="<div class='form-error flex rounded'>".$_SESSION['EDIT']['PROMPT']."</div>";
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
      <main class='main'>
        <div class='wide'>
          <div class='row'>
            <div class="col c-o-3 c-6 flex-center">
              <form class='form' id='edit-form' action='../controllers/changePassController.php' method='post'>
                <?php echo $error;?>
                <div class='form-control-wrap'>
                    <h2 class='form-title font-medium'>Đổi Mật Khẩu</h2>
                    <div class='input-group'>
                      <input class='form-input' type='password' placeholder='Mật Khẩu Hiện Tại' name='current_password' />
                      <input class='form-input' type='password' placeholder='Mật Khẩu Mới' name='new_password' />
                      <input class='form-input' type='password' placeholder='Xác Nhận Mật Khẩu' name='confirm_password' />
                      <div class='form-reminder'>Mật khẩu dài ít nhất 8 ký tự, chứa số, chữ cái in hoa, không chứa khoảng trắng, ký tự đặc biệt</div>
                    </div>
                </div>
                <button class='form-submit-btn btn btn-primary' type='submit'>Xác Nhận</button>
              </form>
            </div>
          </div>
        </div>
      </main>
  </div>
  <?php unset($_SESSION['EDIT']['PROMPT']);?>
</body>
</html>