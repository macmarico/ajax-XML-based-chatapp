<?php include "base.php";

 

if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
{
        echo "<meta http-equiv='refresh' content='0,whois/home.php' />";
        exit;
     }
     
    


?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Chatify - Know what's happning through people</title>
<link href="design.css" rel="stylesheet" type="text/css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body class=" body-define ProximaNovaRegular">
<div class=" head">
<div class="head-logo ">
  <div class=""><img src="img_424217.svg" width="15px"><span> </span>ChitChat</div></div>
    <div class="slogan">Know what's happning through people</div>
</div>


<?php
if(!empty($_POST['username']) && !empty($_POST['password']))
{

        $username = $_POST['username'];
        $password = $_POST['password'];


    $rest = substr($_POST['username'], 0, 1);

         if (preg_match('#[0-9]#',$rest)){

           echo "<h1 style=\"padding:10px;text-align:center\" >Sorry,</h1>";
           echo "<p style=\"padding:10px;text-align:center\" > you can not start with numbers. Please <a href=\"login.php\">click here to try again</a>.</p>";
                 
             exit();
                 
              }
       
        if(preg_match('#^(([a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+\.?)*[a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+)@(([a-z0-9-_]+\.?)*[a-z0-9-_]+)\.[a-z]{2,}$#i',$_POST['email']))
       {
       
           
           ?>
           <div class="border-none head" style="min-height: 400px"><form method="post" action="register.php" name="registerform" id="registerform" class="border-none form">
<fieldset class="border-none">
              <div class="heading" style="padding: 45px 0px"> Your email is invalid <div style="font-size: 25px;padding: 25px 0px; text-align:center; color: #ff6c00; text-decoration: underline;"><?php echo $username; ?></div></div>
               
               
        <div class="bars"><input type="text" name="email" id="username" placeholder="Retype email" class="introinput inpdes ProximaNovaRegular" data-validation="alphanumeric" required /></div>
            
        <input type="hidden" name="username" value="<?php echo $username; ?>">
        
        <input type="hidden" name="password" value="<?php echo $password; ?>">
        
		<div class="bars"><input type="submit" name="register" id="register" value="TAKE THIS USERNAME" class="button inpdes ProximaNovaRegular" /></div>
        <div></div>
	</fieldset>
</form></div>

<?php
           
                  exit ;
       }


 	$username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        
        
        
     	
        $registerquery = mysqli_query($conn,"INSERT INTO users (Username, Password, EmailAddress) VALUES('".$username."', '".$password."', '".$email."')");
       
        if($registerquery)
        {
        
                
           
                   $usnm = addslashes(strtolower($_POST['username']));
                   mkdir("users/$usnm");
                   mkdir("users/$usnm/storage");
                   mkdir("users/$usnm/notification");
                   mkdir("users/$usnm/posts");
                   mkdir("users/$usnm/posts/files");
                  
               
                   $doc = new DOMDocument();
                   $foo = $doc->createElement("apps");
                   $foo->setAttribute("category", "essential");
                   $doc->appendChild($foo);
                   $doc->save("users/$usnm/notification/notification.xml");
                   
                  
                   $pindoc = new DOMDocument();
                   $pinfoo = $pindoc->createElement("apps");
                   $pinfoo->setAttribute("category", "essential");
                   $pindoc->appendChild($pinfoo); 
                   $pindoc->save("users/$username/notification/pinfriend.xml");
                   
                   
                    $postdoc = new DOMDocument();
                    $postfoo = $postdoc->createElement("posts");
                    $postfoo->setAttribute("category", "short");
                    $postdoc->appendChild($postfoo);
                    $postdoc->save("users/$usnm/posts/postlist.xml");
          


        	  
    
    $checklogin = mysqli_query($conn,"SELECT * FROM users WHERE Username = '".$_POST['username']."' AND Password = '".$_POST['password']."'");
    
    if(mysqli_num_rows($checklogin) == 1)
    {
    	 $row = mysqli_fetch_array($checklogin);
        $email = $row['EmailAddress'];
        
        $_SESSION['Username'] = $username;
        $_SESSION['EmailAddress'] = $email;
        $_SESSION['last_login_timestamp'] = time();
        $_SESSION['LoggedIn'] = 1;
        
    
        
        mysqli_query($conn,"INSERT INTO sessions (username, last_seen) VALUES('".$_SESSION["Username"]."', Now())");
        
           echo "<meta http-equiv='refresh' content='0,chooseavatar.php' />";
           exit;
        

    }

        }
        else
        {
        
                echo "<h1 style=\"padding:10px;text-align:center\" >Sorry,</h1>";
                echo "<p style=\"padding:10px;text-align:center\" > your registration failed. Please <a href=\"login.php\">click here to try again</a>.</p>";
     		
        	 
        }    	
     
}
else
{

 echo 'go back';
	
}
?>


<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
</body>
</html>