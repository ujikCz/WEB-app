<?
extract($args); // into local context
/*
	id = id člena
	name = jméno člena
	contact = kontaktní údaj člena
	color = barva pozadí
*/
require_once dirname(__FILE__)."/_sharedFunctions.php";
?>
<div class="account" data-id="<?=$id?>">
  <div class="account-photo color<?=$color?>" title="<?=sa($name).";".sa($contact)?>"><?=initials($name)?></div>
  <span class="account-name"><?=$name?></span>
</div>
