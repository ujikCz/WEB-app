/*
function getID() {
  return new Promise(function(resolve) {
    var xhr = new XMLHttpRequest();
    xhr.onload = () => resolve(xhr.response);
    xhr.open("GET", "api.php?get=id");
    xhr.send();
  });
}


async function createSticker(contents) {
  const id = await getID();
  var xhr = new XMLHttpRequest();
  xhr.onload = () => body.innerHTML += xhr.response;
  xhr.open("POST", `api.php?add=sticker&id=${id}&person=1&course=1`);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send("x=12&y=42&data="+encodeURIComponent(contents));
}

createSticker("hello? world!");
*/
window.addEventListener('DOMContentLoaded', function(event){

/* všechny objekty který mají atributy v selectoru */

  Array.from(document.querySelectorAll('div.sticker[data-author][data-id]')).forEach(function(elem) {
    let author = elem.dataset.author;
    let id = elem.dataset.id;
    let value = elem.innerHTML; /* výchozí hodnota lepítka */

    /* zápis obsahu */
    elem.innerHTML = `
  		<div class="container">
  		  <h4><b>autor: ${author}</b></h4>
  		</div>
      <p class="pad" contenteditable="true">
        ${value}
      </p>
  	`;
    draggable(elem);

  });



var categoryName = "";
document.getElementById('btnCategory').addEventListener('click', function(e){
  let node = document.createElement("FIELDSET");
  let legend = document.createElement("LEGEND");
  legend.appendChild(document.createTextNode(categoryName));
  node.appendChild(legend);
  document.body.appendChild(node);
});

var color;
document.getElementById('btnSticker').addEventListener('click', function(e){
  let elem = document.createElement("DIV");
  elem.classList.add('sticker');
  elem.classList.add(color);
  let author, id;
  elem.dataset.author = author;
  elem.dataset.id = id;

  /* zápis obsahu */
  elem.innerHTML = `
    <div class="container">
      <h4><b>autor: ${author}</b></h4>
    </div>
    <p class="pad" contenteditable="true">
    </p>
  `;
  draggable(elem);
  document.body.appendChild(elem);
});

}); //DOM load
/*
  Vetsina veci psana pred tim nez jsem videl api dokumentaci, omlouvam se
*/
