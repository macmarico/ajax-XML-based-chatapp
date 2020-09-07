<?php




$dir = "../users";

// Open a directory, and read its contents
if (is_dir($dir)){
  if ($dh = opendir($dir)){
    while (($file = readdir($dh)) !== false){
      $filename = $file ;
      $withoutext = basename($filename, '.xml');

     
     
    
      if("$filename" != '.'   )
      {
      

$directory = "../users/$filename/";

$y = glob($directory . '*.xml');
$x = glob($directory . '*');



if ( $y !== false )
{
    $filecount = count( $x );
    $filec = count( $y );
    
    $dj = $filecount - $filec ;
     if($dj == '3')
     {
      echo  $filename;
      echo $filecount - $filec ?><br /><?php;
     }
    
    
     
}
else
{
    echo 0;
}
}
 }} }    

?>