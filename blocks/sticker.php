<?
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
<div class="sticker color<?=$color?>" data-id="<?=$id?>" data-pid="<?=$pid?>" style="left: <?=$x?>%; top: <?=$y?>%">
  <div title="<?=sa($name).";".sa($contact)?>" class="menu">
		<span><?=initials($name)?></span>
	</div>
	<div class="menu move"><i class="fas fa-arrows-alt"></i></div>
  <p class="content"><?=$content?></p>
</div>
