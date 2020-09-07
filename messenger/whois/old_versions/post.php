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




?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="google" content="notranslate">
<meta name="theme-color" content="#f43e2e">

<link rel="shortcut icon" href="favicon.png">
<title>Home</title>
<link href="../design.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="../lib/css/emoji.css" rel="stylesheet">
</head>
<body class=" body-define ProximaNovaRegular">


<?php


     
     $username = $_SESSION["Username"];

    $recivernm = $_POST['recivernm'];
    
     $motive = $_POST['motive'];
     
   $statusID = $_POST['statusID'];
     
   $notification =simplexml_load_file("../users/$username/notification/notification.xml");

   $_SESSION["notification"] = $notification->count();
     
    
 
      
      if(isset($_POST['post'])){

  
  $topic = addslashes($_POST['topic']);
  $post = addslashes($_POST['post']);
  $statusID = time();
  $filenm = basename($_FILES["fileToUpload"]["name"]); 
  
  
  
  
    
    
    
    $filename2 = "../users/$username/posts/files/$statusID/$statusID.xml";

    if(!file_exists($filename2)) {
    
          mkdir("../users/$username/posts/files/$statusID");
          mkdir("../users/$username/posts/files/$statusID/storage");
          mkdir("../users/$username/posts/files/$statusID/storage/post");
          mkdir("../users/$username/posts/files/$statusID/storage/comment");
          
          
          
          
              /* pic post start */
  


$target_dir = "../users/$username/posts/files/$statusID/storage/post/";
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
        
        echo 'done';

         
        
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}


/* pic share end */ 
   
          
          
          
          
          
          if(!empty($_POST['tag'])){
          
          $tag = "#".$_POST['tag']."";
          
          
          }else{
          
           $tag = '#post' ;
          
          }
          
          
          
          
          
          
          
          
          
          
          
          
          $doc = new DOMDocument();
          $foo = $doc->createElement("messages");
          $foo->setAttribute("category", "short");
          $doc->appendChild($foo);
          $doc->save("../users/$username/posts/files/$statusID/$statusID.xml");
          
          
       $post = stripslashes($post);
      
        $sxepostlist = simplexml_load_file("../users/$username/posts/postlist.xml");
        $moviepostlist = $sxepostlist->addChild('postset');
        $eepostlist = $moviepostlist->addChild('username', "$username");
        $eepostlist = $moviepostlist->addChild('statusID', "$statusID");
        $eepostlist = $moviepostlist->addChild('topic', htmlspecialchars($topic));
        $eepostlist = $moviepostlist->addChild('post', htmlspecialchars($post));
        $eepostlist = $moviepostlist->addChild('postpic', "$filenm");
        $eepostlist = $moviepostlist->addChild('tag', "$tag");
       
        $sxepostlist->asXML("../users/$username/posts/postlist.xml");
      
      
      
        $sxe = simplexml_load_file("../feed/feed.xml");
        $movie = $sxe->addChild('postset');
        $ee = $movie->addChild('username', "$username");
        $ee = $movie->addChild('time', time());
        $ee = $movie->addChild('topic', htmlspecialchars($topic));
        $ee = $movie->addChild('post', htmlspecialchars($post));
        $ee = $movie->addChild('postpic', "$filenm");
        $ee = $movie->addChild('tag', "$tag");
       
        $sxe->asXML("../feed/feed.xml");


          }
          
          
          
          
                 
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
    
    
    ?>
      <div class="load"><img src="../loading.gif" alt="Loading Cycle" class="loading" style="width:50px; margin-left:calc(50% - 25px);margin-top:130px "></div>
       <center>POSTING</center>
      <?php
   
    echo "<meta http-equiv='refresh' content='0,home.php' />";
    exit;
    
   }
    
    
     
?>




<div id="anchor"></div>

<div class="adj height: 55px" >  <a style= "color : white ;" href=" feed.php">back</a>

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
      </a></div>
    </div>
    
<div class="tab">
   
    
    <div class="tab"><a href="online.php"><div  class=" dmotive ProximaNovaRegular">Write on something.... 
       </div></a></div>
   
  </div>


<?php





$username = $_SESSION["Username"];


         if(isset($_POST['motive'])){
         
         ?>
         
         
  <div class="msgbar mbc">
  
    <div class="msgtab">
    
  
    
    <div class="actbor " style="font-size:30px"><?php echo $motive ; ?> </div>
    </div></div>
    
    
    
    <div class="msgbar">
    <div class="msgtab">
        
    
    
    <div class="emojibar">
   <div >
              
  <form method="post" action="motive.php" class="emojiform">
     
      
      <input type="submit"  value="<?php echo '+' ; ?>" width="50px" class="ProximaNovaRegularBold indes sendbut csndbut"  alt="Submit" >
    </form>
      
     <form method="post" action="motive.php" class="emojiform">
     
      
      <input type="submit"  value="<?php echo status ; ?>" width="50px" class="ProximaNovaRegularBold indes sendbut csndbut"  alt="Submit" >
    </form>
     <form method="post" action="motive.php" class="emojiform">
     
      
      <input type="submit"  value="<?php echo motive ; ?>" width="50px" class="ProximaNovaRegularBold indes sendbut csndbut"  alt="Submit" >
    </form>
     <form method="post" action="motive.php" class="emojiform">
     
      
      <input type="submit"  value="<?php echo topic ; ?>" width="50px" class="ProximaNovaRegularBold indes sendbut csndbut"  alt="Submit" >
    </form>
    
    
     <form method="post" action="motive.php" class="emojiform">
     
      
      <input type="submit"  value="<?php echo news ; ?>" width="50px" class="ProximaNovaRegularBold indes sendbut csndbut"  alt="Submit" >
    </form>
    
    </div>
    </div>
    <br>
    
      <form method="post" action="post.php">
    
        <div class="msgcomp">
          <div class="refnsend">
             <input type="hidden" name="changemotive" value="<?php echo  $_POST['motive'] ; ?>">
            <input type="submit" name="login" value="DONE" class="ProximaNovaRegularBold indes sendbut csndbut  " />
          </div>
        </form>
        <form method="post" action="core.php">
          <div class="refnsend">
                       
                        <input type="submit" class="ProximaNovaRegularBold indes simbut2" value ="<?php echo "DISCARD" ; ?>">
          </div>
          </form>
        </div>
    
    
  <?php
    
    exit;
   
    }
    ?>
    
  <div class="msgbar">
    <div class="msgtab">
      <form method="post" action="post.php" enctype="multipart/form-data" >
      <div class="msgcomp" >
        
         <textarea rows="3" cols="40" name="topic"  placeholder="Write question/topic" ></textarea>
        
       <textarea rows="18" cols="40" name="post"  placeholder="Write content" required ></textarea>
      </div>
      <input type="hidden" name="tag"  placeholder="#post" class="width ProximaNovaRegular inpdes msgbut" autocomplete="off"  />
       <div class="setleft "><input type="file" name="fileToUpload" id="fileToUpload" class=""></div>
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
      








<script src="../Relative Design.js"></script>
<!-- ** Don't forget to Add jQuery here ** -->
</body>
</html>

