<?php
function errorPrompt($prompt, $msg, $redirect) {
  $_SESSION[$prompt]['PROMPT'] = $msg;
  header("location: $redirect");
}
function successPrompt($prompt, $msg, $redirect) {
  $_SESSION[$prompt]['PROMPT'] = "Đã xảy ra lỗi, vui lòng thử lại sau!";
  header("location: $redirect");
}
?>