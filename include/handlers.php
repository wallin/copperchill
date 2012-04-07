<?php

function getUserBySecret($secret) {
  $user = R::findOne(TBL_USERS, 'secret = ?', array($secret));
  if($user->id) return $user;
  throw new Exception('Invalid key');
}


$HANDLERS = Array();

function handleObservations() {
  extract($_REQUEST);
  $user = getUserBySecret($key);
  switch ($_SERVER['REQUEST_METHOD']) {
  case "POST":
    $consumption = intval($consumption);
    if ($consumption) {
      if(!$time) $time = time();
      else $time = strtotime($time);
      if(!$time) throw new Exception("Invalid time");
      $item = R::dispense(TBL_OBSERVATIONS);
      $item->import(array(
                          'consumption' => $consumption,
                          'created_at' => date(DateTime::ISO8601, $time),
                          'user_id' => $user->id
                          )
                    );
      R::store($item);
      return $item->export();
    }
    throw new Exception('Invalid consumption');
    break;
  default:
    $from = $from ? date(DateTime::ISO8601, $from/1000) : 0;
    $o = R::find(TBL_OBSERVATIONS, 'user_id = ? AND created_at > ? ORDER BY created_at ASC', array($user->id, $from));
    $results = Array();
    foreach ($o as $item) {
      $arr = $item->export();
      // FIXME: How to format date correctly with ReadBean?
      $arr['created_at'] = date(DateTime::ISO8601, strtotime($arr['created_at']));
      $results[] = $arr;
    }
    return $results;
  }
};

$HANDLERS['observations'] = handleObservations;

?>