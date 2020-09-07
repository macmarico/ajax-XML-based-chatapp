<?php include "base.php";

if(empty($_SESSION['LoggedIn']) && empty($_SESSION['Username']))
{
        echo "<meta http-equiv='refresh' content='0,index.php' />";
        exit;
     }

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Chatspot - Join The Chat Community</title>
<link href="design.css" rel="stylesheet" type="text/css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body class=" body-define ProximaNovaRegular">
 <div class="load"><img src="loading.gif" alt="Loading Cycle" class="loading" style="width:50px; margin-left:calc(50% - 25px);margin-top:130px "></div>
     
   <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
</body>
</html>  
     
     <?php

        echo "<meta http-equiv='refresh' content='0,whois/online.php' />";
        exit;
    
    
  
 
 
 
 
 
 
 
 
 
 


?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Chatspot - Join The Chat Community</title>
<link href="design.css" rel="stylesheet" type="text/css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body class=" body-define ProximaNovaRegular">

<?php

$username = $_SESSION["Username"] ;
 
if(isset($_POST['status'])){

  
  $motive = addslashes($_POST['status']);
  $statusID = time();
  
  $sqlmotive = "UPDATE sessions SET status = '".$motive."' WHERE username= '".$_SESSION["Username"]."'";
    
    mysqli_query($conn, $sqlmotive);
    
     $sqlmotive = "UPDATE sessions SET statusID = '".$statusID."' WHERE username= '".$_SESSION["Username"]."'";
    
    mysqli_query($conn, $sqlmotive);
    
    
    $sqlmotiveusers = "UPDATE users SET status = '".$motive."' WHERE Username= '".$_SESSION["Username"]."'";
    
    mysqli_query($conn, $sqlmotiveusers);
    
     $sqlmotiveusers = "UPDATE users SET statusID = '".$statusID."' WHERE Username= '".$_SESSION["Username"]."'";
    
    mysqli_query($conn, $sqlmotiveusers);
    
    
    
    $filename2 = "users/$username/posts/files/$statusID/$statusID.xml";

    if(!file_exists($filename2)) {
    
          mkdir("users/$username/posts/files/$statusID");
          mkdir("users/$username/posts/files/$statusID/storage");
          mkdir("users/$username/posts/files/$statusID/storage/post");
          mkdir("users/$username/posts/files/$statusID/storage/comment");
          

          $doc = new DOMDocument();
          $foo = $doc->createElement("messages");
          $foo->setAttribute("category", "short");
          $doc->appendChild($foo);
          $doc->save("users/$username/posts/files/$statusID/$statusID.xml");
          
          
       $post = stripslashes($motive);
      
        $sxepostlist = simplexml_load_file("users/$username/posts/postlist.xml");
        $moviepostlist = $sxepostlist->addChild('postset');
        $eepostlist = $moviepostlist->addChild('username', "$username");
        $eepostlist = $moviepostlist->addChild('statusID', "$statusID");
        $eepostlist = $moviepostlist->addChild('post', "$post");
        $eepostlist = $moviepostlist->addChild('tag', 'motive');
       
        $sxepostlist->asXML("users/$username/posts/postlist.xml");
      
      
      
        $sxe = simplexml_load_file("feed/feed.xml");
        $movie = $sxe->addChild('postset');
        $ee = $movie->addChild('username', "$username");
        $ee = $movie->addChild('time', time());
        $ee = $movie->addChild('post', "$post");
        $ee = $movie->addChild('tag', 'motive');
        $sxe->asXML("feed/feed.xml");


          }
    ?>
    
       <div class="load"><img src="loading.gif" alt="Loading Cycle" class="loading" style="width:50px; margin-left:calc(50% - 25px);margin-top:130px "></div>
      <?php

        echo "<meta http-equiv='refresh' content='0,whois/feed.php' />";
        exit;
    
    
    
   }
   
   
   

?>


    <div class="setlayt"> 
  <div class="skipbar">



<?php
               
                  $sqlprevstatus = "SELECT status, statusID FROM users WHERE Username= '".$_SESSION["Username"]."'";
    
                $check = mysqli_fetch_assoc(mysqli_query($conn, $sqlprevstatus));
                
                if(!empty($check["status"]))

                  {
                 ?>
                 
                <form method="post" action="setup.php" name="registerform" id="registerform">
                <fieldset class="border-none">
                <input type="hidden" name="status" value="<?php echo $check["status"]; ?>">
                <input type="hidden" name="statusID" value="<?php echo $check["statusID"]; ?>">
                
                 <input type="submit" name="login" name="register" id="register"  value="Set Previuos And Next"  class="skip " />
  
                </fieldset>
                </form>
                
                <?php
                }
                ?>

</div>
        </div>
<div class="setlayt " >
  <div class="favtr"> <div class="avatar">
    <a href="chooseavatar.php">
    <img src="
    
      <?php
             $username = $_SESSION["Username"];
             $filename = "users/$username/notification/profilepic.svg";

            if (file_exists($filename)) {
                  echo "$filename";
                      } else {
                       echo "contact.svg";
                }
            ?>
    
   " width="50px" alt="avatar" class="mpic" ></a>
  </div>
  </div>
  
  <div class="bar setbar">

    <?php
echo "".$_SESSION['Username'].""; 
?>

  </div>
 

<div class="setlayt2">
<div class="setlayt">Tell people why you are here</div>
<div class="setlayt form2"><form method="post" action="setup.php" name="registerform" id="registerform"  >
<fieldset class="border-none">
        <div class=" class="form"">
                
                <input type="text" name="status" id="username" placeholder="Write your motive here" class="width ProximaNovaRegular inpdes msgbut" autocomplete="off" maxlength="20"  required />
               
                <div class="bars"><input type="submit" name="register" id="register" value="Set and update your own motive" class="button inpdes ProximaNovaRegular" /></div>
                </fieldset>
</form></div>


                
                
                
                <div class="setlayt">You Can Pick  Motive from Below </div>

                <div class="setlayt"><form method="post" action="setup.php" name="registerform" id="registerform" class="form">
                <fieldset class="border-none">
        <div class="bars">
                <input type="hidden" name="status" value="I need advice">
                <input type="submit" name="register" id="register" value="I need advice" class="button2 inpdes ProximaNovaRegular" /></div>
               
                </fieldset>
                </form></div>

                <div class="setlayt"><form method="post" action="setup.php" name="registerform" id="registerform" class="form">
                <fieldset class="border-none">
        <div class="bars">
                <input type="hidden" name="status" value="I'm bored need fun">
                <input type="submit" name="register" id="register" value="I'm bored need fun" class="button2 inpdes ProximaNovaRegular" /></div>
               
                </fieldset>
                </form></div>
                
                   <div class="setlayt"><form method="post" action="setup.php" name="registerform" id="registerform" class="form">
                <fieldset class="border-none">
        <div class="bars">
                <input type="hidden" name="status" value="I'm blissful right now">
                <input type="submit" name="register" id="register" value="I'm blissful right now" class="button2 inpdes ProximaNovaRegular" /></div>
                
                </fieldset>
                </form></div>
                
                   <div class="setlayt"><form method="post" action="setup.php" name="registerform" id="registerform" class="form">
                <fieldset class="border-none">
        <div class="bars">
                <input type="hidden" name="status" value="Looking for helpful friends">
                <input type="submit" name="register" id="register" value="Looking for helpful friends" class="button2 inpdes ProximaNovaRegular" /></div>
                 
                </fieldset>
                </form></div>
                
                
               
    
</div>
</div>
   
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
</body>
</html>