<?php 
include "base.php";



function removeDirectory($path) {
 	$files = glob($path . '/*');
	foreach ($files as $file) {
		is_dir($file) ? removeDirectory($file) : unlink($file);
	}
	rmdir($path);
 	return;
}



$username = $_SESSION["Username"];

unlink("users/$username/notification/notification.xml") ;
               
                   $doc = new DOMDocument();
                
                   $foo = $doc->createElement("apps");
                   $foo->setAttribute("category", "essential");
                   $doc->appendChild($foo);
                   
               
                   $doc->save("users/$username/notification/notification.xml");



$xml =simplexml_load_file("users/$username/notification/pinfriend.xml") or die("Error: Cannot create object");
     
$dir = "users/$username";

// Open a directory, and read its contents
if (is_dir($dir)){
  if ($dh = opendir($dir)){
    while (($file = readdir($dh)) !== false){
      $filename = $file ;
      $withoutext = basename($filename, '.xml');
      $checkvar = 0 ;
      
     if("$filename" != '.' AND "$filename" != '..' AND "$filename" != 'storage' AND "$filename" != 'notification' AND "$filename" != 'posts')
      {
         foreach($xml->children() as $message)

          { 
   
          if($message->getName() == $withoutext){
              
              $checkvar = 1 ;

           }
           
       } 
       
       if( $checkvar == 0 ){
       unlink("users/$username/$filename") ;
       
       $checkdir = "users/$username/storage/$withoutext";

            if(is_dir($checkdir))
            {
                removeDirectory("users/$username/storage/$withoutext");
            }
       
      
       }
      
      }
}
}
}


$sql = "SELECT * FROM sessions";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
    
    
    $sql = "DELETE FROM sessions WHERE username='".$username."'";

    mysqli_query($conn, $sql);
    
 
              }
    
          } 

include "base.php"; $_SESSION = array(); session_destroy();


setcookie ("member_username","");
setcookie ("member_password","");

?>

<html>
<body>

<script type="text/javascript">
window.top.location.href = "index.php"; 
</script>
</body>
</html>

        
        
       