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
    
        echo "<meta http-equiv='refresh' content='0,whois/online.php' />";
        exit;

     }     





  
    $result = mysqli_query($conn,"SELECT * FROM sessions");
    $num_rows = mysqli_num_rows($result);

    $_SESSION["onlineusers"] = $num_rows;
    

 ?>



<!DOCTYPE html>
<html lang="en">
<head>



  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="theme-color" content="#f43e2e">
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>CHATSPOT - Know what's happning through people</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
   <link href="design.css" rel="stylesheet">
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 
</head>
<body class="ProximaNovaRegular">
  <nav class="white" role="navigation">
    <div class="nav-wrapper container">
      <a id="logo-container" href="#" class="brand-logo" style="font-size:21px;color:#f43e2e"><div style="font-size:21px;color:#f43e2e"><img src="img_424217.svg" width="15px"><span> </span>CHATSPOT</div></div></a>
    </div>
  </nav>

  <div id="index-banner" class="parallax-container">
    <div class="section no-pad-bot">
      <div class="container">
        
        <h3 class="header center text-lighten-2" style="color:#555" >SWEET SOCIAL NETWORK</h3>
       
       <br>
        <div class="row center">
        
        
        
        
        
        
        
        
       <div class="heading">GET IN </div>  <br>
<div class="border-none pcform"><form method="post" action="login.php" name="registerform" id="registerform" class="border-none form">
<fieldset class="border-none">
		<div class="bars"><input type="text" name="username" id="username" placeholder="Username" class="introinput inpdes ProximaNovaRegular" data-validation="alphanumeric" /></div>
       
        <div class="bars"><input type="password" name="password" id="password" placeholder="Password" class="introinput inpdes ProximaNovaRegular" /></div>
        
        <div class="bars"><input type="hidden" name="email" id="email" placeholder="Email" class="introinput inpdes ProximaNovaRegular" /></div>
               
          <div class="bars"> <input type="checkbox" name="remember" <?php if(isset($_COOKIE["member_username"])) { ?> checked <?php } ?> />  
       <label style="color: #555; font-size: 15px;margin: 50px 10px; " for="remember-me">Keep me logged in</label> </div>
        <br />
        
		<div class="bars"><input type="submit" name="register" id="register" value="LOGIN / REGISTER" class="button inpdes ProximaNovaRegular" /></div>
	</fieldset>
</form></div>
        
        
        
        
        
      
         
        </div>
        <br><br>

      </div>
    </div>
  
  </div>


  <div class="container">
    <div class="section">

      <!--   Icon Section   -->
      <div class="row">
        <div class="col s12 m4">
          <div class="icon-block">
            <h2 class="center brown-text"><i class="material-icons" style="color:#555;">question_answer</i></h2>
            <h5 class="center" style="color:#555">Chat with people</h5>

            <p class="light" style="color:#999"> In this website we have created the simplest and effective way of communicating through chat where u can keep or delete all of your conversations any time you want. We have also taken care of unnecessary messages sent by anonymous people to you by deleting all of them when you logout. So that you don't have to worry about mess created by others, your inbox will always be neat and clean.  </p>
          </div> 
        </div>

        <div class="col s12 m4">
          <div class="icon-block">
            <h2 class="center brown-text"><i class="material-icons" style="color:#555;">group</i></h2>
            <h5 class="center" style="color:#555"> Pin your favourite person</h5>

            <p class="light" style="color:#999"> By pinning your favourite person you will make sure that none of your chat with that person gets deleted and you will be able to read the whole converstions with the person you pinned whenever you want.</p>
          </div>
        </div>

        <div class="col s12 m4">
          <div class="icon-block">
            <h2 class="center brown-text"><i class="material-icons" style="color:#555;" >rss_feed</i></h2>
            <h5 class="center" style="color:#555">Share your chatting motive </h5>

            <p class="light" style="color:#999"> Tell people why you are here and let them help you in fulfilling your motive. By writing a suitable motive you will create a zone where people intrested in fulfilling your motive will help you and you can always pin those people to stay in touch with them.  </p>
          </div>
        </div>
      </div>

    </div>
  </div>


  <div class="parallax-container valign-wrapper">
    <div class="section no-pad-bot" style="top:30%;">
      <div class="container">
        <div class="row center"> 
        <div class="row">
        <div style="padding:10px 0px" >
          <img src='../www.svg'width="50px" alt="avatar" style="border-radius: 45px;border:5px solid #333;background:#333">
        </div>
        <div class="container statwidth2" style="color:#fff;"  >
          
    "Recommend me a song"  
      </div>
    </div>
          <div class="container" style="color:#ff6c00;font-weight:bold;height:20" >By Brandi</div>
      </div>
      </div>
    </div>
    <div class="parallax"><img src="background2.png" alt="Unsplashed background img 2"></div>
  </div>

  <div class="container">
    <div class="section">

      <div class="row">
        <div class="col s12 center">
          <h3><i class="mdi-content-send brown-text"></i></h3>
          <h4>It is all about new way </h4>
          <p class="left-align light" >We have provided a wide range of avatars which you will choose for your personality and motive. These both will surely help you to express in creative ways.  </p>
        </div>
      </div>

    </div>
  </div>


  <div class="parallax-container valign-wrapper">
    <div class="section no-pad-bot" style="top:20%">
      <div class="container">
        <div class="row center">
        <div><img src="Screenshot.png" width="30%"></div>
          <h5 class="header col s12 light" >Grow Up With The Simplest Way To Connect With The People</h5>
        </div>
      </div>
    </div>
    <div class="parallax"><img src="background3.png" alt="Unsplashed background img 3"></div>
  </div>

  <footer class="page-footer themecolor" style="background-color:#ff6c00">
    <div class="container">
      <div class="row">
        <div class="col l6 s12">
          <h5 class="white-text">Company Bio</h5>
          <p class="grey-text text-lighten-4">We are a team working on this project like it's our full time job. Any amount would help support and continue development on this project and is greatly appreciated.</p>


        </div>
        <div class="col l3 s12">
          <h5 class="white-text"><a href="mailto:contact@chatspot.in" style=" font-weight: bold;color:#fff">Mail us - Click here </a></h5>
          
        </div>
        <div class="col l3 s12">
          <h5 class="white-text">Share</h5>
          <ul>
            <li><a href="whatsapp://send?text=Visit www.chatspot.in A new way to chat with people!" data-action="share/whatsapp/share" style="color:#fff">Whatsapp</a></li>
            <li><a class="white-text" href="https://www.facebook.com/chatspot.in/">Facebook</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="footer-copyright">
      <div class="container">
      2020 Copyright sweeeters.co
      </div>
    </div>
  </footer>


  <!--  Scripts-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/init.js"></script>
  
  

  </body>
</html>
