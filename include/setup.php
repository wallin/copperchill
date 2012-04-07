<?php
define('PRODUCTION', !!strstr($_SERVER['HTTP_HOST'], 'sewa'));

define('TBL_USERS', 'hc_users');
define('TBL_OBSERVATIONS', 'hc_observations');

require_once 'config.php';
require_once 'rb.php';
require_once 'facebook/facebook.php';

$facebook = new Facebook(array(
  'appId'  => $cfg['fb_app'],
  'secret' => $cfg['fb_secret'],
));


R::setup("mysql:host=".$cfg['db_host'].";dbname=".$cfg['db_name'], $cfg['db_user'], $cfg['db_pass']);

// Extract command from URL
$requestURI = explode('?', $_SERVER['REQUEST_URI']);
$requestURI = explode('/', $requestURI[0]);
$scriptName = explode('/',$_SERVER['SCRIPT_NAME']);

for($i= 0;$i < sizeof($scriptName);$i++) {
  if ($requestURI[$i] == $scriptName[$i]) {
    unset($requestURI[$i]);
  }
}
$_PATH = array_values($requestURI);


?>