<?php

require 'handlers.php';

function sendResponse($arr) {
  header('Cache-Control: no-cache, must-revalidate');
  header('Content-type: application/json');
  echo json_encode($arr);
  die();
}

// Handle command
$command = array_shift($_PATH);
$response = Array('status' => 0, 'response' => Array());
try {
  if(array_key_exists($command, $HANDLERS)) {
    $ret = $HANDLERS[$command]();
  }
  else {
    throw new Exception("Invalid command");
  }
  $response['response'] = $ret;
}
catch (Exception $e) {
  $response['status'] = 1;
  $response['error'] = $e->getMessage();
}

sendResponse($response);

?>