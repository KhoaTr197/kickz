<?php
//Gui noi dung thong bao loi
function errorPrompt($prompt, $msg, $redirect)
{
  $_SESSION[$prompt]['PROMPT'] = [
    'TYPE' => 'error',
    'MSG' => $msg
  ];
  header("location: $redirect");
  session_write_close();
}
//Gui noi dung thong bao thanh cong
function successPrompt($prompt, $msg, $redirect)
{
  $_SESSION[$prompt]['PROMPT'] = [
    'TYPE' => 'success',
    'MSG' => $msg
  ];
  header("location: $redirect");
  session_write_close();
}
//Gui noi dung thong bao cảnh báo
function warningPrompt($prompt, $msg, $redirect)
{
  $_SESSION[$prompt]['PROMPT'] = [
    'TYPE' => 'warning',
    'MSG' => $msg
  ];
  header("location: $redirect");
  session_write_close();
}
