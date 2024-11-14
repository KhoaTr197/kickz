<?php
  function checkImages($arrayImg) {
    foreach($arrayImg as $i => $name) {
      $check = exif_imagetype($arrayImg[$i]);
      if($check != IMAGETYPE_JPEG) {
        return false;
      }
    }
    return true;
  }
  function insertImages($db, $arrayImg) {
    global $db;

    foreach($arrayImg['tmp_name'] as $i => $name) {
      $filename = explode('-', substr($arrayImg['name'][$i], 0, -4));
      $file = $arrayImg["tmp_name"][$i];
      $image = file_get_contents($file);

      $idx=[
        'right' => 1,
        'front' => 2,
        'left' => 3,
        'back' => 4
      ];
      $id = (int)$filename[1];
      $imageSQL = "";
      $stmt = null;

      switch($filename[0]) {
        case 'product':
          $imageSQL = "
            insert ignore into HINHANH (MASP, MAHA, URL)
            values(?, ?, ?)
          ";
          $stmt = $db->prepare($imageSQL);
          mysqli_stmt_bind_param($stmt, 'iis', $id, $idx[$filename[2]], $image);
          $db->stmt_execute($stmt);
          break;
        case 'manufacturer':
          $imageSQL = "
            update HANGSANXUAT
            set LOGO = ?
            where MAHSX = ? 
          ";
          echo $imageSQL;
          $stmt = $db->prepare($imageSQL);
          mysqli_stmt_bind_param($stmt, 'si', $image, $id);
          $db->stmt_execute($stmt);
          break;
      }

      header("location: index.php");
      
    }
  }
?>