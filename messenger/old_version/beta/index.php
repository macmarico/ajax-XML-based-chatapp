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

$notification =simplexml_load_file("../users/$username/notification/notification.xml") or die("Error: Cannot create object"); // notification count

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
    <div class="tab "><a href="club.php"><div class="bor ">FEED
    <div id="green" class="mytab"><?php  echo $newclubmasseges ; ?> </div></div></a></div>
    <div class="tab "><a href="index.php"><div class="actbor ">USERS</div></a></div>
    <div class="tab"><a href="online.php"><div id="online" class="bor mytab">ONLINE 
      <div id="green" class="mytab"><?php  echo $_SESSION["onlineusers"] ; ?> </div> </div></a></div>
    <div class="tab"><a href="inbox.php"><div id="inbox" class="bor mytab">INBOX 
      <div id="red" class="mytab"><?php  echo $_SESSION["notification"] ; ?></div></div></a></div>
  </div>
  
<div class="member">
<?
$sql = "SELECT * FROM users ORDER BY Username";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {

    if ($row["Username"] != $username) {

         $checkblocked = mysqli_query($conn,"SELECT * FROM blocked WHERE Username = '".$row["Username"]."'");
         
        if (mysqli_num_rows($checkblocked) == 0) {  
          
           $x = '0';
          $personalblock = "../users/$username/notification/blocked.xml";
           if (file_exists($personalblock)) {

              $personalblock =simplexml_load_file("../users/$username/notification/blocked.xml");
              $checkpersonalblock = $personalblock->$row["Username"] ;
              $x =  $checkpersonalblock->count();

           }

        
          if($x == "0"){
    

       ?>

<div class="memlayt">
      <form method="post" action="core.php">

<div class="row">
        <div class="b1" >
          <img src=
          
            <?php
          
          $dp = $row["Username"];
          
          
             $filename = "../users/$dp/notification/profilepic.svg";

            if (file_exists($filename)) {
                  echo "$filename";
                      } else {
                       echo "../contact.svg";
                }
            ?>

           width="30px" alt="avatar" style="border-radius: 45px;"  >

        </div>
        <div class="b2" >
           
             <input type="hidden" name="recivernm" value="<?php echo $row["Username"]; ?>">
     <input type="submit" style="height: 30px" class="simbut ProximaNovaRegular " value ="<?php echo $row["Username"]; ?>"> 
        </div>
    </div>
    
     

   </form>
  
</div>



           <?php  

             }           

            }
            } ;
    }
} else {
    echo "0 results";
}

mysqli_close($conn);
?>

</div>

<script src="../Relative Design.js"></script>
</body>
</html>

