<?
function error($msg) {
	echo "<pre>$msg</pre>";
	exit;
}

function loadFile($file, $args=array()) {
  if(count($args)==0) extract($GLOBALS);
  if(!is_array($file)) $file = [$file];
  ob_start();
    foreach($file as $f) include $f;
    $result = ob_get_contents();
  ob_end_clean();
  return $result;
}

class section {
  static $data = [];
  static $key;
  static $files = [];
  static function begin($key) {
    if(!isset(self::$data[$key])) self::$data[$key] = [];
    $ID = __FILE__.$key;
    self::$key = in_array($ID, self::$files) ? null : $key;
    if(self::$key) $files[] = $ID;
    ob_start();
  }
  static function end() {
    if(self::$key) self::$data[self::$key][] = ob_get_contents();
    ob_end_clean();
  }
  static function load($key) {
    return implode(" ", self::$data[$key]);
  }
}

class block {
  static $parsed = [];
  static function __callStatic($block, $args) {
		$file = dirname(__FILE__)."/blocks/$block.php";
	  if(!is_file($file)) error("Missing file $file.");
    if(!$args) $args = [[]];
		$data = loadFile($file, $args[0]);
    preg_match("/<html>(.*)<\/html>/sU", $data, $html);
    if(!isset(self::$parsed[$block])) {
      self::$parsed[$block] = true;
      preg_match("/<style>(.*)<\/style>/sU", $data, $style);
      if(isset($style[1])) section::$data["css"][] = $style[1];
      preg_match("/<script>(.*)<\/script>/sU", $data, $script);
      if(isset($script[1])) section::$data["js"][] = $script[1];
    }
    if(isset($html[1])) return $html[1];
    else return $data;
  }
  static function require($block) {
    self::__callStatic($block,[]); // discard output
  }
  static function isnew($block) {
    return !isset(self::$parsed[$block]);
  }
}

function callAPI($get, $post="") {
	$server = "http://$_SERVER[SERVER_NAME]";
	$request = "$server/api.php?$get";
	// get only alternative idea, if curl is not supported:
	// if(ini_get("allow_url_fopen")=="1") return file_get_contents($request);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $request);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}

function arrAPI($get, $post=array()) {
	callAPI(http_build_query($get), http_build_query($post));
}

?>