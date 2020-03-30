function draggable(elem) {
  var grabX, grabY; // mouse position on elem
	var maxX, maxY; // mouse bounds on parent
  var container = elem.parentNode;
	const clamp = (val, min, max) => (val > max ? max : val < min ? min : val);

	var move = function(e) {
		var xpos = clamp(e.clientX-grabX, container.offsetLeft, maxX);
		var ypos = clamp(e.clientY-grabY, container.offsetTop, maxY);
    elem.style.left = `${xpos}px`;
    elem.style.top  = `${ypos}px`;
  }

	elem.addEventListener('dragstart', e => e.preventDefault());

  elem.addEventListener('mousedown', function(e) {
		e.preventDefault();
    grabX = e.clientX - elem.offsetLeft;
    grabY = e.clientY - elem.offsetTop;
		maxX = container.offsetWidth - elem.offsetWidth;
		maxY = container.offsetHeight - elem.offsetHeight;
    document.addEventListener('mousemove', move);
  });

	document.addEventListener('mouseup', function(e) {
    document.removeEventListener('mousemove', move);
	});
}
