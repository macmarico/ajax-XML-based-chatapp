<?php
include "base.php";

$result = mysqli_query($conn,"SELECT * FROM users");
    $num_rows = mysqli_num_rows($result);

   
    
    echo  $num_rows; ; 
    
    
    ?>