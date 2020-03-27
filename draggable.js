function draggable(elem){
  var dx, dy;
	var move = function(e) {
    elem.style.left = `${e.clientX+dx}px`;
    elem.style.top  = `${e.clientY+dy}px`;
	}

  elem.addEventListener('mousedown', function(e) {
		e.preventDefault();
    dx = elem.offsetLeft - e.clientX;
    dy = elem.offsetTop - e.clientY;
	  elem.style.position = "absolute";
		move(e);
    document.addEventListener('mousemove', move);
  });

	elem.addEventListener('dragstart', e => e.preventDefault());

	elem.addEventListener('mouseup', function(e) {
    document.removeEventListener('mousemove', move);
	});
}
