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




function make_links_clickable($text){
    return preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', $text);
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


?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Home</title>
<link href="../design.css" rel="stylesheet" type="text/css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="google" content="notranslate">
<meta name="theme-color" content="#f43e2e">





<style>
.collapsible {
  background-color: #F9F9F9;
  color: trasnsparent;
  cursor: pointer;
  padding: 0px;
  width: 100%;
  border: none;
  text-align: center;
  outline: none;
  font-size: 0px;
}

.active, .collapsible:hover {
  background-color: trasnsparent;
}

.content {
  padding: 0 0px;
  display: none;
  overflow: hidden;
  background-color: trasnsparent;
}
</style>






</head>
<body class=" body-define ProximaNovaRegular">











<?php

     
     $username = $_SESSION["Username"];
     
     if(empty($_SESSION['recivernmsess']))
     {
     
     $recivernm = addslashes($_POST['recivernm']);
     
     $_SESSION['recivernmsess'] =  $recivernm;
     
     ?>                      
       <div class="load"><img src="../loading.gif" alt="Loading Cycle" class="loading" style="width:50px; margin-left:calc(50% - 25px);margin-top:130px "></div>
    <?php
     
      echo "<meta http-equiv='refresh' content='0,core.php' />";
        exit;
     
         
     }
     
     
   $recivernm =  $_SESSION['recivernmsess'] ;
   
   
   
   
   
   
   $notification =simplexml_load_file("../users/$username/notification/notification.xml");

   $_SESSION["notification"] = $notification->count();
   
    $loadclub =simplexml_load_file("../clubs/club.xml");
 
   $contcurntclubmssges = $loadclub->count();
   $newclubmasseges = $contcurntclubmssges -$_SESSION['countclubmessages'];
   
   
  
  
/* pic share start */
  
  
  if(isset($_POST['picreciver'])){
  
  
  if(!empty($_FILES["fileToUpload"]["name"])){


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
       

    
        $imagelink = "../users/$recivernm/storage/$username/$newfilenm" ;
        $sxe = simplexml_load_file("../users/$recivernm/$username.xml");
        $movie = $sxe->addChild('messageset');
        $ee = $movie->addChild('username', $username);
        $ee = $movie->addChild('time', time());
        $ee = $movie->addChild('imagelink', "$imagelink");
        $sxe->asXML("../users/$recivernm/$username.xml");

       
        $imagelink = "../users/$recivernm/storage/$username/$newfilenm" ;
        $sxe = simplexml_load_file("../users/$username/$recivernm.xml");
        $movie = $sxe->addChild('messageset');
        $ee = $movie->addChild('username', $username);
        $ee = $movie->addChild('time', time());
        $ee = $movie->addChild('imagelink', "$imagelink");
        $sxe->asXML("../users/$username/$recivernm.xml");
        
        $message = addslashes($_POST['message']);
        $sxe = simplexml_load_file("../users/$recivernm/notification/notification.xml");
        $sxe->addChild($_SESSION["Username"], "$link");
       
        $sxe->asXML("../users/$recivernm/notification/notification.xml");
   
        
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
    
    
     echo "<meta http-equiv='refresh' content='0,core.php' />";
         exit;
}
}
}
  
  
/* pic share end */ 
   
     
    
     
?>


  <div id="anchor"></div>

<div class="adj">
    <div id="usn" class="gtc "><a href="">
    <div class="row">
        <div class="b1" >
          <img src=
          
            <?php
          
          $dp = $recivernm;
          
          
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
echo "".$recivernm.""; 
?> 
             
     
        </div>
    </div> </a></div>

    <div class=" notifs"><a href="setting.php">
      <form method="get" action="../logout.php">
    <button type="submit" class="lgbut">Logout</button>
</form></a></div>
    </div>
    
<div class="tabs stickdiv">
    
   
     <div class="tab "><a href="feed.php"><div class="bor ">MOTIVES</div></a></div>
    
    <div class="tab"><a href="online.php"><div class="bor mytab">ONLINE 
      <div id="green" class="mytab"><?php  echo $_SESSION["onlineusers"] ; ?> </div> </div></a></div>
    <div class="tab"><a href="inbox.php"><div  class="bor mytab">INBOX 
      <div id="red" class="mytab"><?php  echo $_SESSION["notification"] ; ?></div></div></a></div>
  </div>


<?php




if(!empty($_SESSION['recivernmsess'])){


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
        $movie = $sxe->addChild('messageset');
        $ee = $movie->addChild('username', $username);
        $ee = $movie->addChild('time', time());
        $ee = $movie->addChild('imagelink', "$imagelink");
        $ee = $movie->addChild('message', "$message");
        $sxe->asXML("../users/$recivernm/$username.xml");

       
        $message = addslashes($_POST['message']);
        $sxe = simplexml_load_file("../users/$username/$recivernm.xml");
        $movie = $sxe->addChild('messageset');
        $ee = $movie->addChild('username', $username);
        $ee = $movie->addChild('time', time());
        $ee = $movie->addChild('imagelink', "$imagelink");
        $ee = $movie->addChild('message', "$message");
        $sxe->asXML("../users/$username/$recivernm.xml");
        
        $message = addslashes($_POST['message']);
        $sxe = simplexml_load_file("../users/$recivernm/notification/notification.xml");
        $sxe->addChild($_SESSION["Username"], "$message");
       
        $sxe->asXML("../users/$recivernm/notification/notification.xml");
        
         echo "<meta http-equiv='refresh' content='0,core.php' />";
         exit;
 


}

 /* send message end */  
 
 
 /* emoji send start */

if(isset($_POST['emojiname'])){

$recivernm = $_POST['recivernm'] ;
$username = $_SESSION["Username"];
$emojiname = $_POST['emojiname'] ;
$emojilink = "../gif/emoji/$emojiname";
  

    
        $sxe = simplexml_load_file("../users/$recivernm/$username.xml");
        $movie = $sxe->addChild('messageset');
        $ee = $movie->addChild('username', $username);
        $ee = $movie->addChild('time', time());
        $ee = $movie->addChild('link', "$emojilink");
        $sxe->asXML("../users/$recivernm/$username.xml");

   
        $sxe = simplexml_load_file("../users/$username/$recivernm.xml");
        $movie = $sxe->addChild('messageset');
        $ee = $movie->addChild('username', $username);
        $ee = $movie->addChild('time', time());
        $ee = $movie->addChild('link', "$emojilink");
        $sxe->asXML("../users/$username/$recivernm.xml");
        
        $message = addslashes($_POST['message']);
        $sxe = simplexml_load_file("../users/$recivernm/notification/notification.xml");
        $sxe->addChild($_SESSION["Username"], "$emojilink");
       
        $sxe->asXML("../users/$recivernm/notification/notification.xml");
   
   
       echo "<meta http-equiv='refresh' content='0,core.php' />";
         exit;
 
   
}


/* emoji send end */
 
 
 

$username = $_SESSION["Username"];

?>

  <div class="msgbar">
    <div class="msgtab">
      <form method="post" action="core.php">
      <div class="msgcomp">
        <input type="text" name="message"  placeholder="Type Message" class="width ProximaNovaRegular inpdes msgbut" autocomplete="off" required />
       
      </div>
        <div class="msgcomp">
          <div class="refnsend">
            <input type="submit" name="login" value="SEND" class="ProximaNovaRegularBold indes sendbut csndbut  " />
          </div>
        </form>
        <form  action="core.php">
          <div class="refnsend">
                       
                        <input type="submit" class="ProximaNovaRegularBold indes simbut2" value ="<?php echo "REFRESH" ; ?>">
          </div>
          </form>
        </div>
        
        <button type="button" class="collapsible"><img src="../gif/arrow.png" alt="Italian Trulli" width="20" height="auto"> </button>
<div class="content">
        
        
        <div class="row">

    <form method="post" action="core.php" enctype="multipart/form-data">
      <div class="setleft "><input type="file" name="fileToUpload" id="fileToUpload" class="parea"></div>
      <input type="hidden" name="recivernm" value="<?php echo $recivernm; ?>">
      <input type="hidden" name="picreciver" value="<?php echo $recivernm; ?>">
     <div class="setright"> <input type="submit" value="Send" name="submit" class="barea"></div>
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
 
     </div>
     

   <div class="member">

<?php


 $xml =simplexml_load_file("../users/$username/$recivernm.xml") or die("Error: Cannot create object"); // what user freind has sent
     $xmlArray = array();
     foreach($xml->children() as $message) $xmlArray[] = $message;
     $xmlArray = array_reverse($xmlArray);
     $countmssg = 0;
     foreach($xmlArray as $message)

    { 
       
         if($countmssg == 200)
         { break;}
   
    $checkblocked = mysqli_query($conn,"SELECT * FROM blocked WHERE Username = '".$row["Username"]."'");
         
        if (mysqli_num_rows($checkblocked) == 0) {  
          
           $x = '0';

             $dumm =  $message->username;
          $personalblock = "../users/$username/notification/blocked.xml";
           if (file_exists($personalblock)) {

              $personalblock =simplexml_load_file("../users/$username/notification/blocked.xml");
              $checkpersonalblock = $personalblock->$dumm ;
              $x =  $checkpersonalblock->count();

           }

        
          if($x == "0"){
    

  ?>
  
<div class="messeging cmsgin">
<div class="row">
     <div class="msgtime b1">
           <?php 
                 $messagetime =  $message->time ;
                 if($messagetime!= 'yo'){
              echo convert(time() - $messagetime);
            }
            ?>
              </div>
        <div class="b1" >
         
          
            <?php
          
          $dp = $message->username;
          ?>
            
     <input type="hidden" name="profilename" value="<?php echo $dp; ?>">
  <input type="image" src="../users/<?php echo $dp; ?>/notification/profilepic.svg" width="30px" alt="avatar" style="border-radius: 45px;" class="image" >
        
          
           

        </div>
        <div class="b2 msginname" >
           <?php  print $message->username ." </div><div class=\"cmoti \"><a href=\"online.php\"></a></div><div class=\"msgoriginal\" id=\"demo\" > " . make_links_clickable($message->message) .""; ?>
          
       <?php 
       
          if(!empty($message->link))
         {
          ?> 


         
            <img src="<?php echo $message->link ; ?>" class="sharedimg2"> 
            <?php
        
     } 
     
     
     
     
          if(!empty($message->imagelink))
         {
          ?> 


         
            <img src="<?php echo $message->imagelink ; ?>" class="sharedimg" id="img" > 
            <?php
        
     } 

         ?>

            </div>

            

    </div> 



</div>


<?php
      }
     }
   
   
   $count++;
 }

 

?>
</div>

<div class="set">
  <a href="#anchor"><div class="">GO TO TOP</div></a>
</div>
<div class=" set">
  <div class="footsim">
    <input type="hidden" name="personname" value="<?php echo $recivernm; ?>">
   <input type="submit" class="dangbut" value ="Block/Report">
    
   
</div>
</div>

<script>
var coll = document.getElementsByClassName("collapsible");
var i;

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.display === "block") {
      content.style.display = "none";
    } else {
      content.style.display = "block";
    }
  });
}
</script>

<script src="../Relative Design.js"></script>
</body>
</html>

