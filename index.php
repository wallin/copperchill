<?
set_include_path('include');
require_once 'setup.php';

$command = array_shift($_PATH);
if(!$command) $command = 'home';

// Mini "controller"
switch($command) {
case "api":
  require 'api.php';
  break;
}

// Render view
function yield() {
  global $command;
  $view = "views/$command.php";
  if (file_exists($view)) {
    include $view;
  }
  else {
    include 'views/404.php';
 }
}

include 'views/layout.php';


?>