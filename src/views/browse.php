<?php
  require_once("../models/Database.php");
  include_once("components/components.php");
  session_start();

  $header_html = header_render("navbar", isset($_SESSION['LOGIN']['HAS_LOGON']) ? $_SESSION['LOGIN']['HAS_LOGON'] : false);
  $filterPanel = filterPanel_render();
  $footer_html = footer_render();

  $db = new Database();
  $sql = "
      select *
      from product
    ";
  $result = $db->query($sql);
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
            <div class='row' id="browse">
              <?php echo $filterPanel; ?>
              <div id='product-list' class='col l-10 c-12'>
                <div class='row no-gutter'>
                  <?php
                    while ($row = $db->fetch($result)) {
                      echo productCard_render($row);
                    }
                  ?>
                </div>
              </div>
            </div>
          </div>
        </main>
    <?php echo $footer_html; ?>
  </div>
</body>
</html>