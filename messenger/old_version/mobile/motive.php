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



function convert($seconds){
$string = "";

$days = intval(intval($seconds) / (3600*24));
$hours = (intval($seconds) / 3600) % 24;
$minutes = (intval($seconds) / 60) % 60;
$seconds = (intval($seconds)) % 60;

if($days> 0){
    $string .= "$days"."d";
}else{
if($hours > 0){
    $string .= "$hours"."h";
          }else{
if($minutes > 0){
    $string .= "$minutes"."m";
         }else{
if ($seconds > 0){
    $string .= "$seconds"."s";
              }
           }
        }
     }
return $string;

}








     
     $username = $_SESSION["Username"];

    $recivernm = addslashes($_POST['recivernm']);
     
   $notification =simplexml_load_file("../users/$username/notification/notification.xml");

   $_SESSION["notification"] = $notification->count();
     
      $loadclub =simplexml_load_file("../clubs/motive.xml");
      $countmessage = $loadclub->count();
      $_SESSION['countclubmessages'] = $countmessage;
      
      
      
      
    

/* emoji send start */

if(isset($_POST['emojiname'])){

$recivernm = $_POST['recivernm'] ;
$username = $_SESSION["Username"];
$emojiname = $_POST['emojiname'] ;
$emojilink = "../gif/emoji/$emojiname";
  

    
        $sxe = simplexml_load_file("../clubs/motive.xml");
        $movie = $sxe->addChild("messageset");
        $ee = $movie->addChild('name', "$username");
        $ee = $movie->addChild('time', time());
        $ee = $movie->addChild('link', "$emojilink");
        $sxe->asXML("../clubs/motive.xml");
        
        
   
   
}


/* emoji send end */


  
    
     
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="google" content="notranslate">
<link rel="shortcut icon" href="favicon.png">
<title>Home</title>
<link href="mobile.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="../lib/css/emoji.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body class=" body-define ProximaNovaRegular" onload="fetch()" >
<div id="anchor"></div>

<div class="adj">

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
  <div class="tab "><div class="actbor ">What is the most inspiring sentence you have ever heard or read?</div></div>
  
  </div>


<?php

if(isset($_POST['message'])){

    
        $message = addslashes($_POST['message']);
        $sxe = simplexml_load_file("../clubs/motive.xml");
        $movie = $sxe->addChild("messageset");
        $ee = $movie->addChild('name', "$username");
        $ee = $movie->addChild('time', time());
        $ee = $movie->addChild('message', "$message");
        $sxe->asXML("../clubs/motive.xml");


}


$username = $_SESSION["Username"];

?>

  <div class="msgbar mbc">
    <div class="msgtab">
      <form method="get" action="motive.php" id="formpost" name="formpost" class="formpost">
      <div class="clubinput ">
        <input type="text" name="message"  placeholder="Type Message" class="width ProximaNovaRegular textinput" autocomplete="off" />
        <input type="hidden" name="recivernm" value="<?php echo $recivernm ; ?>">
      </div>
        <div class=" clubsend ">
            <input type="submit" name="login" value="SEND" class="ProximaNovaRegularBold sendbut " />
        </div>
          </form>
      </div>
  </div>
<div class="emojibar">
   <div >
              <?php
            

/* Show emoji start */


      $dir = "../gif/emoji";

    // Open a directory, and read its contents
      if (is_dir($dir)){
      if ($dh = opendir($dir)){
      while (($file = readdir($dh)) !== false){
      $filename = $file ;
      $withoutext = basename($filename, '.xml');
    
      if("$filename" != '.' AND "$filename" != '..' AND "$filename" != 'storage' AND "$filename" != 'notification' )
      {
      

       ?>
  
    <form method="post" action="motive.php" class="emojiform" id="emojiform">
      <input type="hidden" name="emojiname" value="<?php echo $filename; ?>">
      <input type="hidden" name="recivernm" value="<?php echo $recivernm; ?>">
      
      <input type="image" src="../gif/emoji/<?php echo $filename; ?>" width="50px" class="emoji"  alt="Submit" >
    
    </form>
   
        <?php
    
          }
        }

    closedir($dh);
      }
    }

 
 /* Show emoji end */
 
   ?>
    
    
    
    </div>
    </div>



<p id="d"></p>

<div class="messeging cmsgin" id="demo">

</div>

<div class="set">
  <a href="#anchor"><div class="">GO TO TOP</div></a>
</div>



<script>
function fetch() {
 
		setTimeout( function() {
	 	loadDoc();
		fetch();
	}, 1000);
 
}


function loadDoc() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      myFunction(this);
    }
  };
  xhttp.open("GET", "../clubs/motive.xml", true);
  xhttp.send();
}
 
$(function() {
    $("#formpost").submit(function(event) {
        event.preventDefault();

        var form = $(this);
        var url = form.attr('action');

        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize() // serializes the form's elements.
        }).done(function(data) {
            var msg = $(data).find('#msg').text();

           
        });
    });
}); 

  function myFunction(xml) {
  var rowsArray =[]
  var i ;
  var xmlDoc = xml.responseXML;
  var table="";
  var x = xmlDoc.getElementsByTagName("messageset");
  var getMessage = function(messageSetNode) {
  var wrapInDiv = function(msg) {
    return   msg ;
  }
  var messageNode = messageSetNode.getElementsByTagName("message")[0]; 
  if(messageNode) {
    return wrapInDiv(messageNode.childNodes[0].nodeValue);
  }
  document.getElementById("d").innerHTML = wrapInDiv(messageSetNode.getElementsByTagName("link")[0].childNodes[0].nodeValue);
  return "<input type=\"image\" src=\""+wrapInDiv(messageSetNode.getElementsByTagName("link")[0].childNodes[0].nodeValue)+"\" width=\"30%\" class=\"emoji\"  alt=\"Submit\" >";
}

  
  for (i = 0; i < x.length; i++) {
  var name = x[i].getElementsByTagName("name")[0].childNodes[0].nodeValue;
  var time = x[i].getElementsByTagName("time")[0].childNodes[0].nodeValue;
    var row = "<div class=\"row\"><div class=\"b1\" ><img src=\"" + "../users/"    
    + name +"/notification/profilepic.svg" + "\" width=\"30px\" height=\"30x\" alt=\"avatar\" style=\"border-radius: 45px;\" class=\"image\" ></div><div class=\"b2 msginname\" >" +
    x[i].getElementsByTagName("name")[0].childNodes[0].nodeValue +
    "</div> <div class=\"cmoti \"><a href=\"online.php\">check motive</a></div><div class=\"msgoriginal\">" +
    getMessage(x[i]) + "</div></div>";
    rowsArray.push(row)
  }
  table += rowsArray.reverse().join('');
  document.getElementById("demo").innerHTML = table;
}
document.getElementById("d").innerHTML = wrapInDiv(messageSetNode.getElementsByTagName("link")[0].childNodes[0].nodeValue);
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- ** Don't forget to Add jQuery here ** -->
</body>
</html>

