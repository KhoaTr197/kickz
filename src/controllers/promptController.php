<?php
function errorPrompt($prompt, $msg, $redirect)
{
  $_SESSION[$prompt]['PROMPT'] = [
    'TYPE' => 'error',
    'MSG' => $msg
  ];
  header("location: $redirect");
  session_write_close();
}
function successPrompt($prompt, $msg, $redirect)
{
  $_SESSION[$prompt]['PROMPT'] = [
    'TYPE' => 'success',
    'MSG' => $msg
  ];
  header("location: $redirect");
  session_write_close();
}
function warningPrompt($prompt, $msg, $redirect)
{
  $_SESSION[$prompt]['PROMPT'] = [
    'TYPE' => 'warning',
    'MSG' => $msg
  ];
  header("location: $redirect");
  session_write_close();
}
