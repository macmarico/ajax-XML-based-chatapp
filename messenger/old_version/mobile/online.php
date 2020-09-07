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





if(isset($_POST['changemotive'])){

 
  $motive = addslashes($_POST['changemotive']);
  
  $sqlmotive = "UPDATE sessions SET status = '".$motive."' WHERE username= '".$_SESSION["Username"]."'";
    
    mysqli_query($conn, $sqlmotive);
    
    
    $sqlmotiveusers = "UPDATE users SET status = '".$motive."' WHERE Username= '".$_SESSION["Username"]."'";
    
    mysqli_query($conn, $sqlmotiveusers);
    
   }
   
   
   
   /* Like and dislike */
   
   if(isset($_POST['like'])){

 
    $fetchlike = mysqli_query($conn,"SELECT like FROM users WHERE username= '".$_SESSION["Username"]."'");
    
    if(mysqli_num_rows($checklogin) == 1)
    {
       $newlike = $fetchlik++;
    }
  
  $sqllike = "UPDATE sessions SET like = '".$newlike."' WHERE username= '".$_SESSION["Username"]."'";
    
    mysqli_query($conn, $sqllike);
    
    
    $sqllikeusers = "UPDATE users SET status = '".$newlike."' WHERE Username= '".$_SESSION["Username"]."'";
    
    mysqli_query($conn, $sqllikeusers);
    
   }
   
   
      if(isset($_POST['dislike'])){

 
    $fetchlike = mysqli_query($conn,"SELECT like FROM users WHERE username= '".$_SESSION["Username"]."'");
    
    if(mysqli_num_rows($checklogin) == 1)
    {
       $newlike = $fetchlik--;
    }
  
  $sqllike = "UPDATE sessions SET like = '".$newlike."' WHERE username= '".$_SESSION["Username"]."'";
    
    mysqli_query($conn, $sqllike);
    
    
    $sqllikeusers = "UPDATE users SET status = '".$newlike."' WHERE Username= '".$_SESSION["Username"]."'";
    
    mysqli_query($conn, $sqllikeusers);
    
   }
   
  
   
    /* Like and dislike */
   
     
   $username = $_SESSION["Username"];

   $notification =simplexml_load_file("../users/$username/notification/notification.xml");

   $_SESSION["notification"] = $notification->count();
   
   $loadclub =simplexml_load_file("../clubs/club.xml");
 
   $contcurntclubmssges = $loadclub->count();
   $newclubmasseges = $contcurntclubmssges -$_SESSION['countclubmessages'];
   
   
   
   $filenamewe = "../users/$username/notification/pinfriend.xml";

      if(!file_exists($filenamewe)) {
                 
                   $pindoc = new DOMDocument();
                
                   $pinfoo = $pindoc->createElement("apps");
                   $pinfoo->setAttribute("category", "essential");
                   $pindoc->appendChild($pinfoo);
                   
               
                   $pindoc->save("../users/$username/notification/pinfriend.xml");

                          }


?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Home</title>
<link href="../design.css" rel="stylesheet" type="text/css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="#ff6c00">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
    
<div class="tabs">
    <div class="tab stickdiv"><a href="club.php"><div class="bor ">CLUB
    <div id="green" class="mytab"><?php  echo $newclubmasseges ; ?> </div></div></a></div>
    <div class="tab "><a href="index.php"><div class="bor ">USERS</div></a></div>
    <div class="tab"><a href="online.php"><div id="online" class="actbor mytab">ONLINE 
      <div id="green" class="mytab"><?php  echo $_SESSION["onlineusers"] ; ?> </div> </div></a></div>
    <div class="tab"><a href="inbox.php"><div id="inbox" class="bor mytab">INBOX 
      <div id="red" class="mytab"><?php  echo $_SESSION["notification"] ; ?></div></div></a></div>
  </div>
  
 <div class="msgbar mbc">
       <div class="msgtab">
<div class="row">
        <div class="b1" >
          <img src=
          
          
          <?php
          
          
          
          
             $filename = "../users/$username/notification/profilepic.svg";

            if (file_exists($filename)) {
                  echo "$filename";
                      } else {
                       echo "../contact.svg";
                }
            ?>
          
          
          
          
          
          
          
          width="50px" alt="avatar" style="border-radius: 45px;">
        </div>
        <div class="b2 statwidth" >
           <div class="dstatus">
    
    
      <?php
           
           
           $sqlstatus = "SELECT status FROM sessions WHERE username= '".$username."'";
    
                $check = mysqli_fetch_assoc(mysqli_query($conn, $sqlstatus));
                
                if(!empty($check["status"]))
                {
                echo $check["status"];
                }else{ echo 'no status' ;}
                
                ?>
                
    <form method="post" action="online.php">
      <div class="row postbar">
      <div  style="width: 78%">
        <input type="text" name="changemotive"  placeholder="Change Motive"  autocomplete="off" class="postinput" />
       
      </div>
        <div style="width: 20%">
            <input type="submit" name="login" value="SET" class="postbut">
              </div>
            </div>

        </form>

      
        </div>


    </div>
</div>
 </div>
</div>


 <div class="member">
 

<?php

$sql = "SELECT * FROM sessions";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {

    if ($row["username"] != $username) {



      $checkblocked = mysqli_query($conn,"SELECT * FROM blocked WHERE Username = '".$row["username"]."'");
         
        if (mysqli_num_rows($checkblocked) == 0) {  
          
           $x = '0';
          $personalblock = "../users/$username/notification/blocked.xml";
           if (file_exists($personalblock)) {

              $personalblock =simplexml_load_file("../users/$username/notification/blocked.xml");
              $checkpersonalblock = $personalblock->$row["username"] ;
              $x =  $checkpersonalblock->count();

           }

        
          if($x == "0"){



       ?>


<form method="post" action="core.php">
<div class="memlayt">
<div class="row">
        <div class="b1" >
          <img src=
          
          
          <?php
          
          $dp = $row["username"];
          
          
             $filename = "../users/$dp/notification/profilepic.svg";

            if (file_exists($filename)) {
                  echo "$filename";
                      } else {
                       echo "../contact.svg";
                }
            ?>
          
          
          
          
          
          
          
          width="50px" alt="avatar" style="border-radius: 45px;">
        </div>
        <div class="b2 statwidth2" >
           <div class="dstatus">
    
    
      <?php
           
           
           $sqlstatus = "SELECT status FROM sessions WHERE username= '".$row["username"]."'";
    
                $check = mysqli_fetch_assoc(mysqli_query($conn, $sqlstatus));
                
                if(!empty($check["status"]))
                {
                echo $check["status"];
                }else{ echo 'no status' ;}
                
                ?>
                
    
    
      </div style="height: 13px;">
             <div ><input type="hidden" name="recivernm" value="<?php echo $row["username"]; ?>">
     <input type="submit" class="stsname ProximaNovaRegular  " value ="<?php echo $row["username"]; ?>">
      </div>
      
        </div>
         

    </div>
    
     </div>

   </form>



        


           <?php } ;

         }
    }

  }
} else {
    echo "0 results";
}

mysqli_close($conn);

 

?>
</div>



<script src="../Relative Design.js"></script>
<script>
function myFunction(x) {
    x.classList.toggle("fa-thumbs-down");
}
</script>
</body>
</html>


