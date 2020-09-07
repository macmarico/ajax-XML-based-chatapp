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
 


   }

}






     
     $username = $_SESSION["Username"];

    $recivernm = $_POST['recivernm'];
    
      
    
    $statusID = $_POST['statusID'];
   
   $tag = $_POST['tag'];
     
  



if(isset($_POST['message'])){

    
       
        $message = addslashes($_POST['message']);
        $sxe = simplexml_load_file("../../users/$recivernm/posts/files/$statusID/$statusID.xml");
        $movie = $sxe->addChild('messageset');
        $ee = $movie->addChild('username', $username);
        $ee = $movie->addChild('time', time());
        $ee = $movie->addChild('imagelink', "$imagelink");
        $ee = $movie->addChild('message', "$message");
        $sxe->asXML("../../users/$recivernm/posts/files/$statusID/$statusID.xml");



}



/* emoji send start */

if(isset($_POST['emojiname'])){

$recivernm = $_POST['recivernm'] ;
$username = $_SESSION["Username"];
$emojiname = $_POST['emojiname'] ;
$emojilink = "../gif/emoji/$emojiname";
  

    
        $sxe = simplexml_load_file("../clubs/lobby.xml");
        $movie = $sxe->addChild("messageset");
        $ee = $movie->addChild('name', "$username");
        $ee = $movie->addChild('time', time());
        $ee = $movie->addChild('link', "$emojilink");
        $sxe->asXML("../clubs/lobby.xml");
        
        
   
   
}


/* emoji send end */



?>

 


