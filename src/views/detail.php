<?php 
  include "components/components.php";
      
  $header_html = header_render("breadcrumb");
  $productDetail_html = productDetail_render();
  $footer_html = footer_render();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="public/css/base.css">
  <link rel="stylesheet" href="public/css/grid.css">
  <link rel="stylesheet" href="public/css/main.css">
  <script src="public/js/jquery-3.7.1.min.js"></script>
  <title>Kickz</title>
</head>
<body>
  <div id="app" class="grid">
    <?php 
      echo "
        $header_html
        $productDetail_html
        $footer_html
      ";
    ?>
  </div>
  <script src="../../public/js/app.js"></script>
</body>
</html>