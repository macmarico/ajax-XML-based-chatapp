<?php
include "../base.php";

unset ($_SESSION["recivernmsess"]);

if(empty($_SESSION['LoggedIn']) && empty($_SESSION['Username']))
{
        echo "<meta http-equiv='refresh' content='0,../home.php' />";
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
<title>Sweeters</title>
<link href="../pcdesign.css" rel="stylesheet" type="text/css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  
  
  <style>
 

.dmotive{
    width: 100%;
  padding: 0px 5px;
  font-size: 25px;
        border:none;
        background:white;
        text-align:justify;
        cursor:pointer;
        border-radius: 15px;
         word-wrap: break-word;

}

.memlayt{
  width: 90%;
  margin: auto;
  padding: 3px 5px;
  
}


img.sharedimg {
  width: 75%;
  margin: 5px 0px;
  padding: 5px;
  border-radius: 5%;
  border: 1px solid #f1f1f1; 
}

.mytab{
  display: inline-block;  
}


.canchat{
  color: #c61313;
  background-color: #fff;
  border-radius: 45px;
  padding: 3px 7px;
  margin-right: right:3px;
  border:none;
  font-weight: bold;
  height: 34px;
}






.right-corder-container {
    position:fixed;
    right:43%;
    bottom:20px;
}


.right-corder-container .right-corder-container-button {
    height: 62px;
    width: 62px;
    border:none;
    background-color:#f43e2e;
    border-radius: 62px;        /*Transform the square into rectangle, sync that value with the width/height*/
    transition: all 300ms;      /*Animation to close the button (circle)*/
    box-shadow:2px 2px 5px   ;
    cursor:pointer;
}


.right-corder-container .right-corder-container-button span {
    font-size: 72px;
    color:white;
    position: absolute;
    left: 10px;
    top: 16px;
    line-height: 28px;
}




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

/* Modal Content */
.modal-content {
  position: absolute;
  border-radius: 15px;
  bottom: 0;
  background-color: #fefefe;
  width:  calc(48.2% - 2px);
  margin-left: 11%;
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
  text-align:center;
  border-radius: 15px;
  background-color:#333;
  color: white;
}

.modal-body {padding: 2px 16px;}

.modal-footer {
  padding: 2px 16px;
  background-color: #f43e2e;
  color: white;
}

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
<body class="body ProximaNovaRegular" >
 <div class="content" >
 	<div class="leftbar ">
        <div class="container profile">
            <div class="rowcontainer dp">
                <img src="../users/<?php echo $username;?>/notification/profilepic.svg" width="30px;">
            </div>
            <div class="rowcontainer ">
                <div class="container username textbold"><?php echo $username;?></div>
            </div>
        </div>
        <div class="container status">I'm bored need some fun chat</div>
        <div class=" container "><a href="../logout.php"><div class="logout ">Logout</div></a></div>
        <div class="container about"> About | Privacy  </div>
        <div class="container copy"> Copyright &copy 2020 Sweeters.co </div>
 	</div>
 	<div class="centerbar">
        <div class="first roundcorner">
            <div class=" textcenter textbold clean online borderbottom">FEED</div>
            <div class="onlyt" style=" overflow-y: scroll; background-color:A9A9A9;" ><br>
          
       
       
       
       
       


<div id="myModal" class="modal centerbar" >

  <!-- Modal content -->
  <div class="modal-content " >
    <div class="modal-header">
      <span class="close">&times;</span>
      <h2>What's on your mind</h2>
    </div>
    <div class="modal-body">
      
      
      
      
      <form method="post" action="post.php" enctype="multipart/form-data" >
   
         <textarea rows="3" cols="40" name="topic"  placeholder="Write question/topic" ></textarea>
        
       <textarea rows="10" cols="40" name="post"  placeholder="Write content" required ></textarea>
      
      <input type="hidden" name="tag"  placeholder="#post" class="width ProximaNovaRegular inpdes msgbut" autocomplete="off"  />
      <input type="file" name="fileToUpload" id="fileToUpload" class=""></div>
        <div class="msgcomp">
          <div class="refnsend">
          
            <input type="submit" name="login" value="POST" class="ProximaNovaRegularBold indes sendbut csndbut  " />
          </div>
        </form>
        <form method="post" action="post.php">
          <div class="refnsend">
                        
                        <input type="submit" class="ProximaNovaRegularBold indes simbut2" value ="<?php echo "CLEAR" ; ?>">
          </div>
          </form>
          
          
          
          
       
      
      
      
      
      
      
      
      
      
      
      
    </div>
   
  </div>

</div>







<div class="right-corder-container">
    <button class="right-corder-container-button" id="myBtn">
        <span class="short-text" >+</span>
    </button>
</div>

 
  


       
      
               

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
           
           <?php
             $qwer  = $message->username;
          
           if ($qwer != $username) { ?>
           
           
           
          
           <div class="b1" ><img src="../users/<?php echo $qwer;?>/notification/profilepic.svg" width="30px"></div>
           
             <form method="post" action="core.php">
             
             <input type="hidden" name="recivernm" value="<?php echo $message->username; ?>">
              <button type="submit"  class="simbut ProximaNovaRegular   " > <div style="font-size:13px;color:black; font-weight: bold;"  class=" ProximaNovaRegular"><?php echo "".$message->username."  ".$tag."" ; ?></div></button>
             </form>
            
             
           <?php }else{ ?>
           
           
               <div class="b1"><img src="../users/<?php echo $qwer;?>/notification/profilepic.svg" width="30px"></div>
              <button type="submit"  class="simbut ProximaNovaRegular  " > <div style="font-size:13px;color:black; font-weight: bold;"  class=" ProximaNovaRegular"><?php echo "".$message->username."  ".$tag."" ; ?></div></button>
           
     
     <?php } ?>
     
                <form method="post" action="motive.php">
                <input type="hidden" name="recivernm" value="<?php echo $message->username ; ?>">
                 <input type="hidden" name="topic" value="<?php echo $message->topic ; ?>" class="dmotive">
                <input type="hidden" name="motive" value="<?php echo $message->post ; ?>" class="dmotive">
                <input type="hidden" name="statusID" value="<?php echo $message->time ; ?>" class="dmotive">
                <input type="hidden" name="postpic" value="<?php echo $message->postpic ; ?>" class="dmotive">
                <input type="hidden" name="tag" value="<?php echo $tag ; ?>" class="dmotive">
                
               
                
                <button type="submit" style="font-size:17px; padding-left:40px;"  class="dmotive ProximaNovaRegular">
                
                
                 <?php
                 if(!empty($message->postpic)){
                  ?>
                
                 <img class="sharedimg" id="img" type="image" src="../users/<?php echo $message->username ;?>/posts/files/<?php echo $message->time ;?>/storage/post/<?php echo $message->postpic ;?>" alt="Trulli"  style="
                 
                 
                  <?php
                 if(!empty($message->post)){
                  ?>
                 width:80%;
                 <?php
                 }else{
                 ?>
                 width:80%;
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
                
               
         
          
             
             
              <div class="mytab"   >
           <form method="post" action="" >
        <input type="hidden" name="unpinname" value="<?php echo $withoutext; ?>">
    <input type="submit" class="canchat"  value ="">
    </form>
      </div>
      
       <div class="mytab" style="float: right;" >
           <form method="post" action="" >
        <input type="hidden" name="unpinname" value="<?php echo $withoutext; ?>">
    <input type="submit" class="canchat"  value ="<?php echo 'Upvote'; ?>">
    </form>
      </div>
      
       <div class="mytab" style="float: right;"  >
           <form method="post" action="" >
        <input type="hidden" name="unpinname" value="<?php echo $withoutext; ?>">
    <input type="submit" class="canchat"  value ="<?php echo 'Comments'; ?>">
    </form>
      </div>
             
             
              <div class="mytab" style="float: right;" >
           <form method="post"  >
        <input type="hidden" name="unpinname" value="<?php echo $withoutext; ?>">
    <input type="submit" class="canchat"  value ="<?php echo 'Share'; ?>">
    </form>
      </div>
             
   
  
   
   
             
             
          
      
   
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
        </div>
        
        
                
   
          
        
        
        
        <div class="second">
            <div class="third roundcorner">
                <div class="textcenter textbold clean club borderbottom">PEOPLE</div>
                <div class="cllyt" >
                    <div class="clshow">
                   

                 <div class="row ondis">
                    <div class="rowcontainer"><img src="../users/torje/notification/profilepic.svg" width="50px"></div>
                    <div class="rowcontainer namestatus">
                        <div class="container">
                         <button type="submit" class="dstatus ProximaNovaRegular  ">  let's talk about post covid word <span>  </span><span style="font-size:16px" class="fa">   &#xf112;</span></button>
                        </div>
                        <div class="container textbold mycolor">
                            <input type="submit" class="stsname ProximaNovaRegular  " value ="burt"  onclick= "chatroom(this);" >
                        </div>
                    </div>
                </div>
                
                
                
                
                <div class="row ondis">
                    <div class="rowcontainer"><img src="../users/rashika/notification/profilepic.svg" width="50px"></div>
                    <div class="rowcontainer namestatus">
                        <div class="container">
                          <button type="submit" class="dstatus ProximaNovaRegular  "> India needs revival of SAARC <span>  </span><span style="font-size:16px" class="fa">   &#xf112;</span></button>
                        </div>
                        <div class="container textbold mycolor">
                            <input type="submit" class="stsname ProximaNovaRegular  " value ="rashika"  onclick= "chatroom(this);" >
                        </div>
                    </div>
                </div>
                
                
                
                <div class="row ondis">
                    <div class="rowcontainer"><img src="../users/gaga/notification/profilepic.svg" width="50px"></div>
                    <div class="rowcontainer namestatus">
                        <div class="container">
                          <button type="submit" class="dstatus ProximaNovaRegular  "> anyone from mumbai <span>  </span><span style="font-size:16px" class="fa">   &#xf112;</span></button>
                        </div>
                        <div class="container textbold mycolor">
                            <input type="submit" class="stsname ProximaNovaRegular  " value ="gaga"  onclick= "chatroom(this);" >
                        </div>
                    </div>
                </div>

                 
                   <div class="row ondis">
                    <div class="rowcontainer"><img src="../users/maca/notification/profilepic.svg" width="50px"></div>
                    <div class="rowcontainer namestatus">
                        <div class="container">
                          <button type="submit" class="dstatus ProximaNovaRegular  ">If it is real, it will never be over. <span>  </span><span style="font-size:16px" class="fa">   &#xf112;</span></button>
                        </div>
                        <div class="container textbold mycolor">
                            <input type="submit" class="stsname ProximaNovaRegular  " value ="maca"  onclick= "chatroom(this);" >
                        </div>
                    </div>
                </div>
                
                           <div class="row ondis">
                    <div class="rowcontainer"><img src="../users/ramot/notification/profilepic.svg" width="50px"></div>
                    <div class="rowcontainer namestatus">
                        <div class="container">
                          <button type="submit" class="dstatus ProximaNovaRegular  ">I disappoint myself. <span>  </span><span style="font-size:16px" class="fa">   &#xf112;</span></button>
                        </div>
                        <div class="container textbold mycolor">
                            <input type="submit" class="stsname ProximaNovaRegular  " value ="ramot"  onclick= "chatroom(this);" >
                        </div>
                    </div>
                </div>



                     <div class="row ondis">
                    <div class="rowcontainer"><img src="../users/venom/notification/profilepic.svg" width="50px"></div>
                    <div class="rowcontainer namestatus">
                        <div class="container">
                          <button type="submit" class="dstatus ProximaNovaRegular  ">You never love someone because they’re beautiful, they are beautiful because you love them. <span>  </span><span style="font-size:16px" class="fa">   &#xf112;</span></button>
                        </div>
                        <div class="container textbold mycolor">
                            <input type="submit" class="stsname ProximaNovaRegular  " value ="venom"  onclick= "chatroom(this);" >
                        </div>
                    </div>
                </div>




                    </div>
        
        
       
        
                       <div class="msgbox mycolorlightbg" >
                            <div class="rowcontainer input ">
                                <input type="text" name="message"  placeholder="Type Message" class=" ProximaNovaRegular inputi" autocomplete="off" />
                            </div>
                            <div class="rowcontainer submit ">
                                <input type="submit" name="login" value="Send" class="ProximaNovaRegularBold submiti " />
                            </div>
                        </div>
                
                </div>
            </div>
            <div class="four">
                <div class="five roundcorner">
                    <div class=" textcenter textbold clean inbox borderbottom">INBOX <div id="notification" style="color:green; display:inline;"></div></div>
                    <div class="inlyt" id = 'inbox'>

                      <div class="container indis">Manish</div>
                    <div class="container indis">Anindya</div>
                        
                    </div>
                </div>
                <div class="six roundcorner">
                    <div class=" textcenter textbold clean name borderbottom" id ="personName">PERSON NAME</div>
                    <div class="nmlyt" id =  "chatroom">
                      
                    
                       <div class="nmshow nmlyt" id = "messagesSection"> </div>

                       
                       <div class="msgbox mycolorlightbg"  >
                        <form method="get" action="parts/chatcore.php" id="formpost" name="formpost" class="formpost">
                            <div class="rowcontainer input ">
                                <input type="text" name="message"  placeholder="Type Message" id= "uxs" class=" ProximaNovaRegular inputi" autocomplete="off"  required />
                                <input type="hidden" id = "receivernm" name="recivernm" value="">
                            </div>
                            <div class="rowcontainer submit ">
                                <input type="submit" name="login" value="Send" class="ProximaNovaRegularBold submiti " onClick="messageappend(document.getElementById('uxs').value,'<?php echo $username;?>','sec');" />
                            </div>
                            </form>
                            
                        </div>
                        
                    </div>

                </div>

            </div>
        </div>
 	</div>
 	<div class="rightbar">
        <div class="container textcenter textbold clean users">PINNED</div>
        <div class="uslyt">
            <div class="container textbold mycolor" id ="pinnedPeople">
                            

                        </div>
        </div>
 	</div>	
 </div>
 
 
 
 
 
 
 
 <script>
 
 
 
 
 loadchats();
 pinnedSec();
 
 
 
 

function messageappend(message,username,time) {

   
  var node = document.createElement("div");
  node.className = 'container nmdis mycolorback';
  node.id = "container1";
  
   var node1 = document.createElement("div");
  node1.className = "container";
  
    var node2 = document.createElement("div");
  node2.className = 'container nmdismsg';
  node.id = "container2";
  
  
  var imgNode = document.createElement('img'); 
      imgNode.src = "../users/"+username+"/notification/profilepic.svg";
      imgNode.className = 'nmdismsgicon';
      imgNode.style.width = "15px";
  
  
  var textnode = document.createTextNode(message);
  
  
   node.appendChild(node1);
   node1.appendChild(textnode);
   node.appendChild(node2);
   node2.appendChild(imgNode);
   
  
  
  document.getElementById("messagesSection").appendChild(node);
  
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
           
           
    if (typeof window.rfjd !== 'undefined') {
        loadmessages();// the variable is defined
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

    
    var row = "<div class=\"container indis\"><div class=\"row\"><div class=\"b1\" ><img src=\"" + "../users/"    
    + name +"/notification/profilepic.svg" + "\" width=\"30px\" height=\"30x\" alt=\"avatar\" style=\"border-radius: 45px;\" class=\"image\" ></div><input type=\"button\" value="+name+" class=\"simbut ProximaNovaRegular \"  onclick=\'chatroom(this);  \' ><div class=\"msgoriginal\"></div></div></div>";
    rowsArray.push(row)
    repusername.push(name)
    }
  }
        
     
 
   
  table += rowsArray.join('');
  document.getElementById("inbox").innerHTML = table;
  
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
  

    
    var row = "<div class=\"container indis\"><div class=\"row\"><div class=\"b1\" ><img src=\"" + "../users/"    
    + name +"/notification/profilepic.svg" + "\" width=\"30px\" height=\"30x\" alt=\"avatar\" style=\"border-radius: 45px;\" class=\"image\" ></div><input type=\"button\" value="+name+" class=\"simbut ProximaNovaRegular\"  onclick=\'chatroom(this);  \' ><div class=\"msgoriginal\"></div></div></div>";
    
    
    rowsArray.push(row)
  
    
  }
        
     
 
   
  table += rowsArray.join('');
  document.getElementById("pinnedPeople").innerHTML = table;
  
}
  
   



function chatroom(s) {


  
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


 window.rfjd = s.value;
 
 
  var messSecCreate = document.createElement("div");
  messSecCreate.className = 'nmshow';
  messSecCreate.id = 'messagesSection';
  
  var list = document.getElementById("chatroom");
   list.insertBefore(messSecCreate, list.childNodes[0]);
 
  
  
 
  
  
  
 
 document.getElementById("personName").innerHTML = s.value ;
  document.getElementById("receivernm").value = rfjd;
 
 

}


 
 
 
 

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
 
 

<script src="../Relative Design.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-JAW99MJVpJBGcbzEuXk4Az05s/XyDdBomFqNlM3ic+I=" crossorigin="anonymous"></script>
<!-- ** Don't forget to Add jQuery here ** -->
 
 
 
 
</body>
</html>
