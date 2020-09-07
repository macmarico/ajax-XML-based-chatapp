<?php
session_start();
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Chatspot - Join The Chat Community</title>
<link href="../design.css" rel="stylesheet" type="text/css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body class=" body-define ProximaNovaRegular">
   
<div class=" head">
<div class="head-logo ">
  <div class=""><img src="img_424217.svg" width="15px"><span> </span> CHATSPOT.IN</div></div>
    <div class="slogan">Chat And Fun Online With People</div>
</div>

<?php

$username = $_SESSION["Username"];




$target_dir = "../users/$username/notification/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists("../users/$username/notification/profilepic.jpeg")) {
    
    $file = "../users/$username/notification/profilepic.jpeg";
    if (!unlink($file))
  {
  echo ("Error deleting $file");
  }
  else
  {
  echo ("Deleted $file");
  }
    
   
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
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
        
        
       rename($target_file,"../users/$username/notification/profilepic.jpeg"); 
       ?>
       
       div class="load"><img src="../loading.gif" alt="Loading Cycle" class="loading" style="width:50px; margin-left:calc(50% - 25px);"></div>
      <?php

        echo "<meta http-equiv='refresh' content='0,setting.php' />";
        exit;
        
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>

</body>
</html>