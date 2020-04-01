window.addEventListener('DOMContentLoaded', function(event){
  Array.from(document.querySelectorAll('input[type=range][data-element]')).forEach(function(elem) {
    var what = document.querySelector(elem.dataset.element); //element který bude slider ovlivnovat
    var val = elem.value; //defaultní hodnota


    var background_color = ['black', 'white', 'silver', '#FEE715FF', '#101820FF', 'orange', 'aqua', 'blue', 'navy', 'lime', 'green',
                            '#DF6589FF', '#3C1053FF', '#E94B3CFF', '#2D2926FF', '#A07855FF', '#D4B996FF', '#0063B2FF', '#9CC3D5FF'];

    var color = ['grey', 'black', 'navy', '#101820FF', '#FEE715FF', 'black', 'black', 'white', 'aqua', 'navy', 'black',
                 '#3C1053FF', '#DF6589FF', '#2D2926FF', '#E94B3CFF', '#D4B996FF', '#A07855FF', '#9CC3D5FF', '#0063B2FF'];


    elem.oninput = function(){
      val = elem.value;
      what.style.backgroundColor = background_color[val];
      what.style.color = color[val];
    }

  });

});

/*
HTML použití: 

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
background-color: transparent;
}
#colors{
  width: 50%;
  height: 100%;
}

.modal-content {
border: 1px solid #888;
background-color: white; 
}

.close {
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
      <input type="range" data-element="#x" min="1" max="19" value="1" class="slider" id="myRange">
  </div>



</body>
</html>
*/
