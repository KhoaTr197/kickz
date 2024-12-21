<?php
  //Kiem tra file Hinh co phai .jpg
  function isJPG($files) {
    if(gettype($files) == 'array') {
      foreach($files as $file) {
        $check = exif_imagetype($file);

        if($check != IMAGETYPE_JPEG) {
          return false;
        }
      }
    } else {
      $check = exif_imagetype($files);
        
      if($check != IMAGETYPE_JPEG) {
        return false;
      }
    }
    return true;
  }
?>