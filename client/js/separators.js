var separators = new function() {
  var mainboard;
  var sepData = {};

  document.addEventListener("DOMContentLoaded", function() {
    mainboard = document.getElementsByClassName("main")[0];
  });

  window.addEventListener("load", loadSepData);

  function createBoardName(name) {
    return `<b contenteditable="true" oninput="this.parentNode.dataset.name=this.innerHTML" onblur="saveSepData()">${name}</b>`;
  }
  function restoreBoardName(obj) {
    if(obj.dataset.name) obj.innerHTML = createBoardName(obj.dataset.name);
  }

  function splitBoard(obj, type, name1, name2) {
    var key = type ? 'h' : 'v';
    if(!name1) name1 = "panel 1";
    if(!name2) name2 = "panel 2";
  	obj.classList.add(key);
  	obj.innerHTML = `
  		<div class="board" data-name="${name1}">${createBoardName(name1)}</div>
      <div class="sep ${key}"></div>
  		<div class="board" data-name="${name2}">${createBoardName(name2)}</div>
  	`;
    sizeable(obj.children[1], type, saveSepData);
  }

  async function loadSepData(obj) {
    const raw = await callAPI("get=course&course=1");
    sepData = JSON.parse(raw.split(";")[1]);
    if(sepData.sep) loadSepDataTree(mainboard, sepData);
  }

  function loadSepDataTree(obj, data) {
    const type = data.sep.charAt(0);
    const percent = parseFloat(data.sep.substr(1));
    const size = percent * (type=='h' ? obj.offsetHeight : obj.offsetWidth) / 100;
    splitBoard(obj, type=='h', data.name1, data.name2);
    obj.children[0].style.flexBasis = `${percent}%`;
    if(data.left) loadSepDataTree(obj.children[0], data.left);
    if(data.right) loadSepDataTree(obj.children[2], data.right);
  }

  function splitData(obj) {
    var jesus = {};
    if(obj.classList.contains("v")) jesus.sep = "v";
    else if(obj.classList.contains("h")) jesus.sep = "h";
    else return jesus;
    var split = 50;
    var gestas = obj.children[0], dimas = obj.children[2];
    jesus.name1 = gestas.dataset.name;
    jesus.name2 = dimas.dataset.name;
    var shift = gestas.style.flexBasis;
    if(shift) split = parseInt(shift).toFixed(2);
    jesus.sep+= split;
    if(gestas.classList.contains("v") || gestas.classList.contains("h")) jesus.left = splitData(gestas);
    if(dimas.classList.contains("v") || dimas.classList.contains("h")) jesus.right = splitData(dimas);
    return jesus;
  }

  async function saveSepData() {
    sepData = splitData(mainboard);
    const panels = JSON.stringify(sepData);
    await callAPI("set=course&course=1","panels="+encodeURIComponent(panels));
  }

  this.removeSplit = function(obj) {
    var parent = obj.parentNode;
    parent.classList.remove("h");
    parent.classList.remove("v");
    parent.innerHTML = "";
    restoreBoardName(parent);
    saveSepData();
  }

  this.splitAndSaveH = function(obj) {
    splitBoard(obj, false);
    saveSepData();
  }

  this.splitAndSaveV = function(obj) {
    splitBoard(obj, true);
    saveSepData();
  }
}
