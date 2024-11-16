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
?>