<?
  if(!isset(block::$parsed["aside"])) {
    $GLOBALS["people"] = callAPI("get=people&course=1");
  }
  $people = $GLOBALS["people"];
?>
<html>
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
</html>

<style>
.account {
  display: flex;
  flex-direction: row;
  align-items: center;
  padding: 0.75rem;
  box-sizing: border-box;
  border: .1rem solid white;
}
.account:hover {
  border-color: var(--sec);
  border-radius: var(--rad);
  cursor: pointer;
}

.account-photo {
  width: 2.5rem;
  height: 2.5rem;
  border-radius: 50%;
  background: #000;
	text-align: center;
	line-height: 2.5rem;
}

.account-name {
  margin-left: 0.75rem;
}
</style>