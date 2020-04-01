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
/*
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width maximum-scale=1 minimum-scale=1" />
<script src="box.js" charset="utf-8"></script>
<script src="colors.js" charset="utf-8"></script>
<style media="screen">
.modal {
z-index: 5;
padding-top: 100px;
width: 100%;
height: 100%;
background-color: transparent; /* background mimo modal */
}
#colors{
  width: 50%;
  height: 100%;
}

.modal-content {
border: 1px solid #888;
background-color: white; /* modal background */
}

.close {
/* style of modal close span */
}
.slidecontainer {
  width: 100%;
}

.slider {
  -webkit-appearance: none;
  width: 100%;
  height: 25px;
  background: #d3d3d3;
  outline: none;
  opacity: 0.7;
  -webkit-transition: .2s;
  transition: opacity .2s;
}

.slider:hover {
  opacity: 1;
}

.slider::-webkit-slider-thumb {
  -webkit-appearance: none;
  appearance: none;
  width: 25px;
  height: 25px;
  background: #4CAF50;
  cursor: pointer;
}

.slider::-moz-range-thumb {
  width: 25px;
  height: 25px;
  background: #4CAF50;
  cursor: pointer;
}

</style>
</head>
<body>


<div class="" id="x" style="height:300px; width:300px; float:right; border:1px black solid;">
  <center>
  <p>hellohellohellohellohello</p><br>
  <p>hellohellohellohellohello</p><br>
  <p>hellohellohellohellohello</p><br>
  <p>hellohellohellohellohello</p>
</center>
</div>

  <div id="colors" class="modal" data-btn="x">
      <input type="range" data-element="#x" min="1" max="359" value="1" class="slider" id="myRange">
      <input type="range" data-element="#x" min="1" max="359" value="1" class="slider" id="myRange">
  </div>



</body>
</html>
*/
