/* podporu telefonu pridam pozdeji */

function draggable(arg){
  var dx, dy, xBound, yBound;
  var elem = arg.element;
  if(typeof  arg.inside !== 'undefined'){
    var inside = arg.inside;
    var insideW = inside.offsetWidth - elem.offsetWidth;
    var insideH = inside.offsetHeight - elem.offsetHeight;
  }

	var move = function(e) {
    e = e || window.event;
    if(typeof arg.inside !== 'undefined'){
    xBound = elem.getBoundingClientRect().left;
    yBound = elem.getBoundingClientRect().top;

    if(xBound > inside.offsetLeft && yBound > inside.offsetTop && xBound < insideW && yBound < insideH){
      elem.style.left = `${e.clientX+dx}px`;
      elem.style.top  = `${e.clientY+dy}px`;
     } else {
       /* nevím jak doplnit aby se element 'nezamrazil' */
     }
   } else { //pokud není inside element specifikován
     elem.style.left = `${e.clientX+dx}px`;
     elem.style.top  = `${e.clientY+dy}px`;
   }

	}

  elem.addEventListener('mousedown', function(e) {
		e.preventDefault();
    dx = elem.offsetLeft - e.clientX;
    dy = elem.offsetTop - e.clientY;
		move(e);
    document.addEventListener('mousemove', move);
  });

	elem.addEventListener('dragstart', e => e.preventDefault());

	elem.addEventListener('mouseup', function(e) {
    document.removeEventListener('mousemove', move);
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
