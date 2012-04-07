<?php

require_once 'rb.php';

R::setup('mysql:host=localhost;dbname=hotcopper','root');

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