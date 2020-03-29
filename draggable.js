/* podporu telefonu pridam pozdeji */

function bound(x, minX, maxX) {
	if(x<minX) return minX;
	if(x>maxX) return maxX;
	return x;
}

function draggable(elem){
  var dx, dy, xBound, yBound;
  var inside = elem.parentNode;
  var insideW = inside.offsetWidth - elem.offsetWidth;
  var insideH = inside.offsetHeight - elem.offsetHeight;
	var moving = false;

	var move = function(e) {
    xBound = elem.getBoundingClientRect().left;
    yBound = elem.getBoundingClientRect().top;
		var xpos = bound(e.clientX+dx, inside.offsetLeft, insideW);
		var ypos = bound(e.clientY+dy, inside.offsetTop, insideH);
    elem.style.left = `${xpos}px`;
    elem.style.top  = `${ypos}px`;
   }


  elem.addEventListener('mousedown', function(e) {
		e.preventDefault();
    dx = elem.offsetLeft - e.clientX;
    dy = elem.offsetTop - e.clientY;
		move(e);
    document.addEventListener('mousemove', move);
		moving = true;
  });

	elem.addEventListener('dragstart', e => e.preventDefault());

	document.addEventListener('mouseup', function(e) {
    if(moving) document.removeEventListener('mousemove', move);
	});
}
/*
v index.html např.:

<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width maximum-scale=1 minimum-scale=1" />
<script src="draggable.js" charset="utf-8"></script>

</head>
<body>
  <div class="" id="y" style="border:2px black solid; width:500px; height:300px;">
  <div style="position: absolute;" id="x">hello world</div>
  </div>

<script type="text/javascript">

draggable({
  element: document.getElementById('x'),
  inside: document.getElementById('y')
});

</script>
</body>
</html>


*/
