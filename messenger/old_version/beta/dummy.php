<?php
function convert($seconds){
$string = "";

$days = intval(intval($seconds) / (3600*24));
$hours = (intval($seconds) / 3600) % 24;
$minutes = (intval($seconds) / 60) % 60;
$seconds = (intval($seconds)) % 60;

if($days> 0){
    $string .= "$days days ";
}else{
if($hours > 0){
    $string .= "$hours hours ";
          }else{
if($minutes > 0){
    $string .= "$minutes minutes ";
         }else{
if ($seconds > 0){
    $string .= "$seconds seconds";
              }
           }
        }
     }
return $string;


}

echo convert(3744000);
?>