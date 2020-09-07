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

$notification =simplexml_load_file("../users/$username/notification/notification.xml"); // notification count

$_SESSION["notification"] = $notification->count();

 $loadclub =simplexml_load_file("../clubs/club.xml");
 
   $contcurntclubmssges = $loadclub->count();
   $newclubmasseges = $contcurntclubmssges -$_SESSION['countclubmessages'];





   
   
   
   if(isset($_POST['recivernm'])){
   
   $target_file= $_POST['recivernm'] ;
   $file = "../users/$username/notification/profilepic.jpeg";
   
   if (file_exists($file))
                {
                
                
                    unlink($file);
  
  
  
  $file = "../avatar/$target_file";
$newfile = "../users/$username/notification/$target_file";

if (copy($file, $newfile)) {

    rename($newfile,"../users/$username/notification/profilepic.svg"); 
}

                }
                else
                
                { 
              
                
  $file = "../avatar/$target_file";
$newfile = "../users/$username/notification/$target_file";

if (copy($file, $newfile)) {

    rename($newfile,"../users/$username/notification/profilepic.svg"); 
}

                
                }     
        
      }

    

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
?>         
        </div>
    </div> </a></div>

    <div class=" notifs"><a href="setting.php">
      <form method="get" action="../logout.php">
    <button type="submit" class="lgbut">Logout</button>
</form></a></div>
    </div>

<div class="tabs stickdiv">
    <div class="tab "><a href="feed.php"><div class="bor ">FEED</div></a></div>
    
    <div class="tab"><a href="online.php"><div class="bor mytab">ONLINE 
      <div id="green" class="mytab"><?php  echo $_SESSION["onlineusers"] +200 ; ?> </div> </div></a></div>
    <div class="tab"><a href="inbox.php"><div  class="bor mytab">INBOX 
      <div id="red" class="mytab"><?php  echo $_SESSION["notification"] ; ?></div></div></a></div>
  </div>
  
<div class="setlayt" >
  <div> 
  
  <br><br><br><br>
  
  <div class="avatar">
  <a href="../chooseavatar.php">
    <img src="../users/<?php echo $username; ?>/notification/profilepic.svg" width="50px" alt="avatar" class="mpic" ></a>
  </div>
  </div>
<div class="bar setbar">

    <?php
echo "".$_SESSION['Username'].""; 
?>

  </div>
  <div class="setbar">
  
   <?php
           
           
           $sqlstatus = "SELECT status FROM sessions WHERE username= '".$_SESSION['Username']."'";
    
                $check = mysqli_fetch_assoc(mysqli_query($conn, $sqlstatus));
                
                if(!empty($check["status"]))
                {
                echo $check["status"];
                }else{ echo 'no status' ;}
                
                ?>
  
  </div>
         
  
</div>

<div class=" set">
  
</div> 


 <div class="border-none pcform"><form method="post" action="profile.php" name="registerform" id="registerform" class="border-none form">
<fieldset class="border-none">
	
		<div class="bars"><input type="submit" name="register" id="register" value="My posts" class="button inpdes ProximaNovaRegular" /></div>
	</fieldset>
</form></div> 




     
 <div class="border-none pcform"><form method="post" action="../mobile/club.php" name="registerform" id="registerform" class="border-none form">
<fieldset class="border-none">
	
		<div class="bars"><input type="submit" name="register" id="register" value="My posts" class="button inpdes ProximaNovaRegular" /></div>
	</fieldset>
</form></div>


<br><br><br><br><br><br><br>
     <div class="footsim">  Blocked users
</div>
     
<script src="../Relative Design.js"></script>
<script src="../mobile.js" ></script>
</body>
</html>
