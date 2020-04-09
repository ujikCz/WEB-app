<?
extract($args); // into local context
/*
  people id;name;contact;role;color
  role
*/
require_once dirname(__FILE__)."/_sharedFunctions.php";

foreach(explode("\n", $people) as $line) {
	$data = explode(";", $line);
	if(count($data)<=1) continue;
  if($data[3]!=$role) continue;
	echo block::accountItem(array(
		"id" => $data[0],
		"name" => $data[1],
		"contact" => $data[2],
		"color" => $data[4],
	));
}
?>