<?php 
include "../base.php";

$username = $_SESSION["Username"];

if(isset($_POST['friendname'])){

  $filename = "../users/$username/notification/pinfriend.xml";

      if(!file_exists($filename)) {
                 
                   $pindoc = new DOMDocument();
                
                   $pinfoo = $pindoc->createElement("apps");
                   $pinfoo->setAttribute("category", "essential");
                   $pindoc->appendChild($pinfoo);
                   
               
                   $pindoc->save("../users/$username/notification/pinfriend.xml");

                          }


        $friendname = addslashes($_POST['friendname']);
        $pinsxe = simplexml_load_file("../users/$username/notification/pinfriend.xml");
        $pinsxe->addChild($friendname, "$username");
       
        $pinsxe->asXML("../users/$username/notification/pinfriend.xml");

    }
    
    
 if(isset($_POST['unpinname'])){


        $unpinfriendname = addslashes($_POST['unpinname']);
        $dom = new DOMDocument();
        $dom->load("../users/$username/notification/pinfriend.xml");
        $xpath = new DOMXPath($dom);

        foreach ($xpath->evaluate($unpinfriendname) as $node) {
        $node->parentNode->removeChild($node);
         }

         $dom->save("../users/$username/notification/pinfriend.xml");

        }

  
  
  
  $xml =simplexml_load_file("../users/$username/notification/pinfriend.xml") or die("Error: Cannot create object");
     
 
     foreach($xml->children() as $message)

    { 
   
          print $message->getName();

           }
           
            echo "<meta http-equiv='refresh' content='0,inbox.php' />";
  
?>