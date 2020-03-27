window.addEventListener('DOMContentLoaded', function(event){

/* všechny objekty který mají atributy v selectoru */
Array.from(document.querySelectorAll('div.sticker[data-author][data-id]')).forEach(function(elem) {
  let author = elem.getAttribute('data-author');
  let id = elem.getAttribute('data-id');
  let value = elem.innerHTML; /* defaultní hodnota lepitka */

  /* zápis obsahu */
  elem.innerHTML = '' +
      '<div class="container">' +
          '<h4><b>autor: ' + author + '</b></h4>' +
        '</div>' +
        '<pre class="pad" contenteditable="true">' +
            value +
        '</pre>';
});

}); //DOM load
