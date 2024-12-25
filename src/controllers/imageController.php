<?php
  //Kiem tra file Hinh co phai .jpg
  function isJPG($files) {
    //Neu la mang
    if(gettype($files) == 'array') {
      foreach($files as $file) {
        $check = exif_imagetype($file);

        if($check != IMAGETYPE_JPEG) {
          return false;
        }
      }
    }
    //Neu la 1 hinh
    else {
      $check = exif_imagetype($files);
        
      if($check != IMAGETYPE_JPEG) {
        return false;
      }
    }
    return true;
  }
?>