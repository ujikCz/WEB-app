<?
	session_start();
	require_once "framework.php";
	require_once "model.php";
  require_once "client/loader.php";
  $people = callAPI("get=people&course=1");
?>
<!DOCTYPE html>
<meta charset="utf-8">
<title>LMS</title>
<style><?loadClient("css")?></style>
<script><?loadClient("js")?></script>
<script src="https://kit.fontawesome.com/65fbab6bff.js" crossorigin="anonymous"></script>

<div class="whiteboard">
<div class="board main"></div>
<?$stickers = callAPI("get=stickers,authors&course=1");
	foreach(explode("\n", $stickers) as $line) {
		$data = explode(";", $line);
		if(count($data)<=1) continue;
		echo block::sticker(array(
			"id" => $data[0],
      "pid" => $data[1],
			"name" => $data[2],
			"contact" => $data[3],
			"x" => $data[4],
			"y" => $data[5],
			"color" => $data[6],
			"content" => $data[7],
		));
	}?>
</div>
<aside>
  <header>
    <button class="button primary dark">Nové lepítko</button>
    <div class="account-photo profile"></div>
  </header>
  <div class="account-list">
    <h2 class="list-heading">Učitelé</h2>
    <?=block::accountList(array("people"=>$people,"role"=>"t"))?>
  </div>
  <div class="account-list">
    <h2 class="list-heading">Studenti</h2>
    <?=block::accountList(array("people"=>$people,"role"=>"s"))?>
  </div>
</aside>

<script type="text/javascript">
// just for test
const userID = 2;
async function login() {
  //const data = await callAPI("login","login=jan&password=hello");
  await callAPI("login","login=dc&password=bar");
}
login();
// end of test

// context menu
contextMenu.define({
  "board": {
    "Rozdělit horizontálně": separators.splitAndSaveH,
    "Rozdělit vertikálně": separators.splitAndSaveV,
  },
  "sep": {
    "Odstranit příčku": separators.removeSplit,
  }
});
</script>
