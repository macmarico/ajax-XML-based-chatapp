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





$username = $_SESSION["Username"];


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
    <div class="tab "><a href="home.php"><div class="mytab bor ">FEED</div></a></div>
  

    <div class="tab"><a href="online.php"><div id="online" class="actbor">ONLINE 
      <div id="green" style="color:green;" class="mytab"><?php  echo $_SESSION["onlineusers"] + 200 ; ?> </div> </div></a></div>
      
    

    
    
    <div class="tab"><a href="inbox.php"><div id="inbox" class="mytab bor">CHATS 
      <div id="demo" style="color:green;" class="mytab"><?php  echo $_SESSION["notification"] ; ?></div></div></a></div>

  

</div>
  
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
                
                
                
                
    <form method="post" action="online.php">
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
 
 
 
 
 <!-- dummy users end   -->
 
 
 
 
 
 
 
 
 
 

 

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



<div class="memlayt">
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
               
               
                <button type="submit" class="dstatus ProximaNovaRegular  "> <?php echo $check["status"]; ?><span>  </span><span style="font-size:16px" class="fa">   &#xf112;</span></button>
               
                <?php
             
                
                }else{ echo 'no status' ;}
                
                ?>
                

    <form method="post" action="core.php">
   </div style="height: 13px;">
             <div ><input type="hidden" name="recivernm" value="<?php echo $row["username"]; ?>">
     <input type="submit" class="stsname ProximaNovaRegular  " value ="<?php echo $row["username"]; ?>">
      </div>
      
        </div>
         

   
    
 

   </form>
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
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 <div class="memlayt">
<div class="row">
        <div class="b1" >
     
  <input type="hidden" name="profilename" value="mac">
  <input type="image" src="../users/torje/notification/profilepic.svg" width="30px" class="mpic"  alt="Submit" >
        </form>
        
     
        </div>
        <div class="b2 statwidth" >
           <div class="dstatus">
        
                <button type="submit" class="dstatus ProximaNovaRegular  ">let's talk about post covid word<span>  </span><span style="font-size:16px" class="fa">   &#xf112;</span></button>

    <form method="post" action="core.php">
   </div style="height: 13px;">
             <div ><input type="hidden" name="recivernm" value="mac">
     <input type="submit" class="stsname ProximaNovaRegular  " value ="burt">
      </div>
      
        </div>
   </form>
 </div>
 </div>
 
 
 
 <div class="memlayt">
<div class="row">
        <div class="b1" >
     
  <input type="hidden" name="profilename" value="mac">
  <input type="image" src="../users/rashika/notification/profilepic.svg" width="30px" class="mpic"  alt="Submit" >
        </form>
        
     
        </div>
        <div class="b2 statwidth" >
           <div class="dstatus">
        
                <button type="submit" class="dstatus ProximaNovaRegular  ">Why india needs revival of SAARC.<span>  </span><span style="font-size:16px" class="fa">   &#xf112;</span></button>

    <form method="post" action="core.php">
   </div style="height: 13px;">
             <div ><input type="hidden" name="recivernm" value="mac">
     <input type="submit" class="stsname ProximaNovaRegular  " value ="rashika ">
      </div>
      
        </div>
   </form>
 </div>
 </div>
 
 
 
 
 <div class="memlayt">
<div class="row">
        <div class="b1" >
     
  <input type="hidden" name="profilename" value="mac">
  <input type="image" src="../users/gaga/notification/profilepic.svg" width="30px" class="mpic"  alt="Submit" >
        </form>
        
     
        </div>
        <div class="b2 statwidth" >
           <div class="dstatus">
        
                <button type="submit" class="dstatus ProximaNovaRegular  "> anyone from mumbai<span>  </span><span style="font-size:16px" class="fa">   &#xf112;</span></button>

    <form method="post" action="core.php">
   </div style="height: 13px;">
             <div ><input type="hidden" name="recivernm" value="mac">
     <input type="submit" class="stsname ProximaNovaRegular  " value ="anu">
      </div>
      
        </div>
   </form>
 </div>
 </div>
 
 
 
 
 
 
 
 
 
<!-- dummy users end   -->
 
 
 
 

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



<div class="memlayt">
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
               
               
                <button type="submit" class="dstatus ProximaNovaRegular  "> <?php echo $check["status"]; ?><span>  </span><span style="font-size:16px" class="fa">   &#xf112;</span></button>
               
                <?php
             
                
                }else{ echo 'no status' ;}
                
                ?>
                

    <form method="post" action="core.php">
   </div style="height: 13px;">
             <div ><input type="hidden" name="recivernm" value="<?php echo $row["username"]; ?>">
     <input type="submit" class="stsname ProximaNovaRegular  " value ="<?php echo $row["username"]; ?>">
      </div>
      
        </div>
         

   
    
 

   </form>
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
</div>


 <script>
 
 function foo() {



var xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
          var xmlDoc = this.responseXML;
    
    var nodes = xmlDoc.getElementsByTagName('notifset'), 
    amountOfNodes = nodes.length
     document.getElementById("demo").innerHTML = amountOfNodes;
    }
};
xhttp.open("GET", "../users/<?php echo $username; ?>/notification/notification.xml", false);

xhttp.setRequestHeader('Cache-Control', 'no-cache');
xhttp.send();


setTimeout(foo, 1000);

}

foo();

</script>


<script src="../Relative Design.js"></script>
</body>
</html>


