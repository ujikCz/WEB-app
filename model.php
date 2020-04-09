<?
function hm($str) {
  $items = explode(':',$str,2);
  if(count($items)<2) return 0;
  return 60*(int)$items[0]+(int)$items[1];
}
function m2t($m) {
  $mm = (int)($m%60);
  if($mm<10) $mm = '0'.$mm;
  return (int)($m/60).':'.$mm;
}
if(!function_exists("error")) {
	function error($msg) {
		echo "<pre>$msg</pre>";
		exit;
	}
}

class Model extends SQLite3 {

  function select($query, $values="", $keys="") {
    $return = array();
    $result = $this->query($query);
    if($result===false) {
      error("Query <b>$query</b> failed.");
      return $return;
    }
    $from = array();
    $i = 0;
    while($row=$result->fetchArray(SQLITE3_ASSOC)) {
      if($values && !$from) $from = array_map(function($v) { return ":$v"; }, array_keys($row));
      $to = array_values($row);
      $key = $keys ? str_replace($from, $to, $keys) : $i++;
      $return[$key] = $values ? str_replace($from, $to, $values) : $row;
      $first = false;
    }
    return $return;
  }

  function format($type, $var) {
		switch($type) {
			case "i":
			case "d":	return (int)$var;
	    case "f":	return (float)$var;
			case "%": return "%";
	    case "s": return "'".SQLite3::escapeString($var)."'";
			default: error("unknown parsing type $type"); break;
		}
  }

	private $args = array();
	function buildQuery($query) {
		$this->args = func_get_args();
		array_shift($this->args);
		$callback = function($m) { return $this->format($m[1], array_shift($this->args)); };
		return preg_replace_callback("/%([^%])/", $callback, $query);
	}

	function execQuery($query) {
		$args = func_get_args();
		$query = call_user_func_array(array($this, "buildQuery"), $args);
		$this->exec($query);
	}

	function selectQuery($query) {
		$args = func_get_args();
		$query = call_user_func_array(array($this, "buildQuery"), $args);
		return $this->select($query);
	}

	function queryValue($query) {
  	$args = func_get_args();
		$query = call_user_func_array(array($this, "buildQuery"), $args);
		return $this->querySingle($query);
	}

  function __construct($db) {
		$this->open($db);
    $this->createFunction('hm','hm');
    $this->createFunction('m2t','m2t');
  }
  function __destruct() {
    $this->close();
  }
}
$MODEL = new Model("data.db3");
?>