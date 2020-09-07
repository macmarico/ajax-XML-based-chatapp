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
<meta name="theme-color" content="#ff6c00">
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
   <div class="tab "><a href="club.php"><div class="bor ">CLUB
    <div id="green" class="mytab"><?php  echo $newclubmasseges ; ?> </div></div></a></div>
    <div class="tab "><a href="index.php"><div class="bor ">USERS</div></a></div>
    <div class="tab"><a href="online.php"><div id="online" class="bor mytab">ONLINE 
      <div id="green" class="mytab"><?php  echo $_SESSION["onlineusers"] ; ?> </div> </div></a></div>
    <div class="tab"><a href="inbox.php"><div id="inbox" class="bor mytab">INBOX 
      <div id="red" class="mytab"><?php  echo $_SESSION["notification"] ; ?></div></div></a></div>
  </div>



<div class="setlayt" >
  <div> <div class="avatar">
    <img src="
    
      <?php
      
             $filename = "../users/$username/notification/profilepic.svg";

            if (file_exists($filename)) {
                  echo "$filename";
                      } else {
                       echo "../contact.svg";
                }
            ?>
    
   " width="50px" alt="avatar" class="mpic" >
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



<div class="setlayt2">

<div class="setlayt"> Change Avatar</div>

<div class=" cavalyt">

<?php

$dir = "../avatar";

// Open a directory, and read its contents
if (is_dir($dir)){
  if ($dh = opendir($dir)){
    while (($file = readdir($dh)) !== false){
      $filename = $file ;
      $withoutext = basename($filename, '.xml');
    
      if("$filename" != '.' AND "$filename" != '..' AND "$filename" != 'storage' AND "$filename" != 'notification' )
      {
      

?>

 

  
   
   
    
     
<div class="avatars ">
  <form method="post" action="setting.php">
     <input type="hidden" name="recivernm" value="<?php echo $filename; ?>">
  <input type="image" src="../avatar/<?php echo $filename; ?>" width="30px" class="mpic"  alt="Submit" >
</form>
</div>
 
    
 

      
  
 
 

    
    
  
    <?php
    
    }
  }

    closedir($dh);
  }
}


?>

</div>





  <div class="setlayt"></div>
  <div class="row">

    <form method="post" action="" enctype="multipart/form-data">
      
     
     <div class="setleft "> <input type="hidden" name="fileToUpload" id="fileToUpload" class="parea"></div>

     <div class="setright"><input type="hidden" value="Upload Image" name="submit" class="barea"></div>


    </form>

</div>
 
     </div>
     
     
<div class=" set">
  <div class="footsim"><a href="block.php">Blocked users</a>
</div>
</div>    
     
     
<script src="../Relative Design.js"></script>
<script src="../mobile.js" ></script>
</body>
</html>
