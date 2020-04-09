<!DOCTYPE html>
<meta charset="UTF-8">
<title>API Reference</title>
<style>
	body { font: 16px sans-serif; color: #000; }
</style>
<h1>LMS ŠkolaZdola API reference</h1>
<?
  $code = file_get_contents("api.php");
  preg_match_all("/\/\*\*(.*)\*\//sU", $code, $doc);
  $doc = $doc[1];
  foreach($doc as $block) {
    $lines = explode("\n", $block);
    $lines = array_map("trim", $lines);
    if(!$lines[0]) array_shift($lines);
    $title = array_shift($lines);
    echo "<h2>$title</h2>";
    foreach($lines as $line) {
      if(!$line) continue;
      $parts = explode(":", $line, 2);
      echo "<b>$parts[0]</b> $parts[1]<br>";
    }
  }
?>
