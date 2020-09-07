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
<meta name="theme-color" content="#ff6c00">


<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>



</head>
<body class=" body-define ProximaNovaRegular">
<div class="adj">
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
?> | Settings
 
        </div>
    </div> </a></div>

    <div class=" notifs"><a href="setting.php">
      <form method="get" action="../logout.php">
    <button type="submit" class="lgbut">Logout</button>
</form></a></div>
    </div>

<div class="tabs stickdiv">

    <div class="tab"><a href="online.php"><div  class=" mytab bor">FEED 
      <div id="green" class="mytab"><?php  echo $_SESSION["onlineusers"] ; ?> </div> </div></a></div>
    <div class="tab"><a href="inbox.php"><div id="inbox" class="actbor mytab">INBOX 
      <div id="red" class="mytab"><?php  echo $_SESSION["notification"] ; ?></div></div></a></div>
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


      $notify = $notification->$withoutext ;
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




if (is_dir($dir)){
  if ($dh = opendir($dir)){
    while (($file = readdir($dh)) !== false){
      $filename = $file ;
      $withoutext = basename($filename, '.xml');


      $notify = $notification->$withoutext ;
     $x =  $notify->count();
     if($x == "0"){
     
    
      if("$filename" != '.' AND "$filename" != '..' AND "$filename" != 'storage' AND "$filename" != 'notification' AND "$filename" != 'motive' )
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

            <div style="margin-left:38px" >status</div>


   
      


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
<div class="set">
  <div class="">All inbox will be cleared when you get logged out</div>
  <div style="font-size: 13px; color: #999">Now you can pin your favourite person</div>
</div>
 </div> 


<script src="../Relative Design.js"></script>
</body>
</html>