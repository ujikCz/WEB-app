<?
// PHP
extract($args); // into local context
/*
	id = id lepítka
  pid = id autora
	x, y = pozice lepítka
	content = obsah lepítka
	name = jméno autora
	contact = kontakt na autora
	color = barva lepítka
*/
require_once dirname(__FILE__)."/_sharedFunctions.php";
?>
<html>
<div class="sticker color<?=$color?>" data-id="<?=$id?>" data-pid="<?=$pid?>" style="left: <?=$x?>%; top: <?=$y?>%">
  <div title="<?=sa($name).";".sa($contact)?>" class="menu">
		<span><?=initials($name)?></span>
	</div>
	<div class="menu move"><i class="fas fa-arrows-alt"></i></div>
  <p class="content"><?=$content?></p>
</div>
</html>

<style>
.sticker {
  min-width: 15rem;
  border-radius: var(--rad);
  background-color: hsl(51, 35%, 90%);
	position: absolute;
	padding: 0.25rem;
}
.sticker .move:hover {
  cursor: grab;
}
.sticker .move:active {
  cursor: grabbing;
}
.sticker .menu span {
	cursor: default;
}

.sticker .menu {
	float: right;
  width: 2.5em;
  height: 2.5em;
	border-radius: 2.5em;
	line-height: 2.5em;
	text-align: center;
	margin-left: 0.25rem;
  background: rgba(0,0,0,.20);
}


.sticker .content {
  padding: 0 .25rem;
  margin-bottom: .25rem;
}
</style>

<script>
var stickers = new function() {
  var whiteboard;

  document.addEventListener("DOMContentLoaded", function() {
    whiteboard = document.getElementsByClassName("whiteboard")[0];

    Array.from(document.getElementsByClassName("sticker")).forEach(function(elem) {
      if(elem.dataset.pid==userID) draggable(elem, saveStickerPos);
    });
  });

  async function saveStickerPos(elem) {
    const x = (100.0 * elem.offsetLeft / whiteboard.offsetWidth).toFixed(2);
    const y = (100.0 * elem.offsetTop / whiteboard.offsetHeight).toFixed(2);
    await callAPI(`set=sticker&sticker=${elem.dataset.id}`, `x=${x}&y=${y}`);
  }
}
</script>