<?php
  require_once("../models/Database.php");
  include_once("components/components.php");
  session_start();

  $header_html = header_render("breadcrumb", false, "user.php");
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
              <form class='form' id='edit-form' action='../controllers/editInfoController.php' method='post'>
                <div class='form-control-wrap'>
                    <h2 class='form-title font-medium'>Sửa Thông Tin Cá Nhân</h2>
                    <div class='input-group'>
                      <input class='form-input' type='text' placeholder='Tên Tài Khoản' name='username' value="<?php echo $_SESSION['LOGIN']['INFO']["username"];?>" />
                      <input class='form-input' type='text' placeholder='Họ Tên' name='fullname' value="<?php echo $_SESSION['LOGIN']['INFO']["fullname"];?>" />
                      <input class='form-input' type='email' placeholder='Email' name='email' value="<?php echo $_SESSION['LOGIN']['INFO']["email"];?>" />
                      <input class='form-input' type='tel' placeholder='Số Điện Thoại' name='phone' value="<?php echo $_SESSION['LOGIN']['INFO']["phone"];?>" />

                    </div>
                </div>
                <button class='form-submit-btn btn btn-primary' type='submit'>Xác Nhận</button>
              </form>
            </div>
          </div>
        </div>
      </main>
  </div>
</body>
</html>