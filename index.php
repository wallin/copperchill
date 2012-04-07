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
  // TODO: handle users properly with login etc.
  $d['user'] = R::load(TBL_USERS, 1);
  if(!$d['user']->id) {
    $d['user'] = R::dispense(TBL_USERS);
    $d['user']->import(array(
                             'name' => 'Mr. Temp',
                             'email' => 'noone@example.com',
                             'secret' => md5(time())
                             )
                       );
    R::store($d['user']);
  }
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