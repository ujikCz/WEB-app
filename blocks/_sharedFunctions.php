<?
function initials($name) {
	preg_match_all("/\b\s*(.)/u",$name,$matches);
	return reset($matches[1]).end($matches[1]);
}

function sa($name) {
	return str_replace('"',"'",$name);
}
?>