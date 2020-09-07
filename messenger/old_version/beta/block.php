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

   $notification =simplexml_load_file("../users/$username/notification/notification.xml");

   $_SESSION["notification"] = $notification->count();
   
   $loadclub =simplexml_load_file("../clubs/club.xml");
 
   $contcurntclubmssges = $loadclub->count();
   $newclubmasseges = $contcurntclubmssges -$_SESSION['countclubmessages'];



?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Home</title>
<link href="../design.css" rel="stylesheet" type="text/css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="#ff6c00">

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

<div class="tabs">
   <div class="tab "><a href="club.php"><div class="bor ">CLUB
    <div id="green" class="mytab"><?php  echo $newclubmasseges ; ?> </div></div></a></div>
    <div class="tab "><a href="index.php"><div class="bor ">USERS</div></a></div>
    <div class="tab"><a href="online.php"><div  class=" mytab bor">ONLINE 
      <div id="green" class="mytab"><?php  echo $_SESSION["onlineusers"] ; ?> </div> </div></a></div>
    <div class="tab"><a href="inbox.php"><div id="inbox" class="actbor mytab">INBOX 
      <div id="red" class="mytab"><?php  echo $_SESSION["notification"] ; ?></div></div></a></div>
  </div>
  
  <?php
  
  
  
$username = $_SESSION["Username"];
$personname = $_POST['personname'];

$filename = "../users/$username/notification/blocked.xml";
$filenameperson = "../users/$personname/notification/blocked.xml";




  
  
/* pic share start */
  
  
  if(isset($_POST['picreciver'])){


$username = $_SESSION["Username"];
$recivernm = $_POST['recivernm'] ;

 

$target_dir = "../admin/storage/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        
      
        $sxe = simplexml_load_file("../admin/report.xml"); 
        $movie = $sxe->addChild($_SESSION["Username"]);
        $ee = $movie->addChild('time', "yo");
        $ee->addChild('link', "$target_file");
        $sxe->asXML("../admin/report.xml");

        
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
}

  
  
/* pic share end */ 
   
 





    
if(isset($_POST['personname'])){

      


      if(!file_exists($filename)) {
    
          $doc = new DOMDocument();
          $foo = $doc->createElement("messages");
          $foo->setAttribute("category", "short");
          $doc->appendChild($foo);
          $doc->save("../users/$username/notification/blocked.xml");
            } 

      if(!file_exists($filenameperson)) {
           $doc = new DOMDocument();
          $foo = $doc->createElement("messages");
          $foo->setAttribute("category", "short");
          $doc->appendChild($foo);
          $doc->save("../users/$personname/notification/blocked.xml");
            } 


        $reason = 'blocked';
        $sxe = simplexml_load_file("../users/$username/notification/blocked.xml");
        $sxe->addChild($_POST['personname'], "$reason");
       
        $sxe->asXML("../users/$username/notification/blocked.xml");

         $reason = 'blocked by';
        $sxe = simplexml_load_file("../users/$personname/notification/blocked.xml");
        $sxe->addChild("$username", "$reason");
       
        $sxe->asXML("../users/$personname/notification/blocked.xml");

    }
    
    
    
    
    if(isset($_POST['unblockname'])){

       $unblockname = $_POST['unblockname'];

         $dom = new DOMDocument();
         $dom->load("../users/$username/notification/blocked.xml");
         $xpath = new DOMXPath($dom);

        foreach ($xpath->evaluate($unblockname) as $node) {
        $node->parentNode->removeChild($node);
        }

      $dom->save("../users/$username/notification/blocked.xml");
      
      $dom = new DOMDocument();
         $dom->load("../users/$unblockname/notification/blocked.xml");
         $xpath = new DOMXPath($dom);

        foreach ($xpath->evaluate($username) as $node) {
        $node->parentNode->removeChild($node);
        }

      $dom->save("../users/$unblockname/notification/blocked.xml");



       }
       
       if(isset($_POST['report'])){

    
        $message = addslashes($_POST['report']);
        $sxe = simplexml_load_file("../admin/report.xml");
        $movie = $sxe->addChild($_SESSION["Username"]);
        $ee = $movie->addChild('time', "yo");
        $ee->addChild('message', "$message");
        $sxe->asXML("../admin/report.xml");

}


 

  $xml =simplexml_load_file("../users/$username/notification/blocked.xml") or die("Error: Cannot create object"); // what user freind has sent
    
         foreach($xml ->children() as $chat) { 


  ?>
  
<div class="messeging"><?php  print $chat->getName() ." : " . $chat . ""; ?> 

 <div class="mytab" style="float: right;" >
           <form method="post" action="block.php" >
    <input type="hidden" name="unblockname" value="<?php echo $chat->getName(); ?>">
  
  <?php
    if($chat != 'blocked by')
     { 
     ?>
     
    <input type="submit" class="canchat"  value ="<?php echo 'Unblock'; ?>">
     
     <?php
     }
     ?>
     
    </form>
      </div>
      </div>

<?php

      }
      
      
       if(isset($_POST['personname'])){

    echo $_POST['personname'];

}

     

?>

 <div class="row">

    <form method="post" action="block.php" enctype="multipart/form-data">
      <div class="setleft "><input type="file" name="fileToUpload" id="fileToUpload" class="parea"></div>
      <input type="hidden" name="recivernm" value="<?php echo $recivernm; ?>">
      <input type="hidden" name="picreciver" value="<?php echo $recivernm; ?>">
     <div class="setright"> <input type="submit" value="Upload Image" name="submit" class="barea"></div>
    </form>
      </div>

<div class="setlayt2">
<div class="setlayt">Report</div>
<div class="setlayt form2"><form method="post" action="" name="registerform" id="registerform"  >
<fieldset class="border-none">
        <div class=" class="form"">
                 
               <br><br>
               <textarea style="height: 70px" type="text" name="report" id="username" placeholder="Describe min 50 character" class="width ProximaNovaRegular inpdes msgbut" autocomplete="off" minlength="50"  required /></textarea>
               <br><br><br>
                <div class="bars"><input type="submit" name="submit" id="register" value="Submit Report To Admin" class="button inpdes ProximaNovaRegular" /></div>
                </fieldset>
</form></div>
</div>



</html>
</body>