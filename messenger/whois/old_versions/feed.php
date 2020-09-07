<?php
include "../base.php";

unset ($_SESSION["recivernmsess"]);

if(empty($_SESSION['LoggedIn']) && empty($_SESSION['Username']))
{
        echo "<meta http-equiv='refresh' content='0,../index.php' />";
        exit;
     }
     
       else
{



    $_SESSION['last_login_timestamp'] = time();
    
    
    
           $sqlcheckonline = mysqli_query($conn,"SELECT * FROM sessions WHERE username= '".$_SESSION["Username"]."'");
   
                
                 if(mysqli_num_rows($sqlcheckonline) == 1)
                {
               
                    
                mysqli_query($conn,"UPDATE sessions SET last_seen = Now() WHERE username= '".$_SESSION["Username"]."'");
    
               
               
                }
                else{
                
                mysqli_query($conn,"INSERT INTO sessions (username, last_seen) VALUES('".$_SESSION["Username"]."', Now())");
                
                }
    
    
    
    
    
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
   
   


  
          
          $dp = $_SESSION["Username"] ;
          
          
             $filename = "../users/$dp/notification/profilepic.svg";

            if (!file_exists($filename)) {
            
                   echo "<meta http-equiv='refresh' content='0,../chooseavatar.php' />";
                     exit;
                  
                  
                      }
            
   
 
     
   $username = $_SESSION["Username"];

   $notification =simplexml_load_file("../users/$username/notification/notification.xml");

   $_SESSION["notification"] = $notification->count();
   
   $loadclub =simplexml_load_file("../clubs/club.xml");
 
   $contcurntclubmssges = $loadclub->count();
   $newclubmasseges = $contcurntclubmssges -$_SESSION['countclubmessages'];
   
   
   
   $filenamewe = "../users/$username/notification/pinfriend.xml";

      if(!file_exists($filenamewe)) {
                 
                   $pindoc = new DOMDocument();
                
                   $pinfoo = $pindoc->createElement("apps");
                   $pinfoo->setAttribute("category", "essential");
                   $pindoc->appendChild($pinfoo);
                   
               
                   $pindoc->save("../users/$username/notification/pinfriend.xml");

                          }


?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Home</title>
<link href="../design.css" rel="stylesheet" type="text/css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="#f43e2e">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
img {
  float: right;
}
</style>

</head>
<body class=" body-define ProximaNovaRegular">
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

     <div class="tab "><a href="feed.php"><div class="actbor">FEED</div></a></div>
     
   
    <div class="tab"><a href="online.php"><div id="online" class="mytab bor">ONLINE 
      <div id="green" style="color:green;"  class="mytab"><?php  echo $_SESSION["onlineusers"] +200 ; ?> </div> </div></a></div>
  
  <div class="tab"><a href="inbox.php"><div id="inbox" class="mytab bor">CHATS 
      <div id="green" style="color:green;" class="mytab"><?php  echo $_SESSION["notification"] ; ?></div></div></a></div>
 
  
 </div>
 


<div class="emojibar" style="background-color:#E9E9E9;">
   <div >
              
  
    
   
    
    <div class="tab "><div style="font-size:13px;color:#A9A9A9"  class=" ProximaNovaRegular">Search</div></div>
    <div class="tab "><div style="font-size:13px;color:#A9A9A9"  class=" ProximaNovaRegular">@UPSC mains questions</div></div>
    <div class="tab "><a href="feed.php"><div style="font-size:13px;color:#A9A9A9"  class=" ProximaNovaRegular">@Essay</div></a></div>
    <div class="tab "><a href="feed.php"><div style="font-size:13px;color:#A9A9A9"  class=" ProximaNovaRegular">@Topics</div></a></div>
    <div class="tab "><a href="feed.php"><div style="font-size:13px;color:#A9A9A9"  class=" ProximaNovaRegular">@Memes</div></a></div>
   
    <div class="tab "><a href="feed.php"><div style="font-size:13px;color:#A9A9A9"  class=" ProximaNovaRegular">@Trending</div></a></div>
   
    
    
    </div>
    </div>




<div class="right-corder-container">
    <button class="right-corder-container-button">
       <a href="post.php"> <span class="short-text" >+</span></a>
    </button>
</div>




 <div class="member">
 
 




<?php

$xml =simplexml_load_file("../feed/feed.xml") or die("Error: Cannot create object"); // what user freind has sent
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
          
           if($message->tag == 'motive' ){
           
           $tag = ' &#8226 motive';
           }else{
           
            $tag = $message->tag ;
          }
          
          
       
          
           if($message->tag == '#post' ){
           
           $tag = ' &#8226 post';
           }
    

  ?>
  
 
  
  

  <div class="memlayt">
 

           <div class="dmotive">
           
           
     
     
                <form method="post" action="motive.php">
                <input type="hidden" name="recivernm" value="<?php echo $message->username ; ?>">
                 <input type="hidden" name="topic" value="<?php echo $message->topic ; ?>" class="dmotive">
                <input type="hidden" name="motive" value="<?php echo $message->post ; ?>" class="dmotive">
                <input type="hidden" name="statusID" value="<?php echo $message->time ; ?>" class="dmotive">
                <input type="hidden" name="postpic" value="<?php echo $message->postpic ; ?>" class="dmotive">
                <input type="hidden" name="tag" value="<?php echo $tag ; ?>" class="dmotive">
                
               
                
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
                
               
          <?php
       
              $qwer  = $message->username;
          
           if ($qwer != $username) {
          
          ?>
          
            <form method="post" action="core.php">
             
             <input type="hidden" name="recivernm" value="<?php echo $message->username; ?>">
              <button type="submit"  class="dmotive ProximaNovaRegular  " > <p style="font-size:13px;color:#A9A9A9"  class=" ProximaNovaRegular"><?php echo "@".$message->username."  ".$tag."" ; ?></p></button>
             </form>
             
             
              <div class="mytab"  >
           <form method="post" action="" >
        <input type="hidden" name="unpinname" value="<?php echo $withoutext; ?>">
    <input type="submit" class="canchat"  value ="<?php echo 'Pin'; ?>">
    </form>
      </div>
      
       <div class="mytab"  >
           <form method="post" action="" >
        <input type="hidden" name="unpinname" value="<?php echo $withoutext; ?>">
    <input type="submit" class="canchat"  value ="<?php echo 'Upvote'; ?>">
    </form>
      </div>
      
       <div class="mytab"  >
           <form method="post" action="" >
        <input type="hidden" name="unpinname" value="<?php echo $withoutext; ?>">
    <input type="submit" class="canchat"  value ="<?php echo 'Comments'; ?>">
    </form>
      </div>
             
             
              <div class="mytab" style="float: right;" >
           <form method="post" action="pinfriend.php" >
        <input type="hidden" name="unpinname" value="<?php echo $withoutext; ?>">
    <input type="submit" class="canchat"  value ="<?php echo 'Share'; ?>">
    </form>
      </div>
             
   
   <?php
   
   } else
   {
   ?>
   
   
             
             
              <button type="submit"  class="dmotive ProximaNovaRegular  " > <div style="font-size:13px;color:#A9A9A9"  class=" ProximaNovaRegular"><?php echo "@".$message->username."  ".$tag."" ; ?></div></button>
           
          
      
        <div class="mytab"  >
           <form method="post" action="" >
        <input type="hidden" name="unpinname" value="<?php echo $withoutext; ?>">
    <input type="submit" class="canchat"  value ="<?php echo 'Pin'; ?>">
    </form>
      </div>
      
       <div class="mytab"  >
           <form method="post" action="" >
        <input type="hidden" name="unpinname" value="<?php echo $withoutext; ?>">
    <input type="submit" class="canchat"  value ="<?php echo 'Upvote'; ?>">
    </form>
      </div>
      
       <div class="mytab"  >
           <form method="post" action="" >
        <input type="hidden" name="unpinname" value="<?php echo $withoutext; ?>">
    <input type="submit" class="canchat"  value ="<?php echo 'Comments'; ?>">
    </form>
      </div>
      
      
            <div class="mytab" style="float: right;" >
           <form method="post" action="" >
        <input type="hidden" name="unpinname" value="<?php echo $withoutext; ?>">
    <input type="submit" class="canchat"  value ="<?php echo 'Share'; ?>">
    </form>
      </div>
      
   
   <?php
   }
   
   
   
   ?>
   
 </div>
      
        </div>

<br>

<?php
      }
     }
   
   
   $count++;
 }



?>


</div>






<script src="../Relative Design.js"></script>
</body>
</html>


