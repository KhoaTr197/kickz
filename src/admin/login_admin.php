<?php
  include_once("../views/components/components.php");
  session_start();

  $header_html = header_render("login");

  //Chứng Thực
  if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST)) {
    $_SESSION['ADMIN'] = [];
    require_once("../models/Database.php");
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $db = new Database();
    $sql = "
      select *
      from QUANTRIVIEN
      where TENTK = '$username' and
            MATKHAU = '$password'
    ";
    $result = $db->fetch($db->query($sql));

    if($result>0) {
      $_SESSION['ADMIN'] += [
        'HAS_LOGON' => true,
        'INFO' => $result
      ];
      header('location: index.php');
    }
    else {
      $_SESSION['ADMIN'] = [
        'LOGIN_ERROR_PROMPT' => 'Thông Tin Đăng Nhập Không Chính Xác'
      ];
    }
  }

  $error='';

  if(!empty($_SESSION) && !empty($_SESSION['ADMIN']['LOGIN_ERROR_PROMPT'] )) {
    $error="<div class='form-error flex rounded'>".$_SESSION['ADMIN']['LOGIN_ERROR_PROMPT']."</div>";
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
  <?php echo $header_html; ?>
      <main class='main'>
        <div class='wide'>
          <div class='row'>
            <div class='c-12 flex-center'>
                <form class='form'action='login_admin.php' method='post'>
                  <?php echo $error;?>
                  <div class='form-control-wrap'>
                    <h2 class='form-title font-medium'>Đăng Nhập Quản Trị Viên</h2>
                    <div class='form-control'>
                      <input class='form-input' type='text' placeholder='Tên Tài Khoản' name='username'/>
                      <input class='form-input' type='password' placeholder='Mật Khẩu' name='password'/>
                    </div>
                   </div>
                  <button class='form-submit-btn btn btn-primary' type='submit'>Đăng Nhập</button>
                </form>       
              </div>
            </div> 
          </div>
        </div>
      </main>
  <?php unset($_SESSION['ADMIN']['LOGIN_ERROR_PROMPT']);?>
</body>
</html>