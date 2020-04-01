function colorChange(arg){
  var elem = document.querySelector(arg.trigger);
  var target = typeof arg.target === 'undefined' ? elem : document.querySelector(arg.target);
  var bg = typeof arg.background === 'undefined' ? '' : arg.background;
  var color = typeof arg.color === 'undefined' ? '' : arg.color;
  var event = arg.event;
  console.log(elem);

  elem.addEventListener(event, function(e){
      target.style.backgroundColor = bg;
      target.style.color = color;
  });

}

/*
<div class="" id="x" style="height:300px; width:300px; border:1px black solid;">

</div>

<input type="button" id="btn">


<script type="text/javascript">
window.addEventListener('DOMContentLoaded', function(event){

colorChange({
  trigger: '#btn',
  target: '#x',
  event: 'click',
  background: 'black'
});

});
</script>
*/
