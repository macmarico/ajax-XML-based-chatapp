 var i = document.getElementById('inbox');
var y = document.getElementById("red");
if ( y.innerHTML == 0){
  y.style.display = "none";
}
else{
  i.style.color = "red";
  i.style.fontWeight = "bold";
}

var o = document.getElementById('online');
var x = document.getElementById("green");
if ( x.innerHTML == 1){
  x.style.display = "none";
}
else{
  o.style.color = "green";
  o.style.fontWeight = "bold";
}

