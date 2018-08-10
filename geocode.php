<?php
$tvar=$_GET['q'];
if($tvar == "jammu and kashmir")
{
  $city = "srinagar";
}
else {
  $city= $_GET['q'];
}
$fileloc = "asset/geolocation/";
if (file_exists($fileloc.$city)) {
    ob_start();
    $contents = file_get_contents($fileloc.$city);
}else{
    $url="https://maps.googleapis.com/maps/api/geocode/json?&address=".urlencode($city)."&key=AIzaSyAzTjk2HWJgAbl9XF2WFQNI1fMq-Jy2PuA";
    $contents = file_get_contents($url);
    $contents1=json_decode($contents);
        $cached = fopen($fileloc.$city, 'w');
        fwrite($cached, $contents);
        fclose($cached);
}
$clima=json_decode($contents);
$lat=$clima->results[0]->geometry->location->lat;
$lng=$clima->results[0]->geometry->location->lng;
$addr=$clima->results[0]->formatted_address;

if(strpos($_SERVER['REQUEST_URI'],"geocode.php")!=0){
  echo "<pre>";
  print_r( $clima);
  echo "</pre>";
}


?>
