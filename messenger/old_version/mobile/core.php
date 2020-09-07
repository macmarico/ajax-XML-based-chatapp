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
      

    if ((time() - $er) > 900){
    
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

    $recivernm = addslashes($_POST['recivernm']);
     
   $notification =simplexml_load_file("../users/$username/notification/notification.xml");

   $_SESSION["notification"] = $notification->count();
   
    $loadclub =simplexml_load_file("../clubs/club.xml");
 
   $contcurntclubmssges = $loadclub->count();
   $newclubmasseges = $contcurntclubmssges -$_SESSION['countclubmessages'];
   
   
  
  
/* pic share start */
  
  
  if(isset($_POST['picreciver'])){


$username = $_SESSION["Username"];
$recivernm = $_POST['recivernm'] ;

  $checkdir = "../users/$recivernm/storage/$username";

            if(!is_dir($checkdir))
            {
               mkdir("../users/$recivernm/storage/$username");
            }
   

$target_dir = "../users/$recivernm/storage/$username/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        
         $filenm = basename($_FILES["fileToUpload"]["name"]); 
         $arr = explode(".", $filenm);
         $extension = strtolower(array_pop($arr));
         $time = time();
         $newfilenm = "'".$time.".".$extension."'";
        
       rename($target_file, "../users/$recivernm/storage/$username/$newfilenm"); 
             
$filename = "../users/$recivernm/$username.xml";

      if(!file_exists($filename)) {
    
          $doc = new DOMDocument();
          $foo = $doc->createElement("messages");
          $foo->setAttribute("category", "short");
          $doc->appendChild($foo);
          $doc->save("../users/$recivernm/$username.xml");
            } 


$filename2 = "../users/$username/$recivernm.xml";

    if(!file_exists($filename2)) {

          $doc = new DOMDocument();
          $foo = $doc->createElement("messages");
          $foo->setAttribute("category", "short");
          $doc->appendChild($foo);
          $doc->save("../users/$username/$recivernm.xml");

          }
       

    
        $link = "../users/$recivernm/storage/$username/$newfilenm" ;
        $sxe = simplexml_load_file("../users/$recivernm/$username.xml");
        $movie = $sxe->addChild($_SESSION["Username"]);
        $ee = $movie->addChild('time', "yo");
        $ee->addChild('link', "$link");
        $sxe->asXML("../users/$recivernm/$username.xml");

       
        $link = "../users/$recivernm/storage/$username/$newfilenm" ;
        $sxe = simplexml_load_file("../users/$username/$recivernm.xml");
        $movie = $sxe->addChild($_SESSION["Username"]);
        $ee = $movie->addChild('time', "yo");
        $ee->addChild('link', "$link");
        $sxe->asXML("../users/$username/$recivernm.xml");
        
        $message = addslashes($_POST['message']);
        $sxe = simplexml_load_file("../users/$recivernm/notification/notification.xml");
        $sxe->addChild($_SESSION["Username"], "$link");
       
        $sxe->asXML("../users/$recivernm/notification/notification.xml");
   
        
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
}

  
  
/* pic share end */ 
   
     
    
     
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Home</title>
<link href="../design.css" rel="stylesheet" type="text/css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="google" content="notranslate">
<meta name="theme-color" content="#ff6c00">

</head>
<body class=" body-define ProximaNovaRegular">
  <div id="anchor"></div>

<div class="adj">
    <div id="usn" class="gtc "><a href="setting.php">
    <div class="row">
        <div class="b1" >
          <img src=
          
            <?php
          
          $dp = $_SESSION['Username'];
          
          
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
?> | Settings
             
     
        </div>
    </div> </a></div>

    <div class=" notifs"><a href="setting.php">
      <form method="get" action="../logout.php">
    <button type="submit" class="lgbut">Logout</button>
</form></a></div>
    </div>
    
<div class="tabs stickdiv">
    <div class="tab "><a href="club.php"><div class="bor ">CLUB
    <div id="green" class="mytab"><?php  echo $newclubmasseges ; ?> </div></div></a></div>
    <div class="tab "><a href="index.php"><div class="bor ">USERS</div></a></div>
    <div class="tab"><a href="online.php"><div  class=" mytab bor">ONLINE 
      <div id="green" class="mytab"><?php  echo $_SESSION["onlineusers"] ; ?> </div> </div></a></div>
    <div class="tab"><a href="inbox.php"><div id="inbox" class="actbor mytab">INBOX 
      <div id="red" class="mytab"><?php  echo $_SESSION["notification"] ; ?></div></div></a></div>
  </div>


<?php




if(isset($_POST['recivernm'])){


$dom = new DOMDocument();
$dom->load("../users/$username/notification/notification.xml");
$xpath = new DOMXPath($dom);

foreach ($xpath->evaluate($recivernm) as $node) {
  $node->parentNode->removeChild($node);
}

$dom->save("../users/$username/notification/notification.xml");




$filename = "../users/$recivernm/$username.xml";

      if(!file_exists($filename)) {
    
          $doc = new DOMDocument();
          $foo = $doc->createElement("messages");
          $foo->setAttribute("category", "short");
          $doc->appendChild($foo);
          $doc->save("../users/$recivernm/$username.xml");
          
          
            } 

 

$filename2 = "../users/$username/$recivernm.xml";

    if(!file_exists($filename2)) {

          $doc = new DOMDocument();
          $foo = $doc->createElement("messages");
          $foo->setAttribute("category", "short");
          $doc->appendChild($foo);
          $doc->save("../users/$username/$recivernm.xml");

          }
     }     
         
         
         
  /* send message start */       

if(isset($_POST['message'])){

    
        $message = addslashes($_POST['message']);
        $sxe = simplexml_load_file("../users/$recivernm/$username.xml");
        $movie = $sxe->addChild($_SESSION["Username"]);
        $ee = $movie->addChild('time', "yo");
        $ee->addChild('message', "$message");
        $sxe->asXML("../users/$recivernm/$username.xml");

       
        $message = addslashes($_POST['message']);
        $sxe = simplexml_load_file("../users/$username/$recivernm.xml");
        $movie = $sxe->addChild($_SESSION["Username"]);
        $ee = $movie->addChild('time', "yo");
        $ee->addChild('message', "$message");
        $sxe->asXML("../users/$username/$recivernm.xml");
        
        $message = addslashes($_POST['message']);
        $sxe = simplexml_load_file("../users/$recivernm/notification/notification.xml");
        $sxe->addChild($_SESSION["Username"], "$message");
       
        $sxe->asXML("../users/$recivernm/notification/notification.xml");



}

 /* send message end */  
 
 
 /* emoji send start */

if(isset($_POST['emojiname'])){

$recivernm = $_POST['recivernm'] ;
$username = $_SESSION["Username"];
$emojiname = $_POST['emojiname'] ;
$emojilink = "../gif/emoji/$emojiname";
  

    
        $sxe = simplexml_load_file("../users/$recivernm/$username.xml");
        $movie = $sxe->addChild($_SESSION["Username"]);
        $ee = $movie->addChild('time', "yo");
        $ee->addChild('link', "$emojilink");
        $sxe->asXML("../users/$recivernm/$username.xml");

   
        $sxe = simplexml_load_file("../users/$username/$recivernm.xml");
        $movie = $sxe->addChild($_SESSION["Username"]);
        $ee = $movie->addChild('time', "yo");
        $ee->addChild('link', "$emojilink");
        $sxe->asXML("../users/$username/$recivernm.xml");
        
        $message = addslashes($_POST['message']);
        $sxe = simplexml_load_file("../users/$recivernm/notification/notification.xml");
        $sxe->addChild($_SESSION["Username"], "$emojilink");
       
        $sxe->asXML("../users/$recivernm/notification/notification.xml");
   
   
}


/* emoji send end */
 
 
 

$username = $_SESSION["Username"];

?>

  <div class="msgbar">
    <div class="msgtab">
      <form method="post" action="core.php">
      <div class="msgcomp">
        <input type="text" name="message"  placeholder="Type Message" class="width ProximaNovaRegular inpdes msgbut" autocomplete="off"  />
        <input type="hidden" name="recivernm" value="<?php echo $recivernm ; ?>">
      </div>
        <div class="msgcomp">
          <div class="refnsend">
            <input type="submit" name="login" value="SEND" class="ProximaNovaRegularBold indes sendbut csndbut  " />
          </div>
        </form>
        <form method="post" action="core.php">
          <div class="refnsend">
                        <input type="hidden" name="recivernm" value="<?php echo $recivernm; ?>">
                        <input type="submit" class="ProximaNovaRegularBold indes simbut2" value ="<?php echo "REFRESH" ; ?>">
          </div>
          </form>
        </div>
        <div class="row">

    <form method="post" action="core.php" enctype="multipart/form-data">
      <div class="setleft "><input type="file" name="fileToUpload" id="fileToUpload" class="parea"></div>
      <input type="hidden" name="recivernm" value="<?php echo $recivernm; ?>">
      <input type="hidden" name="picreciver" value="<?php echo $recivernm; ?>">
     <div class="setright"> <input type="submit" value="Upload Image" name="submit" class="barea"></div>
    </form>
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
  
    <form method="post" action="core.php" class="emojiform">
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

</div>
  </div>
  
 
 
     </div>

  <div class="messeging cmsgin" id="demo">

<div class="set">
  <a href="#anchor"><div class="">GO TO TOP</div></a>
</div>
<div class=" set">
  <div class="footsim"><form method="post" action="block.php">
    <input type="hidden" name="personname" value="<?php echo $recivernm; ?>">
   <input type="submit" class="dangbut" value ="Block/Report">
    
     </form>
</div>
</div>

<script>
function fetch() {
 
		setTimeout( function() {
	 	loadDoc();
		fetch();
	}, 100);
 
}


function loadDoc() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      myFunction(this);
    }
  };
  xhttp.open("GET", "../clubs/lobby.xml", true);
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
$(function() {
    $("#emojiform").submit(function(event) {
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
  for (i = 0; i < x.length; i++) {
  var name = x[i].getElementsByTagName("name")[0].childNodes[0].nodeValue;
  var time = x[i].getElementsByTagName("time")[0].childNodes[0].nodeValue;
    var row = "<div class=\"row\"><div class=\"b1\" ><img src=\"" + "../users/"    
    + name +"/notification/profilepic.svg" + "\" width=\"30px\" height=\"30x\" alt=\"avatar\" style=\"border-radius: 45px;\" class=\"image\" ></div><div class=\"b2 msginname\" >" +
    x[i].getElementsByTagName("name")[0].childNodes[0].nodeValue +
    "</div> <div class=\"cmoti \"><a href=\"online.php\">check motive</a></div><div class=\"msgoriginal\">" +
    x[i].getElementsByTagName("message")[0].childNodes[0].nodeValue + "</div></div>";
    rowsArray.push(row)
  }
  table += rowsArray.reverse().join('');
  document.getElementById("demo").innerHTML = table;
}

</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
 
<script src="../Relative Design.js"></script>
</body>
</html>

