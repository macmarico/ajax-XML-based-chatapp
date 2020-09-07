<?php
include "../base.php";

unset ($_SESSION["recivernmsess"]);



if(empty($_SESSION['LoggedIn']) && empty($_SESSION['Username']))
{
        echo "<meta http-equiv='refresh' content='0,../index.php' />";
        exit;
     }
     
       else
{



    $_SESSION['last_login_timestamp'] = time();
    
    
    
           $sqlcheckonline = mysqli_query($conn,"SELECT * FROM sessions WHERE username= '".$_SESSION["Username"]."'");
   
                
                 if(mysqli_num_rows($sqlcheckonline) == 1)
                {
               
                    
                mysqli_query($conn,"UPDATE sessions SET last_seen = Now() WHERE username= '".$_SESSION["Username"]."'");
    
               
               
                }
                else{
                
                mysqli_query($conn,"INSERT INTO sessions (username, last_seen) VALUES('".$_SESSION["Username"]."', Now())");
                
                }
    
    
    
    
    
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
<meta name="theme-color" content="#f43e2e">


<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>



</head>
<body class=" body-define ProximaNovaRegular">
<div class="adj" style=" height: 53px">
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
      <form method="get" action="../logout.php">
    <button type="submit" class="lgbut">Logout</button>
</form></a></div>
    </div>

<div class="tabs stickdiv">


    <div class="tab "><a href="home.php"><div class="mytab bor ">FEED</div></a></div> 
   
    
    
    <div class="tab"><a href="online.php"><div  class=" mytab bor">ONLINE 
      <div id="green" style="color:green;"  class="mytab"><?php  echo $_SESSION["onlineusers"] +200 ; ?> </div> </div></a></div>
   
  
    <div class="tab"><a href="inbox.php"><div id="inbox" class="actbor">CHATS
      <div id="demo" style="color:green;"  class="mytab"><?php  echo $_SESSION["notification"] ; ?></div></div></a></div>
  
  </div>
  


 <div class="member">

<?php




if(isset($_POST['recivernm'])){

$recivernm = $_POST['recivernm'];
$withoutext = $_POST['withoutext'];

$dirrr = "../users/$username/$recivernm";

unlink($dirrr) ;


$dom = new DOMDocument();
$dom->load("../users/$username/notification/notification.xml");
$xpath = new DOMXPath($dom);

foreach ($xpath->evaluate($withoutext) as $node) {
  $node->parentNode->removeChild($node);
}

$dom->save("../users/$username/notification/notification.xml");



}




$dir = "../users/$username";

// Open a directory, and read its contents
if (is_dir($dir)){
  if ($dh = opendir($dir)){
    while (($file = readdir($dh)) !== false){
      $filename = $file ;
      $withoutext = basename($filename, '.xml');

      
   
     $dom = new DOMDocument();
     $dom->load("../users/$username/notification/notification.xml");
     $xpath = new DOMXPath($dom);
     
    $notify = $xpath->query("/apps/notifset[username= '$withoutext']");
  
    $x =  $notify->count();
     
     
     if($x != "0"){
     
    
      if("$filename" != '.' AND "$filename" != '..' AND "$filename" != 'storage' AND "$filename" != 'notification' AND "$filename" != 'motive')
      {
      

?>

 

  
   
   
    
     

  
    
 

    <div class="meslayt" >
          

          <div class="mytab">
  <form method="post" action="core.php" class="mytab autowidth">


     <div class="row">
        <div class="b1" >
          <img src=
          
           <?php
       
          
          
             $dplocation = "../users/$withoutext/notification/profilepic.svg";

            if (file_exists($dplocation)) {
                  echo "$dplocation";
                      } else {
                       echo "../contact.svg";
                }
            ?>
          
          
          
          
          
          
           width="30px" alt="avatar" style="border-radius: 45px">
        </div>
        <div class="b2" >

             <input type="hidden" name="recivernm" value="<?php echo $withoutext; ?>">
       <input type="submit" class="simbut ProximaNovaRegular" value ="<?php echo $withoutext; ?>">
      
        </div>
        <div style="display: inline-block;
  background-color: #29a029;
  color: #fff;
  border: none;
  border-radius: 2px; min-width: 20px; text-align: center;">      
  <?php
   
     echo $x;
     
    ?>
    </div>
    </div>




   
      


       </form>
       </div>
       
         <?php 
       $xmlii =simplexml_load_file("../users/$username/notification/pinfriend.xml") or die("Error: Cannot create object");
        $checkvari = 0;
       foreach($xmlii->children() as $message)

          { 
   
          if($message->getName() == $withoutext){
              
              $checkvari = 1 ;

           }
           
       } 
       
       if( $checkvari == 0 ){
     ?>
       
       
       
       
       <div class="mytab" style="float: right;" >
           <form method="post" action="pinfriend.php" >
        <input type="hidden" name="friendname" value="<?php echo $withoutext; ?>">
    <input type="submit" class="canchat"  value ="<?php echo 'Pin'; ?>">
    </form>
      </div>
      
    <?php  }else{ ?>
    
    
    <div class="mytab" style="float: right;" >
           <form method="post" action="pinfriend.php" >
        <input type="hidden" name="unpinname" value="<?php echo $withoutext; ?>">
    <input type="submit" class="canchat"  value ="<?php echo 'Unpin'; ?>">
    </form>
      </div>
    
    
    <?php
    
    }
    
    ?>
      
          <div class="mytab" style="float: right;" >
           <form method="post" action="inbox.php" >
    <input type="hidden" name="recivernm" value="<?php echo  $filename; ?>">
    <input type="hidden" name="withoutext" value="<?php echo $withoutext; ?>">
    <input type="submit" class="canchat"  value ="<?php echo 'Remove'; ?>">
    </form>
      </div>
      </div>
     
 
 

    
    
  
    <?php
    
    }
  }
  }

    closedir($dh);
  }
}




if (is_dir($dir)){
  if ($dh = opendir($dir)){
    while (($file = readdir($dh)) !== false){
      $filename = $file ;
      $withoutext = basename($filename, '.xml');


       $dom = new DOMDocument();
     $dom->load("../users/$username/notification/notification.xml");
     $xpath = new DOMXPath($dom);
     
    $notify = $xpath->query("/apps/notifset[username= '$withoutext']");
  
    $x =  $notify->count();
    
     if($x == "0"){
     
    
      if("$filename" != '.' AND "$filename" != '..' AND "$filename" != 'storage' AND "$filename" != 'notification' AND "$filename" != 'posts' )
      {
      

?>

 

  
   
   
    
     

  
    
 

    <div class="meslayt" >
          

          <div class="mytab">
  <form method="post" action="core.php" class="mytab autowidth">


     <div class="row">
        <div class="b1" >
          <img src=
          
           <?php
       
          
          
             $dplocation = "../users/$withoutext/notification/profilepic.svg";

            if (file_exists($dplocation)) {
                  echo "$dplocation";
                      } else {
                       echo "../contact.svg";
                }
            ?>
          
          
          
          
          
          
           width="30px" alt="avatar" style="border-radius: 45px">
        </div>
        <div class="b2" >

             <input type="hidden" name="recivernm" value="<?php echo $withoutext; ?>">
       <input type="submit" class="simbut ProximaNovaRegular" value ="<?php echo $withoutext; ?>">
      
        </div>
        <div style="display: inline-block;
  background-color: #29a029;
  color: #fff;
  border: none;
  border-radius: 2px; min-width: 20px; text-align: center;">      
  <?php
    $notify = $notification->$withoutext ;
     $x =  $notify->count();
     if($x != "0"){
     echo $x;
      }
    ?>
    </div>
    </div>




   
      


       </form>
       </div>
       
       
       
       <?php 
       $xmlii =simplexml_load_file("../users/$username/notification/pinfriend.xml") or die("Error: Cannot create object");
        $checkvari = 0;
       foreach($xmlii->children() as $message)

          { 
   
          if($message->getName() == $withoutext){
              
              $checkvari = 1 ;

           }
           
       } 
       
       if( $checkvari == 0 ){
     ?>
       
       
       
       
       <div class="mytab" style="float: right;" >
           <form method="post" action="pinfriend.php" >
        <input type="hidden" name="friendname" value="<?php echo $withoutext; ?>">
    <input type="submit" class="canchat"  value ="<?php echo 'Pin'; ?>">
    </form>
      </div>
      
    <?php  }else{ ?>
    
    
    <div class="mytab" style="float: right;" >
           <form method="post" action="pinfriend.php" >
        <input type="hidden" name="unpinname" value="<?php echo $withoutext; ?>">
    <input type="submit" class="canchat"  value ="<?php echo 'Unpin'; ?>">
    </form>
      </div>
    
    
    <?php
    
    }
    
    
    ?>
          <div class="mytab" style="float: right;" >
           <form method="post" action="inbox.php" >
    <input type="hidden" name="recivernm" value="<?php echo  $filename; ?>">
     <input type="hidden" name="withoutext" value="<?php echo $withoutext; ?>">
    <input type="submit" class="canchat"  value ="<?php echo 'Remove'; ?>">
    </form>
      </div>
      </div>
     
 
 

    
    
  
    <?php
    
    }
  }
  }

    closedir($dh);
  }
}











?>

 </div> 
 
 
 
 <script>
 
 function foo() {



var xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
          var xmlDoc = this.responseXML;
    
    var nodes = xmlDoc.getElementsByTagName('notifset'), 
    amountOfNodes = nodes.length
     document.getElementById("demo").innerHTML = amountOfNodes;
    }
};
xhttp.open("GET", "../users/<?php echo $username; ?>/notification/notification.xml", false);

xhttp.setRequestHeader('Cache-Control', 'no-cache');
xhttp.send();


setTimeout(foo, 1000);

}

foo();

</script>


<script src="../Relative Design.js"></script>
</body>
</html>