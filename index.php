<?
  define("GLOBAL", 1);
	session_start();
	require_once "framework.php";
	require_once "model.php";

  ob_start();
    include "controller.php";
    $HTML = ob_get_contents();
  ob_end_clean();
?>
<!DOCTYPE html>
<meta charset="utf-8">
<title>LMS</title>
<script src="https://kit.fontawesome.com/65fbab6bff.js" crossorigin="anonymous"></script>
<style><?echo loadFile(["reset.css","index.css","button.css"]); echo section::load("css")?></style>
<script><?echo loadFile("index.js"); echo section::load("js")?></script>
<?=$HTML?>