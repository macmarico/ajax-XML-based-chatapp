<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
#myDIV {
  width: 100%;
  padding: 50px 0;
  text-align: center;
  background-color: lightblue;
  margin-top: 20px;
}
</style>
</head>
<body>


<button onclick="myFunction()">Try it</button>

<button onclick="myFunction2()">Try it</button>

<button onclick="myFunction3()">Try it</button>

<div id="myDIV">
This is my DIV element.
</div>

<div id="myDIV2">
This is my DIV element2.
</div>

<div id="myDIV3">
This is my DIV element3.
</div>

<script>
function myFunction() {
  var x = document.getElementById("myDIV");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}


function myFunction2() {
  var x = document.getElementById("myDIV2");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
  
  document.getElementById("myDIV1").style.display = "none";
  document.getElementById("myDIV3").style.display = "none";
  
  
}

function myFunction3() {
  var x = document.getElementById("myDIV3");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
  
  document.getElementById("myDIV1").style.display = "none";
  document.getElementById("myDIV2").style.display = "none";
  
}

document.getElementById("myDIV2").style.display = "none";
document.getElementById("myDIV3").style.display = "none";

</script>

</body>
</html>

