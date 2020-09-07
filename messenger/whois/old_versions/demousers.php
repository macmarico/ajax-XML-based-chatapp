<?php include "base.php";?>

<html>
<head>
<meta charset="utf-8">
<title>Chatify - Know what's happning through people</title>
<link href="design.css" rel="stylesheet" type="text/css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="#f43e2e">
</head>




<?php




















if(!empty($_POST['username']) && !empty($_POST['status']))
{





 mysqli_query($conn,"INSERT INTO demosessions (username, status) VALUES('".$_POST['username']."', '".$_POST['status']."')");







}


?>








<div class="main-body" style="padding: 10px 0px">
	
<div class="heading">GET IN </div>
<div class="border-none pcform"><form method="post" action="demousers.php" name="registerform" id="registerform" class="border-none form">
<fieldset class="border-none">
		<div class="bars"><input type="text" name="username" id="username" placeholder="Username" class="introinput inpdes ProximaNovaRegular" data-validation="alphanumeric" /></div>
        <br />
        <div class="bars"><input type="text" name="status" id="password" placeholder="Set status" class="introinput inpdes ProximaNovaRegular" /></div>
        <br />
        
		<div class="bars"><input type="submit" name="register" id="register" value="LOGIN / REGISTER" class="button inpdes ProximaNovaRegular" /></div>
	</fieldset>
</form></div>
 <div style="text-align: center;color: #555; font-size: 13px;margin: 50px 10px; ">
 	
     By loging in, you agree to our <strong> terms & conditions </strong><br><br> <br><br><br> 
</div>
</div>





</body>
</html>