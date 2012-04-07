<?

function getUserBySecret($secret) {
  $user = User::find_by_secret($secret);
  if($user) return $user;
  throw new Exception('Invalid key');
}

$HANDLERS = Array();

$HANDLERS['observations'] = function () {
  extract($_REQUEST);
  $user = getUserBySecret($key);

  switch ($_SERVER['REQUEST_METHOD']) {
  case "POST":
    $consumption = intval($consumption);
    if ($consumption) {
      if(!$time) $time = time();
      else $time = strtotime($time);
      if(!$time) throw new Exception("Invalid time");
      $item = array(
                    'consumption' => $consumption,
                    'created_at' => $time,
                    'user_id' => $user->id
                    );
      $c = Observation::create($item);
      $c->save();
      return $item;
    }
    break;
  default:
    if ($from) {
      $from = date(DateTime::ISO8601, $from/1000);
      $conditions = array('user_id = ? AND created_at > ?', $user->id, $from);
    }
    else {
      $conditions = array('user_id = ?', $user->id);
    }
    $options = array(
                     'order' => 'created_at asc',
                     'conditions' => $conditions
                     );
    $o = Observation::find('all', $options);
    $results = Array();
    foreach ($o as $item) { $results[] = $item->to_array(array('except' => array('user_id'))); }
    return $results;
  }
}

?>