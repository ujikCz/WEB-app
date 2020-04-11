<style>
#context-menu li {
	border: 1px solid #AAA;
	color: #777;
	background: #FFF;
	padding: 0.5rem;
	cursor: default;
}

#context-menu li:first-child {
	border-top-left-radius: var(--rad);
	border-top-right-radius: var(--rad);
}
#context-menu li:last-child {
	border-bottom-left-radius: var(--rad);
	border-bottom-right-radius: var(--rad);
}
#context-menu li:not(:first-child) {
	border-top: none;
}

#context-menu li:hover {
  background: var(--prim-dark);
  color: var(--pri-light);
}
</style>

<script>
/*
  menudata = { class: {name: handler}}
*/
var contextMenu = new function() {
	var cm;
  var menudata = {};

  this.define = md => menudata = md;
  this.add = (key,md) => menudata[key] = md;

  document.addEventListener("DOMContentLoaded", function(e) {
    cm = document.createElement("ul");
    cm.id = "context-menu";
    with(cm.style) {
      position = "absolute";
      zIndex = "10";
      flexDirection = "column";
      alignItems = "stretch";
    }
    document.documentElement.appendChild(cm);
  });

	function addItem(target, text, handler) {
		var li = document.createElement('li');
		li.onmousedown = () => handler(target);
		li.innerHTML = text;
		cm.appendChild(li);
	}

	document.addEventListener('contextmenu', function(e) {
    var menu = Object.keys(menudata).find( o => e.target.classList.contains(o) );
    if(!menu) return;
    menu = menudata[menu];
		e.preventDefault();
    for(let i in menu) addItem(e.target, i, menu[i]);
		cm.style.top = e.clientY + 'px';
		cm.style.left = e.clientX + 'px';
		cm.style.display = 'flex';
	});

	document.addEventListener('mousedown', function(e) {
		cm.style.display = 'none';
		cm.innerHTML = '';
	});
}
</script>