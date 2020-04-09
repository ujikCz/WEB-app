<?
function error($msg) {
	echo "<pre>$msg</pre>";
	exit;
}

function loadFile($file, $args=array()) {
  if(count($args)==0) extract($GLOBALS);
  ob_start();
    include $file;
    $result = ob_get_contents();
  ob_end_clean();
  return $result;
}

class block {
  static function __callStatic($block, $args) {
		$file = dirname(__FILE__)."/blocks/$block.php";
	  if(!is_file($file)) error("Missing file $file.");
		return loadFile($file, $args[0]);
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