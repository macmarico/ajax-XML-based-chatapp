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
 <!-- refresh every 5 seconds -->
  <meta http-equiv="refresh" content="5">
<title>Home</title>
<link href="../design.css" rel="stylesheet" type="text/css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="google" content="notranslate">
<meta name="theme-color" content="#f43e2e">





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
   
   
  ?>

   <div class="member">
   
   <div class="set">

  
   <div style="font-size: 15px; color: #999">load old messages</div>
   
   
</div>
   

<?php


 $xml =simplexml_load_file("../users/$username/$recivernm.xml") or die("Error: Cannot create object"); // what user freind has sent
    
    $countmssg = $xml->count();
    
    
    
   
    
    $xmlArray = array();
     foreach($xml->children() as $message) $xmlArray[] = $message;
     
    
    for ($x = 0; $x <= $countmssg-1; $x++) {
    
     ?>
       
  
<div class="messeging cmsgin">
<div class="row">
     <div class="msgtime b1">
           <?php 
                 $messagetime =  $xml->messageset[$x]->time ;
                 if($messagetime!= 'yo'){
              echo convert(time() - $messagetime);
            }
            ?>
              </div>
        <div class="b1" >
         
          
            <?php
          
          $dp = $xml->messageset[$x]->username;
          ?>
            
     <input type="hidden" name="profilename" value="<?php echo $dp; ?>">
  <input type="image" src="../users/<?php echo $dp; ?>/notification/profilepic.svg" width="30px" alt="avatar" style="border-radius: 45px;" class="image" >
        
          
           

        </div>
        <div class="b2 msginname" >
           <?php  print $xml->messageset[$x]->username ." </div><div class=\"cmoti \"><a href=\"online.php\"></a></div><div class=\"msgoriginal\" id=\"demo\" > " . make_links_clickable($xml->messageset[$x]->message) .""; ?>
          
       <?php 
       
          if(!empty($xml->messageset[$x]->link))
         {
          ?> 


         
            <img src="<?php echo $message->link ; ?>" class="sharedimg2"> 
            <?php
        
     } 
     
     
     
     
          if(!empty($xml->messageset[$x]->imagelink))
         {
          ?> 


         
            <img src="<?php echo $xml->messageset[$x]->imagelink ; ?>" class="sharedimg" id="img" > 
            <?php
        
     } 

         ?>



            </div>

            

    </div> 



</div>

<?php
 
 } 

 

?>
</div>

<br><br>
<br>


<script>
scrollingElement = (document.scrollingElement || document.body)

   scrollingElement.scrollTop = scrollingElement.scrollHeight;

</script>

<script src="../Relative Design.js"></script>
</body>
</html>

