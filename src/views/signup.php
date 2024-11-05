<?php
  include_once("components/components.php");
  session_start();

  $header_html = header_render("login");
  $error='';

  if(!empty($_SESSION) && !empty($_SESSION['SIGNUP']['ERROR_PROMPT'])) {
    $error="<div class='form-error flex rounded'>".$_SESSION['SIGNUP']['ERROR_PROMPT']."</div>";
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
  <title>Kickz</title>
</head>
<body>
  <?php echo $header_html; ?>
      <main class='main'>
        <div class='wide'>
          <div class='row'>
            <div class='col c-12 flex-center'>
              <form class='form' action='../controllers/signupController.php' method='post'>
                <?php
                  echo $error;
                  unset($_SESSION['SIGNUP']['ERROR_PROMPT']);
                ?>
                <div class='form-control-wrap'>
                  <h2 class='form-title font-medium'>Đăng Ký</h2>
                  <div class='input-group'>
                    <input class='form-input' type='text' placeholder='Tên Tài Khoản' name='username'/>
                    <input class='form-input' type='text' placeholder='Họ Tên' name='fullname'/>
                    <input class='form-input' type='email' placeholder='Email' name='email'/>
                    <input class='form-input' type='tel' placeholder='Số Điện Thoại' name='phone'/>
                    <input class='form-input' type='password' placeholder='Mật Khẩu' name='password'/>
                    <input class='form-input' type='password' placeholder='Xác Nhận Mật Khẩu' name='confirm_password'/>
                    <div class='form-reminder'>Mật khẩu dài ít nhất 8 ký tự, chứa số, chữ cái in hoa, không chứa khoảng trắng, ký tự đặc biệt</div>
                  </div>
                  </div>                  
                <button class='form-submit-btn btn btn-primary' type='submit'>Đăng Ký</button>
                <div class='other-cta-container'>
                  <span>Đã có tài khoản?</span>
                  <a class='other-cta__link' href='login.php'>Đăng Nhập</a>
                </div>
              </form>

            </div> 
          </div>
        </div>
      </main>
</body>
</html>