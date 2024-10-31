<?php
  function passwordValidation($pass) {
    $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/";
    return preg_match($pattern, $pass);
  }
?>