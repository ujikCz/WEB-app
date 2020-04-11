<?
define("UNAUTHORIZED", -1);
define("INVALID_DATA", -2);

session_start();
header("Content-Type: text/plain;charset=UTF-8");
require_once "model.php";

function getVar($arr, $var) {
	if(!isset($arr[$var])) return null;
	return $arr[$var];
}
function GET($var) { return getVar($_GET, $var); }
function POST($var) { return getVar($_POST, $var); }
function SESS($var) { return getVar($_SESSION, $var); }

/**
	login
	GET: login
	POST: login=str, password=str
	RESPONSE: id;login;name;contact (0 if login failed)
*/
if(isset($_GET["login"])) {
	$login=POST("login");
	$pass = md5(POST("password"));
	$data = $MODEL->selectQuery("SELECT rowid,name,contact FROM people WHERE login=%s AND password=%s", $login, $pass);
	$data = getVar($data, 0);
	if(!$data) unset($_SESSION["login"]);
	else {
		$_SESSION["login"] = array("id"=>$data["rowid"], "login"=>$login, "name"=>$data["name"], "contact"=>$data["contact"]);
		$_SESSION["ID"] = $data["rowid"];
	}
	if($user=SESS("login")) printf("%d;%s;%s;%s", $user["id"], $user["login"], $user["name"], $user["contact"]);
	else print(0);
}

/**
	logout
	GET: logout
	POST:
	RESPONSE: undefined
*/
else if(isset($_GET["logout"])) {
	unset($_SESSION["login"]);
	unset($_SESSION["id"]);
}

/**
	get user info
	GET: get=user
	POST:
	RESPONSE: id;name;contact (0 if not logged in)
*/
else if(GET("get")=="user") {
	if($user=SESS("login")) printf("%d;%s;%s", $user["id"], $user["name"], $user["contact"]);
	else print(0);
}

/**
  get course info
  GET: get=course, course=int
  POST:
  RESPONSE: name;panels
*/
else if(GET("get")=="course" and $courseID=GET("course")) {
  $sql = $MODEL->buildQuery("SELECT name,panels FROM courses WHERE rowid=%d", $courseID);
  $data = $MODEL->select($sql,":name;:panels\n");
  foreach($data as $row) print($row);
}

/**
	list courses of school
	GET: get=courses, school=int
	POST:
	RESPONSE: csv: id;courseName
*/
else if(GET("get")=="courses" and $schoolID=GET("school")) {
	$sql = $MODEL->buildQuery("SELECT rowid,name FROM courses WHERE schoolID=%d", $schoolID);
	$data = $MODEL->select($sql,":rowid;:name\n");
	foreach($data as $name) print($name);
}

/**
	list stickers of course
	GET: get=stickers, course=int
	POST:
	RESPONSE: csv: stickerID;authorID;x;y;color;contents
*/
else if(GET("get")=="stickers" and $courseID=GET("course")) {
	$sql = $MODEL->buildQuery("
		SELECT s.rowid sid,s.*,p.rowid pid,e.color FROM stickers s
		JOIN people p ON p.rowid=s.peopleID
		JOIN enroll e ON e.courseID=s.courseID AND e.peopleID=p.rowid
		WHERE s.courseID=%d", $courseID);
	$data = $MODEL->select($sql,":sid;:pid;:x;:y;:color;:contents\n");
	foreach($data as $row) print($row);
}

/**
	list stickers (including their authors) of course
	GET: get=stickers,authors, course=int
	POST:
	RESPONSE: csv: stickerID;authorID;authorName;authorContact;x;y;color;contents
*/
else if(GET("get")=="stickers,authors" and $courseID=GET("course")) {
	$sql = $MODEL->buildQuery("
		SELECT s.rowid sid,s.*,p.rowid pid,p.*,e.color FROM stickers s
		JOIN people p ON p.rowid=s.peopleID
		JOIN enroll e ON e.courseID=s.courseID AND e.peopleID=p.rowid
		WHERE s.courseID=%d", $courseID);
	$data = $MODEL->select($sql,":sid;:pid;:name;:contact;:x;:y;:color;:contents\n");
	foreach($data as $row) print($row);
}

/**
	list stickers of author
	GET: get=stickers, person=int
	POST:
	RESPONSE: csv: id;x;y;contents
*/
else if(GET("get")=="stickers" and $peopleID=GET("person")) {
	$sql = $MODEL->buildQuery("SELECT rowid,* FROM stickers WHERE peopleID=%d", $peopleID);
	$data = $MODEL->select($sql, ":rowid;:x;:y;:contents\n");
	foreach($data as $row) print($row);
}

/**
	list people of course
	GET: get=people, course=int
	POST:
	RESPONSE: csv: id;name;contact;role;color
*/
else if(GET("get")=="people" and $courseID=GET("course")) {
	$sql = $MODEL->buildQuery("
		SELECT p.rowid,p.name,p.contact,
      CASE WHEN e.role=1 THEN 's' ELSE 't' END role,
      e.color FROM enroll e
		JOIN people p ON p.rowid=e.peopleID AND e.courseID=%d
	", $courseID, $courseID);
	$data = $MODEL->select($sql,":rowid;:name;:contact;:role;:color\n");
	foreach($data as $row) print($row);
}

/**
	add a sticker (must be logged in)
	GET: add=stickers, course=int
	POST: x=float, y=float, data=str
	RESPONSE: int (id of the new sticker, -1 if unauthorized, not logged in, -2 if missing data)
*/
else if(GET("add")=="sticker" and $courseID=GET("course")) {
	if(!SESS("ID")) print(UNAUTHORIZED);
  else if(!$MODEL->queryValue("SELECT color FROM colors WHERE peopleID=%d AND courseID=%d", SESS("ID"), $courseID)) print(UNAUTHORIZED);
	else if(!($x=POST("x") and $y=POST("y") and $data=POST("data"))) print(INVALID_DATA);
	else {
		$MODEL->execQuery("INSERT INTO stickers (courseID, peopleID, x, y, contents) VALUES(%d, %d, %f, %f, %s)", $courseID, SESS("ID"), $x, $y, $data);
		print($MODEL->lastInsertRowID());
	}
}

/**
	set sticker (must be logged in)
	GET: set=sticker, sticker=int
	POST: x=float, y=float OR data=str
	RESPONSE: int (-1 if unauthorized, 1 if OK)
*/
else if(GET("set")=="sticker" and $stickerID=GET("sticker")) {
	if(!SESS("ID")) print(UNAUTHORIZED);
	else if(!$MODEL->queryValue("SELECT rowid FROM stickers WHERE rowid=%d AND peopleID=%d", $stickerID, SESS("ID"))) print(UNAUTHORIZED);
	else {
		$x=POST("x"); $y=POST("y"); $data=POST("data");
		if($x || $y) $MODEL->execQuery("UPDATE stickers SET x=%f, y=%f WHERE rowid=%d", $x, $y, $stickerID);
		if($data) $MODEL->execQuery("UPDATE stickers SET contents=%s WHERE rowid=%d", $data, $stickerID);
		print(1);
	}
}

/**
	add a user
	GET: add=user
	POST: name=str, contact=str, password=str
	RESPONSE: int (id of newly created user)
*/
else if(GET("add")=="user") {
  $name=POST("name"); $contact=POST("contact"); $pass=POST("password");
	if($name) $MODEL->execQuery("INSERT INTO people (name, contact, password) VALUES (%s, %s, %s)", $name, $contact, md5($pass));
	print($MODEL->lastInsertRowID());
}

/**
	set currently logged user
	GET: set=user
	POST: name=str OR contact=str OR password=str (empty field remain unchanged)
	RESPONSE: int (-1 if unauthorized, 1 if OK)
*/
else if(GET("set")=="user") {
	$valid = true;
	if(!SESS("ID")) $valid = false;
	$check = $MODEL->queryValue("SELECT rowid FROM people WHERE rowid=%d", SESS("ID"));
	if(!$check) $valid = false;
	if(!$valid) print(UNAUTHORIZED);
	else {
	  $name=POST("name"); $contact=POST("contact"); $pass=POST("password");
		if($name) $MODEL->execQuery("UPDATE people SET name=%s WHERE rowid=%d", $name, $peopleID);
		if($contact) $MODEL->execQuery("UPDATE people SET contact=%s WHERE rowid=%d", $contact, $peopleID);
		if($pass) $MODEL->execQuery("UPDATE people SET password=%s WHERE rowid=%d", md5($pass), $peopleID);
		print(1);
	}
}

/**
	enroll currently logged user into a course
	GET: set=color, course=int, color=int
	POST:
	RESPONSE: int (-1 if unauthorized, 1 if OK)
*/
else if(GET("set")=="color" and $courseID=GET("course")) {
	if(!SESS("ID")) print(UNAUTHORIZED);
  else if(!$color=GET("color")) print(INVALID_DATA);
	else {
		$MODEL->execQuery("INSERT INTO colors (peopleID, courseID, color) VALUES (%d, %d, %d)", SESS("ID"), $courseID, $color);
		print(1);
	}
}

/**
  set course separators
  GET: set=course, course=int
  POST: panels=JSON OR name=str
  RESPONSE: int (-1 if unauthorized, 1 if OK)
*/
else if(GET("set")=="course" and $courseID=GET("course")) {
	if(!SESS("ID")) print(UNAUTHORIZED);
  else if(2!=$MODEL->queryValue("SELECT role FROM enroll WHERE courseID=%d AND peopleID=%d", $courseID, SESS("ID"))) print(UNAUTHORIZED);
	else {
	  $panels=POST("panels"); $name=POST("name");
		if($name) $MODEL->execQuery("UPDATE courses SET name=%s WHERE rowid=%d", $name, $courseID);
		if($panels) $MODEL->execQuery("UPDATE courses SET panels=%s WHERE rowid=%d", $panels, $courseID);
		print(1);
	}
}

/**
	delete own sticker (must be logged in)
	GET: del=int
	POST:
	RESPONSE: int (-1 if unauthorized, 1 if OK)
*/
else if(GET("del")=="sticker" and $stickerID=GET("sticker")) {
	if(!SESS("ID")) print(UNAUTHORIZED);
	else if(!$MODEL->queryValue("SELECT rowid FROM stickers WHERE rowid=%d AND peopleID=%d", $stickerID, SESS("ID"))) print(UNAUTHORIZED);
	else {
		$MODEL->execQuery("DELETE FROM stickers WHERE rowid=%d", $stickerID);
		print(1);
	}
}
?>