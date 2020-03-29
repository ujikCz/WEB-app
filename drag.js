/* podporu telefonu pridam pozdeji */
Element.prototype.drag = function (arg){
 if(arg.enable){
   var dx, dy, xBound, yBound;
   var elem = this;
   if(typeof  arg.inside !== 'undefined'){
     var inside = arg.inside;
     var insideW = inside.offsetWidth - elem.offsetWidth;
     var insideH = inside.offsetHeight - elem.offsetHeight;
   }


   function dragmove(e) {
     e = e || window.event;
     if(typeof arg.inside !== 'undefined'){
     xBound = elem.getBoundingClientRect().left;
     yBound = elem.getBoundingClientRect().top;

     if(xBound > inside.offsetLeft && yBound > inside.offsetTop && xBound < insideW && yBound < insideH){
          elem.style.left = e.clientX + dx + 'px';
          elem.style.top  = e.clientY + dy + 'px';
      } else {
        /* nevím jak doplnit aby se element 'nezamrazil' */
      }
    } else {
      elem.style.left = e.clientX + dx + 'px';
      elem.style.top  = e.clientY + dy + 'px';
    }

   }

   elem.addEventListener('mousedown', function(e) {
     e.preventDefault();
     dx = elem.offsetLeft - e.clientX;
     dy = elem.offsetTop - e.clientY;
     document.addEventListener('mousemove', dragmove);
   });

   elem.addEventListener('mouseup', function(e) {
     document.removeEventListener('mousemove', dragmove);
   });
 }

}
