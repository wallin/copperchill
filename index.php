<?
set_include_path('./include');

require_once 'setup.php';

$d = array();
$command = array_shift($_PATH);
if(!$command) $command = 'home';

function fb_get_user() {
}


// Render view
function yield() {
  global $command, $d;
  $view = "views/$command.php";
  if((@include $view) != 1) {
    include 'views/404.php';
  }
}

// Check with facebook
$user = $facebook->getUser();
$fbuser = null;
if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $fbuser = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    $fbuser = null;
  }
}

if ($fbuser) {
  // Try to find user in DB. otherwise create
  $d['user'] = R::findOne(TBL_USERS, 'ext_id = ?', array($fbuser[id]));
  if($fbuser[id] && !$d['user']->id) {
    $d['user'] = R::dispense(TBL_USERS);
    $d['user']->import(array(
                             'name' => $fbuser[name],
                             'ext_id' => $fbuser[id],
                             'email' => $fbuser[email],
                             'secret' => md5(time().$fbuser[id])
                             )
                       );
    R::store($d['user']);
  }
}

// Mini "controller"
switch($command) {
case "api":
  require_once 'api.php';
  break;
}

include 'views/layout.php';


?>