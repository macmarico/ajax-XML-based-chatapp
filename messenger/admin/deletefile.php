<?php
include "../base.php";

function removeDirectory($path) {
 	$files = glob($path . '/*');
	foreach ($files as $file) {
		is_dir($file) ? removeDirectory($file) : unlink($file);
	}
	rmdir($path);
 	return;
}



$sql = "SELECT * FROM blocked";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {

   $usnm = $row["Username"] ;
        


    
    
    $checkdir = "../users/$usnm";

            if(is_dir($checkdir))
            {
                removeDirectory("../users/$usnm");
                
                echo $usnm ;
            }
       
    
    }
    }
   
?>