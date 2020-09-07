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





if(isset($_POST['changemotive'])){

 
  $motive = addslashes($_POST['changemotive']);
  
  $sqlmotive = "UPDATE sessions SET status = '".$motive."' WHERE username= '".$_SESSION["Username"]."'";
    
    mysqli_query($conn, $sqlmotive);
    
    
    $sqlmotiveusers = "UPDATE users SET status = '".$motive."' WHERE Username= '".$_SESSION["Username"]."'";
    
    mysqli_query($conn, $sqlmotiveusers);
    
   }
   
   
   
   /* Like and dislike */
   
   if(isset($_POST['like'])){

 
    $fetchlike = mysqli_query($conn,"SELECT like FROM users WHERE username= '".$_SESSION["Username"]."'");
    
    if(mysqli_num_rows($checklogin) == 1)
    {
       $newlike = $fetchlik++;
    }
  
  $sqllike = "UPDATE sessions SET like = '".$newlike."' WHERE username= '".$_SESSION["Username"]."'";
    
    mysqli_query($conn, $sqllike);
    
    
    $sqllikeusers = "UPDATE users SET status = '".$newlike."' WHERE Username= '".$_SESSION["Username"]."'";
    
    mysqli_query($conn, $sqllikeusers);
    
   }
   
   
      if(isset($_POST['dislike'])){

 
    $fetchlike = mysqli_query($conn,"SELECT like FROM users WHERE username= '".$_SESSION["Username"]."'");
    
    if(mysqli_num_rows($checklogin) == 1)
    {
       $newlike = $fetchlik--;
    }
  
  $sqllike = "UPDATE sessions SET like = '".$newlike."' WHERE username= '".$_SESSION["Username"]."'";
    
    mysqli_query($conn, $sqllike);
    
    
    $sqllikeusers = "UPDATE users SET status = '".$newlike."' WHERE Username= '".$_SESSION["Username"]."'";
    
    mysqli_query($conn, $sqllikeusers);
    
   }
   
  
   
    /* Like and dislike */
   
     
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
<meta name="theme-color" content="#ff6c00">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body class=" body-define ProximaNovaRegular">
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
    
    <div class="tab"><a href="online.php"><div id="online" class="actbor mytab">FEED 
      <div id="green" class="mytab"><?php  echo $_SESSION["onlineusers"] ; ?> </div> </div></a></div>
      
    <div class="tab"><a href="inbox.php"><div id="inbox" class="bor mytab">INBOX 
      <div id="red" class="mytab"><?php  echo $_SESSION["notification"] ; ?></div></div></a></div>
  </div>
  
 <div class="msgbar mbc">
       <div class="msgtab">
<div class="row">
 
       
           <div class="dmotive">
    

      <?php
           
           
           $sqlstatus = "SELECT status FROM sessions WHERE username= '".$username."'";
    
                $check = mysqli_fetch_assoc(mysqli_query($conn, $sqlstatus));
                
                if(!empty($check["status"]))
                {
                echo 'Paste link here and discuss';
                }else{ echo 'no status' ;}
                
                ?>
                

                <span>
                
                <?php
                $dfd = $check["status"];
                $filemotive = "../users/$username/motive/$dfd.xml";

                if(file_exists($filemotive)) {
                $loadmotive =simplexml_load_file("../users/$username/motive/$dfd.xml");
                $contcurntmotivemssges = $loadmotive->count();
                $newmotivemasseges = $contcurntmotivemssges -$_SESSION['countmotivemessages'];
                
                ?>
                
                
              <?php  
                
                }
                else
                { }
               
                ?>
                </span>
                
                
                
                
    <form method="post" action="online.php">
      <div class="row postbar">
      <div  style="width: 100%">
        <input type="text" name="changemotive"  placeholder="Change Motive"  autocomplete="off" class="postinput" />
      </div>
        <div style="width: 20%">
            <input type="submit" name="login" value="SET" class="postbut">
              </div>
            </div>

        </form>

      
       


    </div>
</div>
 </div>
</div>


 <div class="member">
 




<div class="memlayt">

           <div class="dmotive">
    
           
     
                <form method="post" action="motive.php">
                <input type="hidden" name="recivernm" value="<?php echo 'offside'; ?>">
                <input type="hidden" name="motive" value="Kygo, Imagine Dragons - Born To Be Yours" class="dmotive">
                <button type="submit" class="dmotive ProximaNovaRegular  "> Kygo, Imagine Dragons - Born To Be Yours <br><p style="font-size:13px;color:#ff6c00"  class=" ProximaNovaRegular"> https://www.youtube.com/watch?v=_G-k6TQYUek </p></button>
                </form>
                 
            
   
 </div>
      
        </div>
        
        
        
         <div class="memlayt">

           <div class="dmotive">
    
           
     
                <form method="post" action="motive.php">
                <input type="hidden" name="recivernm" value="<?php echo 'offside'; ?>">
                <input type="hidden" name="motive" value="My fav song what about you? delicate seeb remix " class="dmotive">
                <button type="submit" class="dmotive ProximaNovaRegular  "> My fav song what about you? delicate seeb remix <br><p style="font-size:13px;color:#ff6c00"  class=" ProximaNovaRegular"> https://www.youtube.com/watch?v=baWOyVPi36Y</p></button>
                </form>
                 
            
   
 </div>
      
        </div>
        
        <div class="memlayt">

           <div class="dmotive">
    
           
     
                <form method="post" action="motive.php">
                <input type="hidden" name="recivernm" value="<?php echo 'offside'; ?>">
                <input type="hidden" name="motive" value="Uber hires CFO on the road to IPO" class="dmotive">
                <button type="submit" class="dmotive ProximaNovaRegular  "> Uber hires CFO on the road to IPO <br><p style="font-size:13px;color:#ff6c00"  class=" ProximaNovaRegular"> https://www.livemint.com/Companies/c4M... </p></button>
                </form>
                 
            
   
 </div>
      
        </div>
        
        
        <div class="memlayt">

           <div class="dmotive">
    
           
     
                <form method="post" action="motive.php">
                <input type="hidden" name="recivernm" value="<?php echo 'offside'; ?>">
                <input type="hidden" name="motive" value="Priyanka Chopra and Nick Jonas love affair! - desi girl with videsi" class="dmotive">
                <button type="submit" class="dmotive ProximaNovaRegular  "> Priyanka Chopra and Nick Jonas love affair! - desi girl with videsi <br><p style="font-size:13px;color:#ff6c00"  class=" ProximaNovaRegular"> https://twitter.com/i/moments/1032006221774168065</p></button>
                </form>
                 
            
   
 </div>
      
        </div>
        
        
         <div class="memlayt">

           <div class="dmotive">
    
           
     
                <form method="post" action="motive.php">
                <input type="hidden" name="recivernm" value="<?php echo 'offside'; ?>">
                <input type="hidden" name="motive" value="Scientists confirm that there's ice on the moon i'm so proud of india" class="dmotive">
                <button type="submit" class="dmotive ProximaNovaRegular  "> Scientists confirm that there's ice on the moon i'm so proud of india <br><p style="font-size:13px;color:#ff6c00"  class=" ProximaNovaRegular"> https://twitter.com/i/moments/1032006221774168065</p></button>
                </form>
                 
            
   
 </div>
      
        </div>
        
        
        
         <div class="memlayt">

           <div class="dmotive">
    
           
     
                <form method="post" action="motive.php">
                <input type="hidden" name="recivernm" value="<?php echo 'offside'; ?>">
                <input type="hidden" name="motive" value=""Why china is so dominating north asia country" - this article so biased" class="dmotive">
                <button type="submit" class="dmotive ProximaNovaRegular  "> "Why china is so dominating north asia country" - this post so biased<br><p style="font-size:13px;color:#ff6c00"  class=" ProximaNovaRegular"> https://twitter.com/i/moments/1032006221774...</p></button>
                </form>
                 
            
   
 </div>
      
        </div>





</div>



<script src="../Relative Design.js"></script>
</body>
</html>


