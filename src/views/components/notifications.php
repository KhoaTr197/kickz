<?php
function notify($key, $path = '../../public/img')
{
  if (!isset($_SESSION[$key]['PROMPT']) || empty($_SESSION[$key]['PROMPT'])) {
    return '';
  }

  $notification = $_SESSION[$key]['PROMPT'];
  unset($_SESSION[$key]);

  $class = "";
  $icon = "";
  $html = "";

  switch ($notification['TYPE']) {
    case 'success':
      $class = "notification--success";
      $icon = "<img src='$path/success_icon.svg' />";
      break;
    case 'error':
      $class = "notification--error";
      $icon = "<img src='$path/error_icon.svg' />";
      break;
    case 'warning':
      $class = "notification--warning";
      $icon = "<img src='$path/warning_icon.svg' />";
      break;
    default:
      break;
  }

  $html = "
      <div class='notification $class rounded flex flex-center'>
        $icon
        <span>{$notification['MSG']}</span>
      </div>
    ";

  return $html;
}
