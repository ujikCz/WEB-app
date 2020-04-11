async function callAPI(get, post) {
  return new Promise(resolve => {
    var xhr = new XMLHttpRequest();
    xhr.onload = () => resolve(xhr.response);
    xhr.open("POST", `api.php?${get}`);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(post);
  });
}

function initials(name) {
	var letters = name.match(/\s+./gu);
	var result = name[0] + letters.join('').replace(/\s+/g,'');
	return result[0]+result.substr(-1);
}

function draggable(elem, release) {
  var grabX, grabY; // mouse position on elem
	var maxX, maxY; // mouse bounds on parent
  var container = elem.parentNode;
	var handler = elem.getElementsByClassName("move")[0];
	const clamp = (val, min, max) => (val > max ? max : val < min ? min : val);

	var mousemove = function(e) {
		var xpos = clamp(e.clientX-grabX, container.offsetLeft, maxX);
		var ypos = clamp(e.clientY-grabY, container.offsetTop, maxY);
    elem.style.left = `${xpos}px`;
    elem.style.top  = `${ypos}px`;
  }

	var mousedown = function(e) {
		e.preventDefault();
    grabX = e.clientX - elem.offsetLeft;
    grabY = e.clientY - elem.offsetTop;
		maxX = container.offsetWidth - elem.offsetWidth;
		maxY = container.offsetHeight - elem.offsetHeight;
		if(window.prevdrag) window.prevdrag.style.zIndex = '0';
		elem.style.zIndex = '1';
    document.addEventListener('mousemove', mousemove);
		document.addEventListener('mouseup', mouseup);
  }

  var mouseup = function(e) {
		window.prevdrag = elem;
		if(release) release(elem);
    document.removeEventListener('mousemove', mousemove);
		document.removeEventListener('mouseup', mouseup);
	}

	handler.addEventListener('dragstart', e => e.preventDefault());
  handler.addEventListener('mousedown', mousedown);
}

function sizeable(elem, horiz, release) {
  var sup = elem.parentNode;
	const clamp = (val, min, max) => (val > max ? max : val < min ? min : val);

	var mousemove = function(e) {
    var pos = horiz ? (e.clientX - sup.offsetLeft) : (e.clientY - sup.offsetTop);
    const max = horiz ? sup.offsetWidth : sup.offsetHeight;
    pos = clamp(pos, 100, max-100); // pixels
    pos = (100 * pos / max).toFixed(2); // percent
    elem.previousElementSibling.style.flexBasis = `${pos}%`;
  }

  var mousedown = function(e) {
    //e.preventDefault();
    document.addEventListener('mousemove', mousemove);
    document.addEventListener('mouseup', mouseup);
  }

  var mouseup = function(e) {
    if(release) release();
    document.removeEventListener('mousemove', mousemove);
    document.removeEventListener('mouseup', mouseup);
  }

  elem.addEventListener('dragstart', e => e.preventDefault());
  elem.addEventListener('mousedown', mousedown);
}

