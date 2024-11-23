<?php
  function passwordValidation($pass) {
    $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/";
    return preg_match($pattern, $pass);
  }
  function emailValidation($email) { 
    $pattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^/";
    return preg_match( $pattern , $email); 
  } 
  function phoneNumberValidation($phoneNumber){
    $pattern = "/^[0-9]{10}+$/";
    return preg_match($pattern, $phoneNumber);
  }
  function usernameValidation($username){
    $pattern = "/^[a-zA-Z0-9]{5,}$/";
    return preg_match($pattern, $username);
  }
?>