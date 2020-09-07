<?php
include "../base.php";

if(empty($_SESSION['LoggedIn']) && empty($_SESSION['Username']))
{
        echo "<meta http-equiv='refresh' content='0,../index.php' />";
        exit;
     }
     
     else
{
// only if user is logged in perform this check
  if ((time() - $_SESSION['last_login_timestamp']) > 900) {
    header("location:../logout.php");
    exit;
    
  } else {
    $_SESSION['last_login_timestamp'] = time();
    
    $sqlupdate = "UPDATE sessions SET last_seen = Now() WHERE username= '".$_SESSION["Username"]."'";
    
    mysqli_query($conn, $sqlupdate);
    
    
    $sql = "SELECT * FROM sessions";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
    
    $er = strtotime($row["last_seen"]);
      

    if ((time() - $er) > 900 or ($er - time()) > 900){
    
    $sql = "DELETE FROM sessions WHERE username='".$row["username"]."'";

    mysqli_query($conn, $sql);
    
    

     
    
              }
    
          } 
        
        
       }
 
    
    $result = mysqli_query($conn,"SELECT * FROM sessions");
    $num_rows = mysqli_num_rows($result);

    $_SESSION["onlineusers"] = $num_rows;
    

 
   }

}












     
     $username = $_SESSION["Username"];
     $recivernm = $_POST['recivernm'];
     
     
     
     
     if(!empty($_POST['recivernm'])){


$dom = new DOMDocument();
$dom->load("../users/$username/notification/notification.xml");
$xpath = new DOMXPath($dom);

foreach ($xpath->query("/apps/notifset[username= '$recivernm']") as $node) {
  $node->parentNode->removeChild($node);
}

$dom->save("../users/$username/notification/notification.xml");


}     

     
    
     
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="google" content="notranslate">
<link rel="shortcut icon" href="favicon.png">
<title>Home</title>
<link href="../design.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="../lib/css/emoji.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   
   
   <script>
function resetForm() {
    document.getElementById("myForm").reset();
}
</script>
    
</head>
<body class=" body-define ProximaNovaRegular" onload="fetch()" >
<div class="adj" style=" height: 53px">
    <div id="usn" class="gtc "><a href="setting.php">
    <div class="row">
        <div class="b1" >
          <img src=
          
            <?php
          
          $dp = $_SESSION["Username"] ;
          
          
             $filename = "../users/$dp/notification/profilepic.svg";

            if (file_exists($filename)) {
                  echo "$filename";
                      } else {
                       echo "../contact.svg";
                }
            ?>

           width="30px" alt="avatar" style="border-radius: 45px;"  >

        </div>
        <div class="b2 unadj" >
           <?php
echo "".$_SESSION['Username'].""; 
?> 
 
        </div>
    </div> </a></div>

    <div class=" notifs"><a href="setting.php">
      <form method="get" action="../logout.php">
    <button type="submit" class="lgbut">Logout</button>
</form></a></div>
    </div>

<div class="tabs stickdiv">


    <div class="tab "><a href="home.php"><div class="mytab bor ">FEED</div></a></div> 
   
    
    
    <div class="tab"><a href="online.php"><div  class=" mytab bor">ONLINE 
      <div id="green" style="color:green;"  class="mytab"><?php  echo $_SESSION["onlineusers"] +200 ; ?> </div> </div></a></div>
   
  
    <div class="tab"><a href="inbox.php"><div id="inbox" class="actbor">CHATS
      <div id="green" style="color:green;"  class="mytab"><?php  echo $_SESSION["notification"] ; ?></div></div></a></div>
  
  </div>
  

    





<div class="set">

  <a href="#anchor"><div style="font-size: 15px; color: #999">new messages</div></a>
</div>

<div class="messeging cmsgin" id="demo"> 

</div>

<div class="set">
  <a href="#anchor"><div style="font-size: 15px; color: #999">pinned</div></a>
</div>



<div class="messeging cmsgin" id="pins">

</div>















<script>






function fetch() {
 
		setTimeout( function() {
	 	loadchats();
		fetch();
	}, 1000);
 
}



function loadchats() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      NewMessages(this);
    }
  };
  xhttp.open("GET", "../users/manish/notification/notification.xml", false);
  xhttp.setRequestHeader('Cache-Control', 'no-cache');
  xhttp.send();
}
 
 
function NewMessages(xml) {
  var rowsArray =[]
  var i ;
  var xmlDoc = xml.responseXML;
  var table="";
  var x = xmlDoc.getElementsByTagName("notifset");
  
   var repusername = [];
  
  for (i = 0; i < x.length; i++) {
  
  
  
  var name = x[i].getElementsByTagName("username")[0].childNodes[0].nodeValue;
  

    
  if (repusername.includes(name) == false){

    
    var row = "<div class=\"row\"><div class=\"b1\" ><img src=\"" + "../users/"    
    + name +"/notification/profilepic.svg" + "\" width=\"30px\" height=\"30x\" alt=\"avatar\" style=\"border-radius: 45px;\" class=\"image\" ></div><div class=\"b2 msginname\" >" +
    name +
    "</div> <div class=\"msgoriginal\"></div></div>";
    rowsArray.push(row)
    repusername.push(name)
    }
  }
        
     
 
   
  table += rowsArray.join('');
  document.getElementById("demo").innerHTML = table;
  
}
  
   



var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      PinnedPeople(this);
    }
  };
  xhttp.open("GET", "../users/manish/notification/pinfriend.xml", false);
  xhttp.setRequestHeader('Cache-Control', 'no-cache');
  xhttp.send();

function PinnedPeople(xml) {
  var rowsArray =[]
  var i ;
  var xmlDoc = xml.responseXML;
  var table="";
  var x = xmlDoc.getElementsByTagName("personset");
  

  
  for (i = 0; i < x.length; i++) {
  
  
  
  var name = x[i].getElementsByTagName("username")[0].childNodes[0].nodeValue;
  

    
    var row = "<div class=\"row\"><div class=\"b1\" ><img src=\"" + "../users/"    
    + name +"/notification/profilepic.svg" + "\" width=\"30px\" height=\"30x\" alt=\"avatar\" style=\"border-radius: 45px;\" class=\"image\" ></div><div class=\"b2 msginname\" >" +
    name +
    "</div> <div class=\"msgoriginal\"></div></div>";
    rowsArray.push(row)
  
    
  }
        
     
 
   
  table += rowsArray.join('');
  document.getElementById("pins").innerHTML = table;
  
}
  
   










</script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-JAW99MJVpJBGcbzEuXk4Az05s/XyDdBomFqNlM3ic+I=" crossorigin="anonymous"></script>
<!-- ** Don't forget to Add jQuery here ** -->
</body>
</html>

