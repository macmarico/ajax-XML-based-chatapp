<?php include "base.php";

if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
{
        echo "<meta http-equiv='refresh' content='0,whois/home.php' />";
        exit;
     }
     



if(!empty($_POST['username']) && !empty($_POST['password']))
{


    $rest = substr($_POST['username'], 0, 1);

         if (preg_match('#[0-9]#',$rest)){
         
         
        
         

           echo "<h1 style=\"padding:10px;text-align:center\" >Sorry,</h1>";
           echo "<p style=\"padding:10px;text-align:center\" > you can not start with numbers. Please <a href=\"login.php\">click here to try again</a>.</p>";
                 
             exit();
                 
              }



 	$username = strtolower(mysqli_real_escape_string($conn,$_POST['username']));
        $password = md5(mysqli_real_escape_string($conn,$_POST['password']));
        $email = mysqli_real_escape_string($conn,$_POST['email']);
        
        
        
        
        
    $checklogin = mysqli_query($conn,"SELECT * FROM users WHERE Username = '".$username."' AND Password = '".$password."'");
    
    if(mysqli_num_rows($checklogin) == 1)
    {
    
    
    $checkblocked = mysqli_query($conn,"SELECT * FROM blocked WHERE Username = '".$username."'");
    
    if(mysqli_num_rows($checkblocked) == 1)
    {
    
    
     
    
      echo "<h1 style=\"padding:10px;text-align:center\" >Blocked</h1>";
      echo "<p style=\"padding:10px;text-align:center\" > that username is inappropriate or doesn't follow our guidelines. Please <a href=\"login.php\">click here to create a new account wih appropriate name</a>.</p>";
        
        
     exit;
    
    
    
    }
    
    
    
    
    
    
    
     if(!empty($_POST["remember"]))   
   {  
    setcookie ("member_username",$username,time()+ (10 * 365 * 24 * 60 * 60));  
    setcookie ("member_password",$password,time()+ (10 * 365 * 24 * 60 * 60));
    
   }  
 
    
    
        $row = mysqli_fetch_array($checklogin);
        $email = $row['EmailAddress'];
      
        
        $_SESSION['Username'] = $username;
        $_SESSION['EmailAddress'] = $email;
        $_SESSION['last_login_timestamp'] = time();
        $_SESSION['LoggedIn'] = 1;
        

        
        mysqli_query($conn,"INSERT INTO sessions (username, last_seen) VALUES('".$_SESSION["Username"]."', Now())");
        
    

      
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
    
    
    
       <div class="load"><img src="loading.gif" alt="Loading Cycle" class="loading" style="width:50px; margin-left:calc(50% - 25px);margin-top:130px "></div>
    <?php
    
        echo "<meta http-equiv='refresh' content='0,whois/home.php' />";
        exit;
        
        }
        
    
	 $checkusername = mysqli_query($conn,"SELECT * FROM users WHERE Username = '".$username."'");
         
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


<?php
     
     if(mysqli_num_rows($checkusername) == 1)
     {
     
     
         ?>
    
    <body class=" body-define ProximaNovaRegular">
<div class=" head" style="background-color: #fff; color: #fff;padding: 0px 0px" >
  <div style=" width: 96%;padding: 2%; color: #723408; font-size: 10px"><a href="changelog.html" style="float: left;">&copy chatify V.1 (BETA) </a>  <a href="terms.html" style="float: right;">Terms and Conditions</a> </div>
<div >
<div class="head-logo " style="color: #fff">
  
   
   
</div>
</div>
</div>
    
    <?php
     	
        
          echo "<h1 style=\"padding:10px;text-align:center\" >Sorry,</h1>";
          echo "<p style=\"padding:10px;text-align:center\" > <strong>Username is already taken </strong><br> Please enter correct password.</p>";
        
      ?>
      
      
      

<div class="main-body" style="padding: 10px 0px">
	
<div class="heading">GET IN </div>
<div class="border-none pcform"><form method="post" action="login.php" name="registerform" id="registerform" class="border-none form">
<fieldset class="border-none">
		<div class="bars"><input type="text" name="username" id="username" placeholder="Username" class="introinput inpdes ProximaNovaRegular" data-validation="alphanumeric" /></div>
        <br />
        <div class="bars"><input type="password" name="password" id="password" placeholder="Set Password / Password" class="introinput inpdes ProximaNovaRegular" /></div>
        <br />
        <div class="bars"><input type="hidden" name="email" id="email" placeholder="Email" class="introinput inpdes ProximaNovaRegular" /></div>
        <br />
        
        
       <div class="bars"> <input type="checkbox" name="remember" <?php if(isset($_COOKIE["member_username"])) { ?> checked <?php } ?> />  
       <label for="remember-me">Keep me logged in</label> </div>
        
        <br />
        
		<div class="bars"><input type="submit" name="register" id="register" value="LOGIN / REGISTER" class="button inpdes ProximaNovaRegular" /></div>
	</fieldset>
</form></div>
 <div style="text-align: center;color: #555; font-size: 13px;margin: 50px 10px; ">
 	
     By loging in, you agree to our <strong> terms & conditions </strong>
</div>
</div>
    
        
        
        
   <?php    
        
        
        
        
       
     }
     else
     {
     
     
      
          ?>
          
          
    
  
  <body class=" body-define ProximaNovaRegular">
<div class=" head" style="background-color: #f43e2e; color: #fff;padding: 0px 0px" >
  <div style=" width: 96%;padding: 2%; color: #723408; font-size: 10px"><a href="changelog.html" style="float: left;">&copy chatify V.1 (BETA) </a>  <a href="terms.html" style="float: right;">Terms and Conditions</a> </div>
<div style="padding: 30px 0px">
<div class="head-logo " style="color: #fff">
  <div class="border-none" style="background-color: #f43e2e;">
    <div style="text-align: center;margin: 0px 5px 0px 5px" ></div>
    <div class="heading" style="color: #000; ">Already have an account</div>
    <div style="text-align: center;color: #fff;margin: 0px 10px; padding: 10px 0px;"><a href="home.php"><strong>Go back</strong></a> and enter correct username.</div>
</div>
</div>
</div>
    
  
     
     <div class="border-none head" style="min-height: 400px"><form method="post" action="register.php" name="registerform" id="registerform" class="border-none form">
<fieldset class="border-none">
              <div class="heading" style="color: #000"> <br><br><br> Create a new account<br><br> <div style="font-size: 30px;padding: 25px 0px; text-align:center; color: #ff6c00; text-decoration: underline;"><?php echo $username; ?><br><br></div></div>
               
               
        <div class="bars"><input type="hidden" name="email" id="username" placeholder="email" class="introinput inpdes ProximaNovaRegular"  required /></div>
            
        <input type="hidden" name="username" value="<?php echo $username; ?>">
        
        <input type="hidden" name="password" value="<?php echo $password; ?>">
        
		<div class="bars"><input type="submit" name="register" id="register" value="TAKE THIS USERNAME" class="button inpdes ProximaNovaRegular" /></div>
        <div></div>
	</fieldset>
</form></div>
     
     
     <?php
     
    
     }
}
else
{
	?>
   
   
   
   
   <body class=" body-define ProximaNovaRegular">
<div class=" head" style="background-color: #f43e2e; color: #fff;padding: 0px 0px" >
  <div style=" width: 96%;padding: 2%; color: #723408; font-size: 10px"><a href="changelog.html" style="float: left;">&copy chatify V.1 (BETA) </a>  <a href="terms.html" style="float: right;">Terms and Conditions</a> </div>
<div style="padding: 30px 0px">
<div class="head-logo " style="color: #fff">
  <div class="border-none" style="background-color: #f43e2e;">
    <div style="text-align: center;margin: 0px 5px 0px 5px" ></div>
   <div class="heading" style="color: #000; ">CHATSPOT</div>
    <div style="text-align: center;color: #fff;margin: 0px 10px; padding: 10px 0px;">Enter with guest like login  </div>
</div>
</div>
</div>
 
 
 


<div class="main-body" style="padding: 10px 0px">
	
<div class="heading">GET IN </div>
<div class="border-none pcform"><form method="post" action="login.php" name="registerform" id="registerform" class="border-none form">
<fieldset class="border-none">
		<div class="bars"><input type="text" name="username" id="username" placeholder="Username" class="introinput inpdes ProximaNovaRegular" data-validation="alphanumeric" /></div>
        <br />
        <div class="bars"><input type="password" name="password" id="password" placeholder="Set Password / Password" class="introinput inpdes ProximaNovaRegular" /></div>
        <br />
        <div class="bars"><input type="hidden" name="email" id="email" placeholder="Email" class="introinput inpdes ProximaNovaRegular" /></div>
        <br />
        
        
       <div class="bars"> <input type="checkbox" name="remember" <?php if(isset($_COOKIE["member_username"])) { ?> checked <?php } ?> />  
       <label for="remember-me">Keep me logged in</label> </div>
        
        <br />
        
		<div class="bars"><input type="submit" name="register" id="register" value="LOGIN / REGISTER" class="button inpdes ProximaNovaRegular" /></div>
	</fieldset>
</form></div>
 <div style="text-align: center;color: #555; font-size: 13px;margin: 50px 10px; ">
 	
     By loging in, you agree to our <strong> terms & conditions </strong><br><br> <br><br><br> 
</div>
</div>
    
   <?php
}
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