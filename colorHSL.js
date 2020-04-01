window.addEventListener('DOMContentLoaded', function(event){
  var elem = Array.from(document.querySelectorAll('input[type=range][data-element]'));

  for(var i = 0; i < elem.length; i++){
    var what = document.querySelector(elem[0].dataset.element); //element který bude slider ovlivnovat
    var val = elem[0].value; //defaultní hodnota
    var val_ = elem[1].value; //defaultní hodnota

    elem[0].oninput = function(){
      val = elem[0].value;
      what.style.backgroundColor = 'hsl(' + val + ', 100%, 50%)';
    }
    elem[1].oninput = function(){
      val_ = elem[1].value;
      what.style.color = 'hsl(' + val_ + ', 100%, 50%)';
    }

  }
  
});
