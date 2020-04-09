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
