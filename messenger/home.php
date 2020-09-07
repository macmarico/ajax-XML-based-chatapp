<?php
include "base.php";



if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
{
        echo "<meta http-equiv='refresh' content='0,whois/home.php' />";
        exit;
     }
     
     
if(isset($_COOKIE["member_username"]) && isset($_COOKIE["member_password"]))
{



        
        $_SESSION['Username'] = $_COOKIE["member_username"];
        
        $_SESSION['last_login_timestamp'] = time();
        $_SESSION['LoggedIn'] = 1;
        

        
        mysqli_query($conn,"INSERT INTO sessions (username, last_seen) VALUES('".$_SESSION["Username"]."', Now())");
        
    

      
    ?>                      
       <div class="load"><img src="loading.gif" alt="Loading Cycle" class="loading" style="width:50px; margin-left:calc(50% - 25px);margin-top:130px "></div>
    <?php
    
        echo "<meta http-equiv='refresh' content='0,whois/home.php' />";
        exit;

     }     





  
    $result = mysqli_query($conn,"SELECT * FROM sessions");
    $num_rows = mysqli_num_rows($result);

    $_SESSION["onlineusers"] = $num_rows;
    

 ?>
 
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Sweeters : meet laugh with strangers. 
       

</title>
<link href="../design.css" rel="stylesheet" type="text/css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="#f43e2e">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body class=" body-define ProximaNovaRegular">
 <div class="adj" style="background-color:white; ">

    <div id="usn"   >
    
        <br style="height:0.2;">
      <div class="b2 unadj" style="color:#f43e2e; text-align: center;" > <img src="img_424217.svg" width="15px"> 
             <strong>Sweeters</strong>
             
     
        </div>
</div>

   
    </div>
    
<div>


   

<br>
<div class="main-body" >



     <h3 class="header center text-lighten-2" style="padding:10px;text-align: center;color:#555;font-size:35px;" >SWEET SOCIAL NETWORK</h3>
 
<div style="padding: 10px 60px 20px 60px">



<div class="heading">GET IN </div>  <br>
<div class="border-none pcform"><form method="post" action="../login.php" name="registerform" id="registerform" class="border-none form">
<fieldset class="border-none">
		<div class="bars"><input type="text" name="username" id="username" placeholder="Username" class="introinput inpdes ProximaNovaRegular" data-validation="alphanumeric" /></div>
        <br />
        <div class="bars"><input type="password" name="password" id="password" placeholder="Password" class="introinput inpdes ProximaNovaRegular" /></div>
        <br />
        <div class="bars"><input type="hidden" name="email" id="email" placeholder="Email" class="introinput inpdes ProximaNovaRegular" /></div>
        
        
          <div class="bars"> <input type="checkbox" name="remember" <?php if(isset($_COOKIE["member_username"])) { ?> checked <?php } ?> />  
       <label style="color: #555; font-size: 15px;margin: 50px 10px; " for="remember-me">Keep me logged in</label> </div>
        <br />
        
		<div class="bars"><input type="submit" name="register" id="register" value="LOGIN / REGISTER" class="button inpdes ProximaNovaRegular" /></div>
	</fieldset>
</form></div>
 <div style="text-align: center;color: #555; font-size: 13px;margin: 30px 10px; ">
 	
   By loging in, you agree to our <a href="terms.html"> <strong> terms & conditions </strong></a><br><br> <br><br><br>

<br>
</div>
</div>
</div>
  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
<script>
  $.validate({
    lang: 'en'
  });
</script>
</body>
</html>