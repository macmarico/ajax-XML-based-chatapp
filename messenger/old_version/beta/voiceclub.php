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

    $recivernm = addslashes($_POST['recivernm']);
     
   $notification =simplexml_load_file("../users/$username/notification/notification.xml");

   $_SESSION["notification"] = $notification->count();
     
    



  $target_dir = "../clubs/storage/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
   
echo $target_file;
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {


        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
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
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="google" content="notranslate">
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
    
<div class="tabs">
  <div class="tab "><a href="club.php"><div class="actbor ">CLUB</div></a></div>
    <div class="tab "><a href="index.php"><div class="bor ">USERS</div></a></div>
    <div class="tab"><a href="online.php"><div  class=" mytab bor">ONLINE 
      <div id="green" class="mytab"><?php  echo $_SESSION["onlineusers"] ; ?> </div> </div></a></div>
    <div class="tab"><a href="inbox.php"><div id="inbox" class="bor mytab">INBOX 
      <div id="red" class="mytab"><?php  echo $_SESSION["notification"] ; ?></div></div></a></div>
  </div>




  <form method="post" action="voiceclub.php" enctype="multipart/form-data">
      <input type="file" accept="audio/*;capture=microphone" name="fileToUpload" id="fileToUpload"> 
     <input type="submit" value="Upload Image" name="submit">
        </form>



<?php
$username = $_SESSION["Username"];
?>


  <div class="msgbar mbc">
    <div class="msgtab">
      <form method="post" action="club.php">
      <div class="msgcomp">
        <input type="text" name="message"  placeholder="Type Message" class="width ProximaNovaRegular inpdes msgbut clubinput" autocomplete="off"  />
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

   <div class="member cback">



<audio controls>
  <source src="audio.mp3" type="audio/mpeg">
  
Your browser does not support the audio element.
</audio>



</div>
<div class="set">
  <a href="#anchor"><div class="">GO TO TOP</div></a>
</div>

</body>
</html>

