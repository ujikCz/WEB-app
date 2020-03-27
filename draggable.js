function draggable(elem){
  var offset = [0,0];
  var isDown = false;
  elem.addEventListener('mousedown', function(e) {
      isDown = true;
      offset = [
          elem.offsetLeft - e.clientX,
          elem.offsetTop - e.clientY
      ];
  }, true);
  document.addEventListener('mouseup', function() {
      isDown = false;
  }, true);

  document.addEventListener('mousemove', function(e) {
      event.preventDefault();
      if (isDown) {
          elem.style.position = "absolute";
          elem.style.left = (e.clientX + offset[0]) + 'px';
          elem.style.top  = (e.clientY + offset[1]) + 'px';
      }
  }, true);
}
