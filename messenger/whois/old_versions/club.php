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
     
      $loadclub =simplexml_load_file("../clubs/club.xml");
      $countmessage = $loadclub->count();
      $_SESSION['countclubmessages'] = $countmessage;
    
     
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="google" content="notranslate">
<meta name="theme-color" content="#ff6c00">

<link rel="shortcut icon" href="favicon.png">
<title>Home</title>
<link href="../design.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="../lib/css/emoji.css" rel="stylesheet">
</head>
<body class=" body-define ProximaNovaRegular">
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
?> | Settings
             
     
        </div>
    </div> </a></div>

    <div class=" notifs"><a href="setting.php">
      <form method="get" action="../logout.php">
    <button type="submit" class="lgbut">Logout</button>
</form></a></div>
    </div>
    
<div class="tabs stickdiv">
  <div class="tab "><a href="club.php"><div class="actbor ">CLUB</div></a></div>
    <div class="tab "><a href="feed.php"><div class="bor ">FEED</div></a></div>
    <div class="tab"><a href="online.php"><div  class=" mytab bor">ONLINE 
      <div id="green" class="mytab"><?php  echo $_SESSION["onlineusers"] ; ?> </div> </div></a></div>
    <div class="tab"><a href="inbox.php"><div id="inbox" class="bor mytab">INBOX 
      <div id="red" class="mytab"><?php  echo $_SESSION["notification"] ; ?></div></div></a></div>
  </div>


<?php




if(isset($_POST['message'])){

    
        $message = addslashes($_POST['message']);
        $sxe = simplexml_load_file("../clubs/club.xml");
        $movie = $sxe->addChild('messageset');
        $ee = $movie->addChild('username', $username);
        $ee = $movie->addChild('time', time());
        $ee = $movie->addChild('message', "$message");
       
        $sxe->asXML("../clubs/club.xml");


}



/* emoji send start */

if(isset($_POST['emojiname'])){

$recivernm = $_POST['recivernm'] ;
$username = $_SESSION["Username"];
$emojiname = $_POST['emojiname'] ;
$emojilink = "../gif/emoji/$emojiname";
  

    
        $sxe = simplexml_load_file("../clubs/club.xml");
        $movie = $sxe->addChild('messageset');
        $ee = $movie->addChild('username', $username);
        $ee = $movie->addChild('time', time());
        $ee = $movie->addChild('link', "$emojilink");
        $sxe->asXML("../clubs/club.xml");
        
        

        
   
   
}


/* emoji send end */


$username = $_SESSION["Username"];

?>

  <div class="msgbar mbc">
    <div class="msgtab">
      <form method="post" action="club.php" id="formpost">
      <div class="msgcomp">
        <input type="text" name="message"  placeholder="Type Message" class="width ProximaNovaRegular inpdes msgbut clubinput" autocomplete="off" data-emojiable="true" data-emoji-input="unicode" required />
        <input type="hidden" name="recivernm" value="<?php echo $recivernm ; ?>">
      </div>
        <div class="msgcomp">
          <div class="refnsend">
            <input type="submit" name="login" value="SEND" class="ProximaNovaRegularBold indes sendbut csndbut  " />
          </div>
        </form>
          <div class="refnsend">
            <form method="post" action="club.php">
                        <input type="hidden" name="recivernm" value="<?php echo $recivernm; ?>">
                        <input type="submit" class="ProximaNovaRegularBold indes simbut2" value ="<?php echo "REFRESH" ; ?>">
                     </form>
          </div>
        </div>
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
  
    <form method="post" action="club.php" class="emojiform">
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





   <div class="member cback">

<?php


 $xml =simplexml_load_file("../clubs/club.xml") or die("Error: Cannot create object"); // what user freind has sent
     $xmlArray = array();
     foreach($xml->children() as $message) $xmlArray[] = $message;
     $xmlArray = array_reverse($xmlArray);
     $count = 0;
     foreach($xmlArray as $message)

    { 
         if($count == 200)
         { break;}
   
        

          $checkblocked = mysqli_query($conn,"SELECT * FROM blocked WHERE Username = '".$row["Username"]."'");
         
        if (mysqli_num_rows($checkblocked) == 0) {  
          
           $x = '0';

             $dumm =  $message->getName();
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
          <img src=
          
            <?php
          
          $dp = $message->username;
          
          
             $filename = "../users/$dp/notification/profilepic.svg";

            if (file_exists($filename)) {
                  echo "$filename";
                      } else {
                       echo "../contact.svg";
                }
            ?>

           width="30px" alt="avatar" style="border-radius: 45px;" class="image" >

        </div>
        <div class="b2 msginname" >
           <?php  print $message->username ." </div><div class=\"cmoti \"><a href=\"online.php\">check motive</a></div><div class=\"msgoriginal\" id=\"demo\" > " . $message->message .""; ?>
          
       <?php 
       
          if(empty($message->message))
         {
          ?> 


         
            <img src="<?php echo $message->link ; ?>" class="sharedimg2"> 
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
<script>
    var x = document.querySelectorAll(".msginname");
    var n = document.querySelectorAll(".cmsgin");
    for(var i = 0;i < x.length ; i++){
    var name = x[i].innerHTML;
    for(var s = 0; s< n.length; s++){
    if(name == "abhi"){
    n[i].style.backgroundColor = "red";
    };
    };
    };
</script>
<script src="../Relative Design.js"></script>
<!-- ** Don't forget to Add jQuery here ** -->
</body>
</html>

