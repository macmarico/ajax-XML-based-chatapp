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
$profilename = $_POST['profilename'];

$notification =simplexml_load_file("../users/$username/notification/notification.xml"); // notification count

$_SESSION["notification"] = $notification->count();

 
   
   
  


?>




<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Settings</title>
<link href="../design.css" rel="stylesheet" type="text/css">
<meta name="theme-color" content="#f43e2e">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class=" body-define ProximaNovaRegular">

 <div class="adj" style=" height: 55px" >  <a style= "color : white ;" href=" setting.php">back</a>

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
     </a></div>
    </div>

<div class="tabs stickdiv">
    
      <div class="tab"><a href=""><div id="inbox" class="actbor mytab">POSTS
      </div></a></div>
    
    <div class="tab "><a href=""><div class="bor ">MOTIVES</div></a></div>
    <div class="tab"><a href=""><div  class=" mytab bor">PINS
      </div></a></div>
   
  </div>
  




 <div class="member">

<div class="setlayt">TOPICS </div>


<?php

$xml =simplexml_load_file("../users/$username/posts/postlist.xml") or die("Error: Cannot create object"); // what user freind has sent
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

             $dumm =  $message->username;
          $personalblock = "../users/$username/notification/blocked.xml";
           if (file_exists($personalblock)) {

              $personalblock =simplexml_load_file("../users/$username/notification/blocked.xml");
              $checkpersonalblock = $personalblock->$dumm ;
              $x =  $checkpersonalblock->count();

           }

        
          if($x == "0"){
    

  ?>
  



  <div class="memlayt">
  
  
  
  
  <?php
   if(!empty($message->postpic)){
   ?>
   <img src="../users/<?php echo $profilename ;?>/posts/files/<?php echo $message->statusID ;?>/storage/post/<?php echo $message->postpic ;?>" alt="Trulli" width="320" height="auto" style="border-radius: 15px;>
    <?php } ?>

           <div class="dmotive">
    
           
     
                <form method="post" action="motive.php">
                <input type="hidden" name="recivernm" value="<?php echo $message->username ; ?>">
                <input type="hidden" name="statusID" value="<?php echo $message->statusID ; ?>">
                <input type="hidden" name="motive" value="<?php echo $message->post ; ?>" class="dmotive">
                 <button type="submit" style="font-size:15px"  class="dmotive ProximaNovaRegular">
                
                
                 <?php
                 if(!empty($message->postpic)){
                  ?>
                
                 <img class="sharedimg" id="img" type="image" src="../users/<?php echo $message->username ;?>/posts/files/<?php echo $message->time ;?>/storage/post/<?php echo $message->postpic ;?>" alt="Trulli"  style="
                 
                 
                  <?php
                 if(!empty($message->post)){
                  ?>
                 width:310px;
                 <?php
                 }else{
                 ?>
                 width:310px;
                 <?php
                }
                 ?>
                 
                 height:auto;margin-left:15px;border-radius: 25px;">
                 
                 
  
                <?php } 
                
                 if(!empty($message->topic)){
                
                echo "<strong>$message->topic </strong>"; ?><br style= "line-height: 160%;"><?php
                
                }
                
                $pattern = '@(http(s)?://)?(([a-zA-Z])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@';
                
                
                $output = preg_replace($pattern, '<sup style="font-size:12px ; color:#538b01" class="fa">&nbsp  link &#xf112 &nbsp </sup>', $message->post);               
                
                echo substr($output,0,150) ; ?> <br></button>
                </form>  
            
 
 </div>
      
        </div>



<?php
      }
     }
   
   
   $count++;
 }



?>

</div>




     
<div class=" set">
  <div class="footsim"><a href="block.php">Blocked users</a>
</div>
</div>    
     
     
<script src="../Relative Design.js"></script>
<script src="../mobile.js" ></script>
</body>
</html>
