<?php

/* emoji send */

if(isset($_POST['emojilink'])){

$recivernm = $_POST['recivernm'] ;
$username = $_SESSION["Username"];
$link = $_POST['emojilink'] ;
$emojilink = "../gif/emoji/$link";
  
             
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




/* Show emoji */


$dir = "../gif/emoji";

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
  <form method="post" action="chooseavatar.php">
     <input type="hidden" name="emojilink" value="<?php echo $filename; ?>">
     <input type="hidden" name="recivernm" value="<?php echo $recivernm; ?>">
      
  <input type="image" src="../gif/emoji/<?php echo $filename; ?>" width="30px" class="mpic"  alt="Submit" >
</form>
</div>
 
    

    <?php
    
    }
  }

    closedir($dh);
  }
}


?>




     
     
    
     
     

