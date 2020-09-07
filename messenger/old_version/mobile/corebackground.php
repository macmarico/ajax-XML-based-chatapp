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
   
    $loadclub =simplexml_load_file("../clubs/club.xml");
 
   $contcurntclubmssges = $loadclub->count();
   $newclubmasseges = $contcurntclubmssges -$_SESSION['countclubmessages'];
   
   
  
  
/* pic share start */
  
  
  if(isset($_POST['picreciver'])){


$username = $_SESSION["Username"];
$recivernm = $_POST['recivernm'] ;

  $checkdir = "../users/$recivernm/storage/$username";

            if(!is_dir($checkdir))
            {
               mkdir("../users/$recivernm/storage/$username");
            }
   

$target_dir = "../users/$recivernm/storage/$username/";
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
        
         $filenm = basename($_FILES["fileToUpload"]["name"]); 
         $arr = explode(".", $filenm);
         $extension = strtolower(array_pop($arr));
         $time = time();
         $newfilenm = "'".$time.".".$extension."'";
        
       rename($target_file, "../users/$recivernm/storage/$username/$newfilenm"); 
             
$filename = "../users/$recivernm/$username.xml";

      if(!file_exists($filename)) {
    
          $doc = new DOMDocument();
          $foo = $doc->createElement("messages");
          $foo->setAttribute("category", "short");
          $doc->appendChild($foo);
          $doc->save("../users/$recivernm/$username.xml");
            } 


$filename2 = "../users/$username/$recivernm.xml";

    if(!file_exists($filename2)) {

          $doc = new DOMDocument();
          $foo = $doc->createElement("messages");
          $foo->setAttribute("category", "short");
          $doc->appendChild($foo);
          $doc->save("../users/$username/$recivernm.xml");

          }
       

    
        $link = "../users/$recivernm/storage/$username/$newfilenm" ;
        $sxe = simplexml_load_file("../users/$recivernm/$username.xml");
        $movie = $sxe->addChild($_SESSION["Username"]);
        $ee = $movie->addChild('time', "yo");
        $ee->addChild('link', "$link");
        $sxe->asXML("../users/$recivernm/$username.xml");

       
        $link = "../users/$recivernm/storage/$username/$newfilenm" ;
        $sxe = simplexml_load_file("../users/$username/$recivernm.xml");
        $movie = $sxe->addChild($_SESSION["Username"]);
        $ee = $movie->addChild('time', "yo");
        $ee->addChild('link', "$link");
        $sxe->asXML("../users/$username/$recivernm.xml");
        
        $message = addslashes($_POST['message']);
        $sxe = simplexml_load_file("../users/$recivernm/notification/notification.xml");
        $sxe->addChild($_SESSION["Username"], "$link");
       
        $sxe->asXML("../users/$recivernm/notification/notification.xml");
   
        
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
}

  
  
/* pic share end */ 
   
     
    
   


if(isset($_POST['recivernm'])){


$dom = new DOMDocument();
$dom->load("../users/$username/notification/notification.xml");
$xpath = new DOMXPath($dom);

foreach ($xpath->evaluate($recivernm) as $node) {
  $node->parentNode->removeChild($node);
}

$dom->save("../users/$username/notification/notification.xml");




$filename = "../users/$recivernm/$username.xml";

      if(!file_exists($filename)) {
    
          $doc = new DOMDocument();
          $foo = $doc->createElement("messages");
          $foo->setAttribute("category", "short");
          $doc->appendChild($foo);
          $doc->save("../users/$recivernm/$username.xml");
          
          
            } 

 

$filename2 = "../users/$username/$recivernm.xml";

    if(!file_exists($filename2)) {

          $doc = new DOMDocument();
          $foo = $doc->createElement("messages");
          $foo->setAttribute("category", "short");
          $doc->appendChild($foo);
          $doc->save("../users/$username/$recivernm.xml");

          }
     }     
         
         
         
  /* send message start */       

if(isset($_POST['message'])){

    
        $message = addslashes($_POST['message']);
        $sxe = simplexml_load_file("../users/$recivernm/$username.xml");
        $movie = $sxe->addChild($_SESSION["Username"]);
        $ee = $movie->addChild('time', "yo");
        $ee->addChild('message', "$message");
        $sxe->asXML("../users/$recivernm/$username.xml");

       
        $message = addslashes($_POST['message']);
        $sxe = simplexml_load_file("../users/$username/$recivernm.xml");
        $movie = $sxe->addChild($_SESSION["Username"]);
        $ee = $movie->addChild('time', "yo");
        $ee->addChild('message', "$message");
        $sxe->asXML("../users/$username/$recivernm.xml");
        
        $message = addslashes($_POST['message']);
        $sxe = simplexml_load_file("../users/$recivernm/notification/notification.xml");
        $sxe->addChild($_SESSION["Username"], "$message");
       
        $sxe->asXML("../users/$recivernm/notification/notification.xml");



}

 /* send message end */  
 
 
 /* emoji send start */

if(isset($_POST['emojiname'])){

$recivernm = $_POST['recivernm'] ;
$username = $_SESSION["Username"];
$emojiname = $_POST['emojiname'] ;
$emojilink = "../gif/emoji/$emojiname";
  

    
        $sxe = simplexml_load_file("../users/$recivernm/$username.xml");
        $movie = $sxe->addChild($_SESSION["Username"]);
        $ee = $movie->addChild('time', "yo");
        $ee->addChild('link', "$emojilink");
        $sxe->asXML("../users/$recivernm/$username.xml");

   
        $sxe = simplexml_load_file("../users/$username/$recivernm.xml");
        $movie = $sxe->addChild($_SESSION["Username"]);
        $ee = $movie->addChild('time', "yo");
        $ee->addChild('link', "$emojilink");
        $sxe->asXML("../users/$username/$recivernm.xml");
        
        $message = addslashes($_POST['message']);
        $sxe = simplexml_load_file("../users/$recivernm/notification/notification.xml");
        $sxe->addChild($_SESSION["Username"], "$emojilink");
       
        $sxe->asXML("../users/$recivernm/notification/notification.xml");
   
   
}


/* emoji send end */
 
 
 
?>

  

