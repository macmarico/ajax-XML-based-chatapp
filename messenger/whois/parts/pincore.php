<?php 
include "../../base.php";
?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Setup</title>
<link href="../../design.css" rel="stylesheet" type="text/css">

<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class=" body-define ProximaNovaRegular">

<?php


$username = $_SESSION["Username"];

if(isset($_POST['friendname'])){

  $filename = "../../users/$username/notification/pinfriend.xml";

      if(!file_exists($filename)) {
                 
                   $pindoc = new DOMDocument();
                
                   $pinfoo = $pindoc->createElement("apps");
                   $pinfoo->setAttribute("category", "essential");
                   $pindoc->appendChild($pinfoo);
                   
               
                   $pindoc->save("../../users/$username/notification/pinfriend.xml");

                          }


        $friendname = addslashes($_POST['friendname']);
        $sxe = simplexml_load_file("../../users/$username/notification/pinfriend.xml");
        $movie = $sxe->addChild('personset');
        $ee = $movie->addChild('username', "$friendname");
       
        $sxe->asXML("../../users/$username/notification/pinfriend.xml");
        
     
    }
    
    
 if(isset($_POST['unpinname'])){


        $unpinfriendname = addslashes($_POST['unpinname']);
        $dom = new DOMDocument();
        $dom->load("../../users/$username/notification/pinfriend.xml");
        $xpath = new DOMXPath($dom);
        
        
        
        foreach ($xpath->query("/apps/personset[username= '$unpinfriendname']") as $node) {
           $node->parentNode->removeChild($node);
          }
        
        


         $dom->save("../../users/$username/notification/pinfriend.xml");

        }

  
  
  
  $xml =simplexml_load_file("../../users/$username/notification/pinfriend.xml") or die("Error: Cannot create object");
     
 
           
             ?>                      
   

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
<script>
  $.validate({
    lang: 'en'
  });
</script>
</body>
</html>