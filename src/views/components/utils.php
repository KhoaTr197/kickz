<?php
  function formatPrice($price) {
    $newPrice = number_format($price, 0, '', '.');
    return "$newPrice"."đ";
  }
?>