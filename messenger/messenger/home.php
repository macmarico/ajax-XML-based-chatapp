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
   
  
   
   
   
   $filenamewe = "../users/$username/notification/pinfriend.xml";

      if(!file_exists($filenamewe)) {
                 
                   $pindoc = new DOMDocument();
                
                   $pinfoo = $pindoc->createElement("apps");
                   $pinfoo->setAttribute("category", "essential");
                   $pindoc->appendChild($pinfoo);
                   
               
                   $pindoc->save("../users/$username/notification/pinfriend.xml");

                          }
                          
                          
                          
                          
     
     
if (!empty($_POST['changemotive'])) {

if(isset($_POST['changemotive'])){

  
  $motive = addslashes($_POST['changemotive']);
  $statusID = time();
  
  $sqlmotive = "UPDATE sessions SET status = '".$motive."' WHERE username= '".$_SESSION["Username"]."'";
    
    mysqli_query($conn, $sqlmotive);
    
     $sqlmotive = "UPDATE sessions SET statusID = '".$statusID."' WHERE username= '".$_SESSION["Username"]."'";
    
    mysqli_query($conn, $sqlmotive);
    
    
    $sqlmotiveusers = "UPDATE users SET status = '".$motive."' WHERE Username= '".$_SESSION["Username"]."'";
    
    mysqli_query($conn, $sqlmotiveusers);
    
     $sqlmotiveusers = "UPDATE users SET statusID = '".$statusID."' WHERE Username= '".$_SESSION["Username"]."'";
    
    mysqli_query($conn, $sqlmotiveusers);
    
    
    
    $filename2 = "../users/$username/posts/files/$statusID/$statusID.xml";

    if(!file_exists($filename2)) {
    
          mkdir("../users/$username/posts/files/$statusID");
          mkdir("../users/$username/posts/files/$statusID/storage");
          mkdir("../users/$username/posts/files/$statusID/storage/post");
          mkdir("../users/$username/posts/files/$statusID/storage/comment");
          

          $doc = new DOMDocument();
          $foo = $doc->createElement("messages");
          $foo->setAttribute("category", "short");
          $doc->appendChild($foo);
          $doc->save("../users/$username/posts/files/$statusID/$statusID.xml");
          
          
       $post = stripslashes($motive);
      
        $sxepostlist = simplexml_load_file("../users/$username/posts/postlist.xml");
        $moviepostlist = $sxepostlist->addChild('postset');
        $eepostlist = $moviepostlist->addChild('username', "$username");
        $eepostlist = $moviepostlist->addChild('statusID', "$statusID");
        $eepostlist = $moviepostlist->addChild('post', "$post");
        $eepostlist = $moviepostlist->addChild('tag', 'motive');
       
        $sxepostlist->asXML("../users/$username/posts/postlist.xml");
      
      
      
        $sxe = simplexml_load_file("../feed/feed.xml");
        $movie = $sxe->addChild('postset');
        $ee = $movie->addChild('username', "$username");
        $ee = $movie->addChild('time', time());
        $ee = $movie->addChild('post', "$post");
        $ee = $movie->addChild('tag', 'motive');
        $sxe->asXML("../feed/feed.xml");


          }
    
     
   }
   }
     
     
     
     
     


?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Home</title>
<link href="../design.css" rel="stylesheet" type="text/css">
<link href="../design/feed.css" rel="stylesheet" type="text/css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="#f43e2e">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  

 
 
 
 <style>
body {font-family: Arial, Helvetica, sans-serif;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
  -webkit-animation-name: fadeIn; /* Fade in the background */
  -webkit-animation-duration: 0.4s;
  animation-name: fadeIn;
  animation-duration: 0.4s
}


.chatroomModal{
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
 
  -webkit-animation-name: fadeIn; /* Fade in the background */
  -webkit-animation-duration: 0.4s;
  animation-name: fadeIn;
  animation-duration: 0.4s
}


/* Modal Content */
.modal-content {


  border:2px solid #A9A9A9;
  position: fixed;
  bottom: 0;
  background-color: #fefefe;
  width: 100%;
  -webkit-animation-name: slideIn;
  -webkit-animation-duration: 0.4s;
  animation-name: slideIn;
  animation-duration: 0.4s
}

/* The Close Button */
.close {
  color: white;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}

.modal-header {
  padding: 2px 16px;
  background-color: #333;
  color: white;
}

.modal-body {padding: 2px 16px;}



/* Add Animation */
@-webkit-keyframes slideIn {
  from {bottom: -300px; opacity: 0} 
  to {bottom: 0; opacity: 1}
}

@keyframes slideIn {
  from {bottom: -300px; opacity: 0}
  to {bottom: 0; opacity: 1}
}

@-webkit-keyframes fadeIn {
  from {opacity: 0} 
  to {opacity: 1}
}

@keyframes fadeIn {
  from {opacity: 0} 
  to {opacity: 1}
}


</style>
 
 
 
 

</head>
<body class=" body-define ProximaNovaRegular"  onload="fetch()">
<div id="anchor"></div>
 <div class="adj" style=" height: 53px" id ="topBar" ><div id = "backButton" style= "color : white ; display:inline-block;" onclick="chatroomBack()" >back</div>
    
    <div id="usn" class="gtc "><a href="setting.php">
    <div class="row">
        <div class="b1"  >
          <img id="headerpic" src=
          
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
        <div class="b2 unadj" id = "usernameHead" >
           <?php
echo "".$_SESSION['Username'].""; 
?> 
             
     
        </div>
    </div> </a></div>

    <div class=" notifs" id ="logout"><a href="setting.php">
      <form method="get" action="../logout.php">
    <button type="submit" class="lgbut">Logout</button>
</form></a></div>
    </div>
 
 
 
 <div id= "NavTab">
<div class="tabs stickdiv" >


    <div class="tab"><div onclick="myFunction2()" id="online" class="actbor">ONLINE 
      <div id="green" style="color:green;"  class="mytab"><?php  echo $_SESSION["onlineusers"] +200 ; ?> </div> </div></div>
  
  <div class="tab"><div onclick="myFunction3()" id="inbox" class="mytab bor">CHATS 
      <div id="notification" style="color:green;" class="mytab"></div></div></div>
 
  
 </div>
 
 </div>
 
 
 
 
 





<!-- online section -->



<div id="myDIV2">


<div class="msgbar mbc">
       <div class="msgtab">
<div class="row">
        <div class="b1" >
          <img src=
          
          
          <?php
          
          
          
          
             $filename = "../users/$username/notification/profilepic.svg";

            if (file_exists($filename)) {
                  echo "$filename";
                      } else {
                       echo "../contact.svg";
                }
            ?>
          
          
          
          
          
          
          
          width="50px" alt="avatar" style="border-radius: 45px;">
        </div>
        <div class="b2 statwidth" >
           <div class="dstatus">
    

      <?php
           
           
           $sqlstatus = "SELECT status, statusID FROM sessions WHERE username= '".$username."'";
    
                $check = mysqli_fetch_assoc(mysqli_query($conn, $sqlstatus));
                
                if(!empty($check["status"]))
                {
                echo $check["status"];
                }else{ echo "Set your motive" ;}
                
                ?>
                

                <span>
                
                <?php
                $statusID = $check["statusID"];
                $filemotive = "../users/$username/posts/files/$statusID/$statusID.xml";

                if(file_exists($filemotive)) {
                $loadmotive =simplexml_load_file("../users/$username/posts/files/$statusID/$statusID.xml");
                $contcurntmotivemssges = $loadmotive->count();
                $newmotivemasseges = $contcurntmotivemssges -$_SESSION['countmotivemessages'];
                
                ?>
                 <form method="post" action="motive.php" class="emojiform">
                 <input type="hidden" name="motive" value="<?php echo $check["status"]; ?>">
                 <input type="hidden" name="statusID" value="<?php echo $statusID; ?>">
                 <input type="hidden" name="recivernm" value="<?php echo $username; ?>">
                  <input type="hidden" name="tag" value="<?php echo '&#8226 motive' ; ?>" class="dmotive">
      
                 <input type="submit"  class="batch ProximaNovaRegular  " value ="<?php echo $newmotivemasseges; ?>">
    
                </form>
                
              <?php  
                
                }
                else
                { 
                ?>
                
                  <form   class="emojiform">
                 <input type="hidden" name="motive" value="<?php echo $check["status"]; ?>">
                 <input type="hidden" name="recivernm" value="<?php echo $username; ?>">
                 <input type="hidden" name="statusID" value="<?php echo $statusID; ?>">
                 
                <input type="hidden" name="tag" value="<?php echo '&#8226 motive' ; ?>" class="dmotive">
                 <input type="submit"  class="batch ProximaNovaRegular  " value ="<?php echo '0'; ?>">
    
                </form>
                
                <?php
                
                }
               
                ?>
                </span>
                
                
                
                
    <form method="post" action="home.php">
      <div class="row postbar" >
      <div  style="width: 78%">
        <input type="text" name="changemotive"  placeholder="Change motive/status"  autocomplete="off" class="postinput" style= "  border-radius: 25px;" required />
      </div>
        <div style="width: 20%">
            <input type="submit" name="login" value="SET" class="postbut" style= "  border-radius: 25px;">
              </div>
            </div>

        </form>

      
        </div>


    </div>
</div>
 </div>
</div>


 <div class="member">
 
 
 
 
 
 
 
 
 
 
 
 

<?php

$sql = "SELECT * FROM sessions";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {

    if ($row["username"] != $username) {



      $checkblocked = mysqli_query($conn,"SELECT * FROM blocked WHERE Username = '".$row["username"]."'");
         
        if (mysqli_num_rows($checkblocked) == 0) {  
          
           $x = '0';
          $personalblock = "../users/$username/notification/blocked.xml";
           if (file_exists($personalblock)) {

              $personalblock =simplexml_load_file("../users/$username/notification/blocked.xml");
              $checkpersonalblock = $personalblock->$row["username"] ;
              $x =  $checkpersonalblock->count();

           }

        
          if($x == "0"){

                $dp = $row["username"];

       ?>



<div class="memlayt" style= "border-bottom: 3px solid #f9f9f9; margin-top:10px; padding-bottom:10px;">
<div class="row">
        <div class="b1" >
        
        
        
         <form method="post" action="core.php">
          <input type="hidden" name="recivernm" value="<?php echo $row["username"]; ?>">
    
  <input type="image" src="../users/<?php echo $dp; ?>/notification/profilepic.svg" width="30px" class="mpic"  alt="Submit" >
        </form>
        
        
         
        </div>
        <div class="b2 statwidth" >
           <div class="dstatus">
    
           
      <?php
           
           
           $sqlstatus = "SELECT status, statusID FROM sessions WHERE username= '".$row["username"]."'";
    
                $check = mysqli_fetch_assoc(mysqli_query($conn, $sqlstatus));
                
                if(!empty($check["status"]))
                {
                
                ?>
               
               
                <button type="submit" class="dstatus ProximaNovaRegular" > <?php echo $check["status"]; ?><span>  </span><span style="font-size:16px" class="fa">   &#xf112;</span></button>
               
                <?php
             
                
                }else{ echo 'no status' ;}
                
                ?>
                

    
   </div style="height: 13px;">
             <div ><input type="hidden" name="recivernm" value="<?php echo $row["username"]; ?>">
     <input type="submit" class="stsname ProximaNovaRegular  " value ="<?php echo $row["username"]; ?>"  onclick= "chatroom(this);" >
      </div>
      
        </div>
         

   
    
 


 </div>
      
        </div>




        


           <?php } ;

         }
    }

  }
} else {
    echo "0 results";
}


 

?>
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 <!-- dummy users start  -->
 
 
 
 
 
 
 
 
 
 

 

<?php

$sql = "SELECT * FROM demosessions ORDER BY RAND() ";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {

    if ($row["username"] != $username) {



      $checkblocked = mysqli_query($conn,"SELECT * FROM blocked WHERE Username = '".$row["username"]."'");
         
        if (mysqli_num_rows($checkblocked) == 0) {  
          
           $x = '0';
          $personalblock = "../users/$username/notification/blocked.xml";
           if (file_exists($personalblock)) {

              $personalblock =simplexml_load_file("../users/$username/notification/blocked.xml");
              $checkpersonalblock = $personalblock->$row["username"] ;
              $x =  $checkpersonalblock->count();

           }

        
          if($x == "0"){

                $dp = $row["username"];

       ?>


 <div class="memlayt" style= "border-bottom: 3px solid #f9f9f9; margin-top:10px; padding-bottom:10px;">
<div class="row">
        <div class="b1" >
        
        
        
         <form method="post" action="core.php">
          <input type="hidden" name="recivernm" value="<?php echo $row["username"]; ?>">
    
  <input type="image" src="../users/<?php echo $dp; ?>/notification/profilepic.svg" width="30px" class="mpic"  alt="Submit" >
        </form>
        
        
         
        </div>
        <div class="b2 statwidth" >
           <div class="dstatus">
    
           
      <?php
           
           
           $sqlstatus = "SELECT status FROM demosessions WHERE username= '".$row["username"]."'";
    
                $check = mysqli_fetch_assoc(mysqli_query($conn, $sqlstatus));
                
                if(!empty($check["status"]))
                {
                
                ?>
               
               
                <button type="submit" class="dstatus ProximaNovaRegular"> <?php echo $check["status"]; ?><span>  </span><span style="font-size:16px" class="fa">   &#xf112;</span></button>
               
                <?php
             
                
                }else{ echo 'no status' ;}
                
                ?>
                

  
   </div style="height: 13px;">
             <div ><input type="hidden" name="recivernm" value="<?php echo $row["username"]; ?>">
     <input type="submit" class="stsname ProximaNovaRegular  " value ="<?php echo $row["username"]; ?>"  onclick= "chatroom(this);" >
      </div>
      
        </div>
         

   
    
 </div>
      
        </div>




        


           <?php } ;

         }
    }

  }
} else {
    echo "0 results";
}

mysqli_close($conn);
 

?> 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 <div class="memlayt" style= "border-bottom: 3px solid #f9f9f9; margin-top:10px; padding-bottom:10px;">
<div class="row" >
        <div class="b1" >
     
  <input type="hidden" name="profilename" value="mac">
  <input type="image" src="../users/torje/notification/profilepic.svg" width="30px" class="mpic"  alt="Submit" >
        </form>
        
     
        </div>
        <div class="b2 statwidth" >
           <div class="dstatus">
        
                <button type="submit" class="dstatus ProximaNovaRegular  ">let's talk about post covid word<span>  </span><span style="font-size:16px" class="fa">   &#xf112;</span></button>


   </div style="height: 13px;">
             <div ><input type="hidden" name="recivernm" value="mac">
     <input type="submit" class="stsname ProximaNovaRegular  " value ="burt"  onclick= "chatroom(this);" >
      </div>
      
        </div>
  
 </div>
 </div>
 
 
 
<div class="memlayt" style= "border-bottom: 3px solid #f9f9f9; margin-top:10px; padding-bottom:10px;">
<div class="row">
        <div class="b1" >
     
  <input type="hidden" name="profilename" value="mac">
  <input type="image" src="../users/rashika/notification/profilepic.svg" width="30px" class="mpic"  alt="Submit" >
        </form>
        
     
        </div>
        <div class="b2 statwidth" >
           <div class="dstatus">
        
                <button type="submit" class="dstatus ProximaNovaRegular  " >Why india needs revival of SAARC.<span>  </span><span style="font-size:16px" class="fa">   &#xf112;</span></button>

    
   </div style="height: 13px;">
             <div ><input type="hidden" name="recivernm" value="mac">
     <input type="submit" class="stsname ProximaNovaRegular  " value ="rashika "  onclick= "chatroom(this);" >
      </div>
      
        </div>
  
 </div>
 </div>
 
 
 
 
 <div class="memlayt" style= "border-bottom: 3px solid #f9f9f9; margin-top:10px; ">
<div class="row">
        <div class="b1" >
     
  <input type="hidden" name="profilename" value="mac">
  <input type="image" src="../users/gaga/notification/profilepic.svg" width="30px" class="mpic"  alt="Submit" >
        </form>
        
     
        </div>
        <div class="b2 statwidth" >
           <div class="dstatus">
        
                <button type="submit" class="dstatus ProximaNovaRegular  "> anyone from mumbai<span>  </span><span style="font-size:16px" class="fa">   &#xf112;</span></button>

    
   </div style="height: 13px;">
             <div ><input type="hidden" name="recivernm" value="mac">
     <input type="submit" class="stsname ProximaNovaRegular  " value ="anu"  onclick= "chatroom(this);" >
      </div>
      
        </div>
   
 </div>
 </div>
 
 
 
 
 
 
 
 
 
<!-- dummy users end   -->
 
 
 
 
</div>







</div>




<!-- online section end   -->




<div id="myDIV3">


 

<div class="set">

  <a href="#anchor"><div style="font-size: 15px; color: #999">new messages</div></a>
</div>

<div class="inboxSec cmsgin" id="NewMessages">

</div>

<div class="set">
  <a href="#anchor"><div style="font-size: 15px; color: #999">pinned</div></a>
</div>



<div class="inboxSec cmsgin" id="pins">

</div>

</div>





<div style="padding-top:55px;" id="chatroom">



 <div class="msgbar" style = " position: fixed; width: 100%; bottom: 0px;">
    <div class="msgtab">
    
    <button id="chatrooMyBtn" style=" float:left;background-color: transparent; border: none; padding-top:3px;"  >
  <svg width="2.5em" height="2.5em" viewBox="0 0 16 16" class="bi bi-plus-circle-fill" fill="grey" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4a.5.5 0 0 0-1 0v3.5H4a.5.5 0 0 0 0 1h3.5V12a.5.5 0 0 0 1 0V8.5H12a.5.5 0 0 0 0-1H8.5V4z"/>
</svg>
    
     </button>    
     
     
    
      <form method="get" action="parts/chatcore.php" id="formpost" name="formpost" class="formpost" style="display:inline-block;">
      
     
    <textarea rows="1" style="width:225px; border-radius: 15px; height:40px; font-size: 17px; float:left;"   oninput='this.style.height = "40px";this.style.height = this.scrollHeight + "px"'  type="text" name="message" id= "uxs" placeholder="Type Message" class="width ProximaNovaRegular inpdes " autocomplete="off" required></textarea>
         <input type="hidden" id = "receivernm" name="recivernm" value=""/>
         
           
      
     
        <div  style="float:left;">
        
            <button  type="submit" name="login" style="background-color: transparent; border: none;"  onClick="messageappend(document.getElementById('uxs').value,'<?php echo $username;?>','sec')  ">
          
          <svg width="2.9em" height="2.9em" viewBox="0 0 16 16" class="bi bi-arrow-right-circle-fill" fill="#f43e2e" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-8.354 2.646a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L9.793 7.5H5a.5.5 0 0 0 0 1h4.793l-2.147 2.146z"/>
</svg>
          
       </button>   
          </div>
          
          
        </form>
        

  
  </div>
  
  
  
  
  
  
  
  
  
  
  

<div id="chatroomModal" class="chatroomModal">

  <!-- Modal content -->
  <div class="modal-content" style="border-radius: 15px; margin-bottom:80px;">
  
      <span class="messageTabClose">&times;</span>
    
  
    <div class="modal-body">
    
    
    
    
    
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
  
    <form method="post" action="club.php" class="emojiform" id="emojiform">
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
   
    
    
    
    
    
    
    
    
    <br>
    <div class="emojibar">
   <div >
             
  
   
     &nbsp; &nbsp;  &nbsp;
      <input type="image" src="../images/add.svg" width="30px" class="emoji"  alt="Submit" > &nbsp;  &nbsp;
      
      <input type="image" src="../images/gallery.svg" width="30px" class="emoji"  alt="Submit" > &nbsp;  &nbsp;
      
      <input type="image" src="../images/google-docs.svg" width="30px" class="emoji"  alt="Submit" > &nbsp;  &nbsp;
      
      <input type="image" src="../images/headset.svg" width="30px" class="emoji"  alt="Submit" > &nbsp;  &nbsp;
      
      <input type="image" src="../images/pin.svg" width="30px" class="emoji"  alt="Submit" > &nbsp;  &nbsp;
      
      <input type="image" src="../images/smile.svg" width="30px" class="emoji"  alt="Submit" >
    
    
   
   
    
    </div>
    </div>
    
      
      
      
      
          
          
       
      
      
      
      
      
      
      
      
      
      
      
    </div>
   
  </div>

</div>


  
  
  
  
  
  
  
  
  
  
  



</div>







<script>




function messageappend(message,username,time) {

     var node2 = document.createElement("div");
  node2.className = 'msgtime b1';

   var node1 = document.createElement("div");
  node1.className = 'b2 msginname';

  var node = document.createElement("div");
       node.className = 'containerchatboxfont';     
  
  
  
  if(username == '<?php echo $username;?>'){
  
   var uniq = 'id' + (new Date()).getTime();
   var noderow = document.createElement("div");
  noderow.className = 'containerchatbox clearfix';
  noderow.id = uniq;
  
    var imgNode = document.createElement('img'); 
      imgNode.src = "../users/"+username+"/notification/profilepic.svg";
      imgNode.className = 'nmdismsgicon';
  
  
  }else{
  
  
  var uniq = 'id' + (new Date()).getTime();
   var noderow = document.createElement("div");
  noderow.className = 'containerchatbox darkerchatbox'; 
  noderow.id = uniq;
  
  var imgNode = document.createElement('img'); 
      imgNode.src = "../users/"+username+"/notification/profilepic.svg";
      imgNode.className = 'nmdismsgiconLeft';
  
  
  }
  

   
 
  
  var textnode2 = document.createTextNode(time);
   var textnode1 = document.createTextNode(username);
  var textnode = document.createTextNode(message);
  node.appendChild(textnode);
   node1.appendChild(textnode1);
  
   
    noderow.appendChild(node);
    noderow.appendChild(imgNode);
   
  
   document.getElementById("messagesSection").appendChild(noderow);
    
         var objDiv = document.getElementById("messagesSection");
     objDiv.scrollTop = objDiv.scrollHeight;

  
  
 
 
}


function pin(pname) {

          
           
$.ajax({  
    type: 'POST',  
    url: 'parts/pincore.php', 
    data: { friendname: pname.value  },
    success: function(response) {
        content.html(response);
    }
});
   

     pinnedSec();

 
 
 }
 
 
 function unpin(pname) {

          
           
$.ajax({  
    type: 'POST',  
    url: 'parts/pincore.php', 
    data: { unpinname: pname.value  },
    success: function(response) {
        content.html(response);
    }
});
   

     pinnedSec();

 
 
 }
 
 
 
 
 
 
 function foo() {



var xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
          var xmlDoc = this.responseXML;
    
    var nodes = xmlDoc.getElementsByTagName('notifset'), 
    amountOfNodes = nodes.length ;
    
     
    
          
           if(nodes.length > 0){
           loadchats();
           
           
           
            var xr = document.getElementById("chatroom");
  if (window.getComputedStyle(xr).display === "block") {
    loadmessages();// Do something..
  }
           
           
     }
     
      document.getElementById("notification").innerHTML = amountOfNodes;
           
           
           
    
    }
};
xhttp.open("GET", "../users/<?php echo $username; ?>/notification/notification.xml", true);

xhttp.setRequestHeader('Cache-Control', 'no-cache');
xhttp.send();


setTimeout(foo, 1000);

}

foo();








function loadchats() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      NewMessages(this);
    }
  };
  xhttp.open("GET", "../users/<?php echo $username; ?>/notification/notification.xml", true);
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
    + name +"/notification/profilepic.svg" + "\" width=\"30px\" height=\"30x\" alt=\"avatar\" style=\"border-radius: 45px;\" class=\"image\" ></div><input type=\"button\" value="+name+" class=\"simbut ProximaNovaRegular\"  onclick=\'chatroom(this);  \' > <div class=\"mytab\" style=\"float: right;\" ><input type=\"submit\" class=\"canchat\"  value ="+name+"  onclick=\'pin(this);\'></div><div class=\"msgoriginal\"> </div></div>";
    rowsArray.push(row)
    repusername.push(name)
    }
  }
        
     
 
   
  table += rowsArray.join('');
  document.getElementById("NewMessages").innerHTML = table;
  
}
  
   

function pinnedSec() {

var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      PinnedPeople(this);
    }
  };
  xhttp.open("GET", "../users/<?php echo $username; ?>/notification/pinfriend.xml", true);
  xhttp.setRequestHeader('Cache-Control', 'no-cache');
  xhttp.send();
  
  
  
  }

function PinnedPeople(xml) {
  var rowsArray =[]
  var i ;
  var xmlDoc = xml.responseXML;
  var table="";
  var x = xmlDoc.getElementsByTagName("personset");
  

  
  for (i = 0; i < x.length; i++) {
  
  
  
  var name = x[i].getElementsByTagName("username")[0].childNodes[0].nodeValue;
  

    
    var row = "<div class=\"row\"><div class=\"b1\" ><img src=\"" + "../users/"    
    + name +"/notification/profilepic.svg" + "\" width=\"30px\" height=\"30x\" alt=\"avatar\" style=\"border-radius: 45px;\" class=\"image\" ></div><input type=\"button\" value="+name+" class=\"simbut ProximaNovaRegular\"  onclick=\'chatroom(this);  \' ><div class=\"mytab\" style=\"float: right;\" ><input type=\"submit\" class=\"canchat\" value ="+name+"   onclick=\'unpin(this);  \' ></div><div class=\"msgoriginal\"></div></div>";
    
    
    rowsArray.push(row)
  
    
  }
        
     
 
   
  table += rowsArray.join('');
  document.getElementById("pins").innerHTML = table;
  
}
  
   




function chatroom(s) {




 window.rfjd = s.value;
 
 
 
 
 var messSecCreate = document.createElement("div");
  messSecCreate.className = 'messeging cmsgin';
  messSecCreate.id = "messagesSection";
  
  
  
   var list = document.getElementById("chatroom");
   list.insertBefore(messSecCreate, list.childNodes[0]);
 
 
 
document.getElementById("usernameHead").innerHTML = rfjd;
 document.getElementById("receivernm").value = rfjd;
document.getElementById("NavTab").style.display = "none";
document.getElementById("myDIV2").style.display = "none";
document.getElementById("myDIV3").style.display = "none";
document.getElementById("logout").style.display = "none";
document.getElementById("chatroom").style.display = "block";
 document.getElementById("backButton").style.display = "inline-block";
 document.getElementById("topBar").style.position = "fixed";
 document.getElementById("headerpic").src = "../users/"+s.value+"/notification/profilepic.svg";
 
 
 
 // load old message START
 
 
 
 
 
 
 
 

function loadOldMessages() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      oldMessages(this);
    }
  };
  xhttp.open("GET", "../users/<?php echo $username; ?>/"+s.value+".xml", true);
  xhttp.setRequestHeader('Cache-Control', 'no-cache');
  xhttp.send();
}



 
 function oldMessages(xml) {
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
 
  return "<input type=\"image\" src=\""+wrapInDiv(messageSetNode.getElementsByTagName("link")[0].childNodes[0].nodeValue)+"\" width=\"30%\" class=\"emoji\"  alt=\"Submit\" >";
}

  
  for (i = 0; i < x.length; i++) {
  var name = x[i].getElementsByTagName("username")[0].childNodes[0].nodeValue;
  var time = x[i].getElementsByTagName("time")[0].childNodes[0].nodeValue;
  

    
     messageappend(getMessage(x[i]),name,convert(time));
     
     
  }
  
  
 

 
}
 
loadOldMessages(); 
 
 
  // load old message END
 
 
 

}





function myFunction2() {


   
    document.getElementById("online").className = "actbor";
    document.getElementById("inbox").className = "mytab bor ";

   document.getElementById("myDIV2").style.display = "block";
 
  document.getElementById("myDIV3").style.display = "none";
  
  
}

function myFunction3() {



document.getElementById("online").className = "mytab bor";
document.getElementById("inbox").className = "actbor ";


 document.getElementById("NavTab").style.display = "block";
  document.getElementById("myDIV2").style.display = "none";
 
  document.getElementById("myDIV3").style.display = "block";
   document.getElementById("backButton").style.display = "none";
    document.getElementById("chatroom").style.display = "none";
     document.getElementById("backButton").style.display = "none";
 document.getElementById("topBar").style.position = "";
 document.getElementById("usernameHead").innerHTML = "<?php echo $username;?>";
    
    
    pinnedSec();
    
    
  
}








function chatroomBack() {



$.ajax({  
    type: 'POST',  
    url: 'parts/notification.php', 
    data: { personName: window.rfjd  },
    success: function(response) {
        content.html(response);
    }
});


 var messageSec = document.getElementById("messagesSection");
  messageSec.remove();


document.getElementById("online").className = "mytab bor";
document.getElementById("inbox").className = "actbor ";


 document.getElementById("NavTab").style.display = "block";
  document.getElementById("myDIV2").style.display = "none";
  
  document.getElementById("myDIV3").style.display = "block";
   document.getElementById("backButton").style.display = "none";
    document.getElementById("chatroom").style.display = "none";
     document.getElementById("backButton").style.display = "none";
 document.getElementById("topBar").style.position = "";
 document.getElementById("usernameHead").innerHTML = "<?php echo $username;?>";
  
    
  
}









 document.getElementById("myDIV2").style.display = "block";

 document.getElementById("myDIV3").style.display = "none";
 document.getElementById("backButton").style.display = "none";
 document.getElementById("chatroom").style.display = "none";
 
 
 



function convert(ts)
{ 

 // This function computes the delta between the
    // provided timestamp and the current time, then test
    // the delta for predefined ranges.

    var d=new Date();  // Gets the current time
    var nowTs = Math.floor(d.getTime()/1000); // getTime() returns milliseconds, and we need seconds, hence the Math.floor and division by 1000
    var seconds = nowTs-ts;

    // year
    if (seconds > 365*24*3600) {
       return Math.floor(seconds/(365*24*3600)) + "y";
    }
    // a day
    if (seconds > 24*3600) {
       return Math.floor(seconds/(24*3600)) + "d";
    }

    if (seconds > 3600) {
       return Math.floor(seconds/3600) + "h";
    }
    if (seconds > 1800) {
       return "30m";
    }
    if (seconds > 60) {
       return Math.floor(seconds/60) + "m";
    }
     if (seconds < 60) {
       return  "sec";
    }

}



function loadmessages() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      messages(this);
    }
  };
  xhttp.open("GET", "../users/<?php echo $username; ?>/notification/notification.xml", true);
  xhttp.setRequestHeader('Cache-Control', 'no-cache');
  xhttp.send();
}



 
 
$(function() {
    $("#formpost").submit(function(event) {
        event.preventDefault();

        var form = $(this);
        var url = form.attr('action');

        $.ajax({
            cache : false,
            type: "POST",
            url: url,
            data: form.serialize() // serializes the form's elements.
        }).done(function(data) {
            var msg = $(data).find('#msg').text();

           
        });
    });
}); 

  $(document).on("submit", "#emojiform", function(event)
{
    event.preventDefault();        
    $.ajax({
    
        cache: false,
        url: $(this).attr("action"),
        type: $(this).attr("method"),
        dataType: "JSON",
        data: new FormData(this),
        processData: false,
        contentType: false,
        success: function (data, status)
        {

        },
        error: function (xhr, desc, err)
        {


        }
    });        
});function messages(xml) {
  var rowsArray =[]
  var i ;
  var xmlDoc = xml.responseXML;
  var table="";
  var x = xmlDoc.getElementsByTagName("notifset");
  var getMessage = function(messageSetNode) {
  var wrapInDiv = function(msg) {
    return   msg ;
  }
  var messageNode = messageSetNode.getElementsByTagName("message")[0]; 
  if(messageNode) {
    return wrapInDiv(messageNode.childNodes[0].nodeValue);
  }
 
  return "<input type=\"image\" src=\""+wrapInDiv(messageSetNode.getElementsByTagName("link")[0].childNodes[0].nodeValue)+"\" width=\"30%\" class=\"emoji\"  alt=\"Submit\" >";
}

  
  for (i = 0; i < x.length; i++) {
  var name = x[i].getElementsByTagName("username")[0].childNodes[0].nodeValue;
  var time = x[i].getElementsByTagName("time")[0].childNodes[0].nodeValue;
  
  
  if(name == window.rfjd){
  
   
    
    
     messageappend(getMessage(x[i]),name,convert(time));
     
     
     $.ajax({  
    type: 'POST',  
    url: 'parts/notification.php', 
    data: { personName: window.rfjd  },
    success: function(response) {
        content.html(response);
    }
});


    
    }
  }
  
  
 

 
}





// feed content 





  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
    
    appendFeedPost(this);
    
   
      
    }
  };
  xhttp.open("GET", "../feed/feed.xml", true);
  xhttp.setRequestHeader('Cache-Control', 'no-cache');
  xhttp.send();




function appendFeedPost(xml){
var rowsArray =[];
  
  var xmlDoc = xml.responseXML;
  var table="";
  var x = xmlDoc.getElementsByTagName("postset");
  var i  ;
  
  for (i = x.length-1; i>=0; i--) {
  var name = x[i].getElementsByTagName("username")[0].childNodes[0].nodeValue;
  var post = x[i].getElementsByTagName("post")[0].childNodes[0].nodeValue;
 
  
  
  
  

     
     
      var postNode = document.createElement("div");
       postNode.className = 'feedLayt';     
  
    var ProfilePicNode = document.createElement('img'); 
      ProfilePicNode.src = "../users/"+name+"/notification/profilepic.svg";
      ProfilePicNode.className = 'PostProfilePic';
      
       var feedPostUsernameNode = document.createElement("div");
           feedPostUsernameNode.className = 'postusername';
           
       var feedPostTopicNode = document.createElement("div");
           feedPostTopicNode.className = 'feedPostTopic';
           
       var feedPostContentNode = document.createElement("div");
           feedPostContentNode.className = 'PostContent';
           
           
           
        
   var usernameNode = document.createTextNode(name);
  var messageNode = document.createTextNode(post);
  feedPostUsernameNode.appendChild(usernameNode);
   feedPostContentNode.appendChild(messageNode);
   
  
  
  
   document.getElementById("IDfeedSection").appendChild(postNode);
   
  postNode.appendChild(ProfilePicNode);
   
  postNode.appendChild(feedPostUsernameNode);
   
  postNode.appendChild(feedPostTopicNode);
   
  postNode.appendChild(feedPostContentNode);
  
  
  
     
     
     
     
     
     
     
     
 
  }
  







}











// feed content close






















</script>



<script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>




<script>

// chatroom message tab modal

// Get the modal
var chatroomModal = document.getElementById("chatroomModal");

// Get the button that opens the modal
var chatroomBtn = document.getElementById("chatrooMyBtn");

// Get the <span> element that closes the modal
var span1 = document.getElementsByClassName("messageTabClose")[0];

// When the user clicks the button, open the modal 
chatroomBtn.onclick = function() {
  chatroomModal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span1.onclick = function() {
  chatroomModal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    chatroomModal.style.display = "none";
  }
}
</script>








<script src="../Relative Design.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-JAW99MJVpJBGcbzEuXk4Az05s/XyDdBomFqNlM3ic+I=" crossorigin="anonymous"></script>
<!-- ** Don't forget to Add jQuery here ** -->
</body>
</html>


