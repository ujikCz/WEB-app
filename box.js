window.addEventListener('DOMContentLoaded', function(event){

/* všechny objekty který mají atributy v selectoru */
Array.from(document.querySelectorAll('div.modal[data-btn]')).forEach(function(modal) {
  var btn = document.getElementById(modal.dataset.btn);

  btn.onclick = function(){
    modal.style.display = 'block';
  }

  var val = modal.innerHTML;
  modal.innerHTML = `
  <div class="modal-content" style="margin:auto; padding:20px; width:80%;">
    <span class="close" style="float: right; font-size: 28px; cursor: pointer;" onclick="this.parentNode.parentNode.style.display = 'none';">&times;</span>
    ${val}
    </div>
  `;

  modal.style.cssText = "display:none; position:fixed; left:0; top:0; overflow:auto;";

});

}); //DOM load

/*
Možné použití HTML: 

<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width maximum-scale=1 minimum-scale=1" />
<script src="box.js" charset="utf-8"></script>
<style media="screen">
.modal {
z-index: 5;
padding-top: 100px;
width: 100%;
height: 100%;
background-color: transparent; /* background mimo modal */
}

.modal-content {
border: 1px solid #888;
background-color: white; /* modal background */
}

.close {
/* style of modal close span */
}

</style>
</head>
<body>
  <button id="open">Open Modal</button>
  <button id="open2">Open Modal</button>

  <div class="modal" data-btn="open">
      <p>Some text in the Modal.. [1]</p>
      <p>Some text in the Modal.. [1]</p>
      <p>Some text in the Modal.. [1]</p>
      <p>Some text in the Modal.. [1]</p>
  </div>

  <div class="modal" data-btn="open2">
      <p>Some text in the Modal.. [2]</p>
  </div>


</body>
</html>
*/
