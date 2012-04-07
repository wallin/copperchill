<?
set_include_path('./include');

require_once 'setup.php';

$command = array_shift($_PATH);
if(!$command) $command = 'home';

// Mini "controller"
$d = array();
switch($command) {
case "api":
  require_once 'api.php';
  break;
case "home":
  // Check with facebook
  $user = fb_get_user();
  if ($user) {
    $d['logoutUrl'] = $facebook->getLogoutUrl();
  } else {
    $d['loginUrl'] = $facebook->getLoginUrl();
    break;
  }

  // Try to find user in DB. otherwise create
  $d['user'] = R::findOne(TBL_USERS, 'ext_id = ?', array($user[id]));
  if($user[id] && !$d['user']->id) {
    $d['user'] = R::dispense(TBL_USERS);
    $d['user']->import(array(
                             'name' => $user[name],
                             'ext_id' => $user[id],
                             'secret' => md5(time().$user[id])
                             )
                       );
    R::store($d['user']);
  }
  break;
}

function fb_get_user() {
  global $facebook;
  $user = $facebook->getUser();
  $user_profile = null;
  if ($user) {
    try {
      // Proceed knowing you have a logged in user who's authenticated.
      $user_profile = $facebook->api('/me');
    } catch (FacebookApiException $e) {
    }
  }
  return $user_profile;
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