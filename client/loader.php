<?
  function loadClient($type) {
    $result = [];
    if($type=="js") $result = array("index.js", "js/stickers.js", "js/separators.js");
    if($type=="css") $result = array("reset.css", "index.css", "css/board.css", "css/sticker.css", "css/account.css", "css/button.css", "css/contextMenu.css");

    foreach($result as $file) {
      $data = file_get_contents("client/$file");
//      $data = preg_replace("/\/\*(.*)\*\//sU", '', $data);
//      $data = preg_replace("/\s+/s", ' ', $data);
      echo $data;
    }
  }
?>
