<?
set_include_path('./include');

require_once 'setup.php';

$command = array_shift($_PATH);
if(!$command) $command = 'home';

// Mini "controller"
$d = array();
switch($command) {
case "api":
  require 'api.php';
  break;
case "home":
  $d['user'] = R::load('hc_users', 1);
  break;
}

// Render view
function yield() {
  global $command, $d;
  $view = "views/$command.php";
  if((@include $view) != 1) {
    include 'views/404.php';
  }

}

include 'views/layout.php';


?>