<?php

require_once 'php-activerecord/ActiveRecord.php';

ActiveRecord\Config::initialize(function($cfg)
{
    $cfg->set_model_directory('models');
    $cfg->set_connections(array(
        'development' => 'mysql://root@localhost/hotcopper'));
});

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