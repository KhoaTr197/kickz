<?php
  //Kiem tra mat khau hop le
  function passwordValidation($pass) {
    $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
    return preg_match($pattern, $pass);
  }
  //Kiem tra email hop le
  function emailValidation($email) { 
    $pattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/";
    return preg_match( $pattern , $email); 
  }
  //Kiem tra sdt hop le
  function phoneNumberValidation($phoneNumber){
    $pattern = "/^[0-9]{10}+$/";
    return preg_match($pattern, $phoneNumber);
  }
  //Kiem tra Ten Nguoi Dung hop le
  function usernameValidation($username){
    $pattern = "/^[a-zA-Z0-9]{5,}$/";
    return preg_match($pattern, $username);
  }
?>