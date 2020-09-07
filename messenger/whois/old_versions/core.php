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
      

    if ((time() - $er) > 900 or ($er - time()) > 900){
    
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
     $recivernm = $_POST['recivernm'];
     
     
     
     
     if(!empty($_POST['recivernm'])){


$dom = new DOMDocument();
$dom->load("../users/$username/notification/notification.xml");
$xpath = new DOMXPath($dom);

foreach ($xpath->query("/apps/notifset[username= '$recivernm']") as $node) {
  $node->parentNode->removeChild($node);
}

$dom->save("../users/$username/notification/notification.xml");


}     

     
    
     
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="google" content="notranslate">
<link rel="shortcut icon" href="favicon.png">
<title>Home</title>
<link href="../design.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="../lib/css/emoji.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   
   
   <script>
function resetForm() {
    document.getElementById("myForm").reset();
}
</script>
    
</head>
<body class=" body-define ProximaNovaRegular" onload="fetch()" >
<div id="anchor"></div>

<div class="adj" style=" height: 53px; position: fixed; width: 100%; top: 0px; "> <a style= "color : white ;" href=" inbox.php">back</a>

    <div id="usn" class="gtc "><a href="setting.php">
    <div class="row">
        <div class="b1" >
          <img src=
          
            <?php
          
        
          
          
             $filename = "../users/$recivernm/notification/profilepic.svg";

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
echo $recivernm ; 
?> 
             
     
        </div>
    </div> </a></div>

    <div class=" notifs"><a href="setting.php">
      </a></div>
    </div>
    



    



<br><br><br><br>

<div class="messeging cmsgin" id="demo">

</div><br><br>

<div class="set">
  <a href="#anchor"><div style="font-size: 15px; color: #999">GO TO TOP</div></a>
</div>








  <div class="msgbar" style = " position: fixed; width: 100%; bottom: 0px; ">
    <div class="msgtab">
      <form method="get" action="parts/chatcore.php" id="formpost" name="formpost" class="formpost">
      <div class="msgcomp">
        <input style="width:80%; border-radius: 25px;" type="text" name="message"  placeholder="Type Message" class="width ProximaNovaRegular inpdes msgbut" autocomplete="off" required />
         <input type="hidden" name="recivernm" value="<?php echo $recivernm ; ?>">
        <div class="msgcomp" style=" width: 18%; display:inline-block;">
        
            <input style=" height: 40px; border-radius: 25px;" type="submit" name="login" value="SEND" class="ProximaNovaRegularBold indes sendbut csndbut  " />
          </div>
        </form>
        
        
        
       

  </div>
  
  </div>






<script>



function convert(ts)
{ 

 // This function computes the delta between the
    // provided timestamp and the current time, then test
    // the delta for predefined ranges.

    var d=new Date();  // Gets the current time
    var nowTs = Math.floor(d.getTime()/1000); // getTime() returns milliseconds, and we need seconds, hence the Math.floor and division by 1000
    var seconds = nowTs-ts;

    // year
    if (seconds > 365*24*3600) {
       return Math.floor(seconds/(365*24*3600)) + "y";
    }
    // a day
    if (seconds > 24*3600) {
       return Math.floor(seconds/(24*3600)) + "d";
    }

    if (seconds > 3600) {
       return Math.floor(seconds/3600) + "h";
    }
    if (seconds > 1800) {
       return "30m";
    }
    if (seconds > 60) {
       return Math.floor(seconds/60) + "m";
    }
     if (seconds < 60) {
       return  "sec";
    }

}



function fetch() {
 
		setTimeout( function() {
	 	loadDoc();
		fetch();
	}, 1000);
 
}



function loadDoc() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      myFunction(this);
    }
  };
  xhttp.open("GET", "../users/<?php echo $username;?>/<?php echo $recivernm;?>.xml", false);
  xhttp.setRequestHeader('Cache-Control', 'no-cache');
  xhttp.send();
}
 
 
$(function() {
    $("#formpost").submit(function(event) {
        event.preventDefault();

        var form = $(this);
        var url = form.attr('action');

        $.ajax({
            cache : false,
            type: "POST",
            url: url,
            data: form.serialize() // serializes the form's elements.
        }).done(function(data) {
            var msg = $(data).find('#msg').text();

           
        });
    });
}); 

  $(document).on("submit", "#emojiform", function(event)
{
    event.preventDefault();        
    $.ajax({
    
        cache: false,
        url: $(this).attr("action"),
        type: $(this).attr("method"),
        dataType: "JSON",
        data: new FormData(this),
        processData: false,
        contentType: false,
        success: function (data, status)
        {

        },
        error: function (xhr, desc, err)
        {


        }
    });        
});function myFunction(xml) {
  var rowsArray =[]
  var i ;
  var xmlDoc = xml.responseXML;
  var table="";
  var x = xmlDoc.getElementsByTagName("messageset");
  var getMessage = function(messageSetNode) {
  var wrapInDiv = function(msg) {
    return   msg ;
  }
  var messageNode = messageSetNode.getElementsByTagName("message")[0]; 
  if(messageNode) {
    return wrapInDiv(messageNode.childNodes[0].nodeValue);
  }
 
  return "<input type=\"image\" src=\""+wrapInDiv(messageSetNode.getElementsByTagName("link")[0].childNodes[0].nodeValue)+"\" width=\"30%\" class=\"emoji\"  alt=\"Submit\" >";
}

  
  for (i = 0; i < x.length; i++) {
  var name = x[i].getElementsByTagName("username")[0].childNodes[0].nodeValue;
  var time = x[i].getElementsByTagName("time")[0].childNodes[0].nodeValue;
    var row = "<div class=\"msgtime b1\">"+convert(time)+"</div><div class=\"row\"><div class=\"b1\" ><img src=\"" + "../users/"    
    + name +"/notification/profilepic.svg" + "\" width=\"30px\" height=\"30x\" alt=\"avatar\" style=\"border-radius: 45px;\" class=\"image\" ></div><div class=\"b2 msginname\" >" +
    name +
    "</div> <div class=\"msgoriginal\">" +
    getMessage(x[i]) + "</div></div>";
    rowsArray.push(row)
  }
  table += rowsArray.join('');
  document.getElementById("demo").innerHTML = table;
  
  scrollingElement = (document.scrollingElement || document.body)

   scrollingElement.scrollTop = scrollingElement.scrollHeight;

 
}

</script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-JAW99MJVpJBGcbzEuXk4Az05s/XyDdBomFqNlM3ic+I=" crossorigin="anonymous"></script>
<!-- ** Don't forget to Add jQuery here ** -->
</body>
</html>

