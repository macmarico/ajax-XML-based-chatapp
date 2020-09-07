<?php include "../base.php";


function removeDirectory($path) {
 	$files = glob($path . '/*');
	foreach ($files as $file) {
		is_dir($file) ? removeDirectory($file) : unlink($file);
	}
	rmdir($path);
 	return;
}



if(isset($_POST['recivernm'])){

 	$username = $_POST['recivernm'];
               
        
     	$registerquery = mysqli_query($conn,"INSERT INTO blocked (Username) VALUES('".$username."')");
        if($registerquery)
        {
                    echo 'done';
                    
            $checkdir = "../users/$username";

            if(is_dir($checkdir))
            {
                removeDirectory("../users/$username");
                
                echo $username ;
                echo 'removed' ;
            }
                    

        }
        else
        {
        
                echo 'not done';
     		
        	 
        }    	
 }    

else
{

 echo 'go back';
	
}

?>