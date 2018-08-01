<?php
include_once 'config.php';
$place=$_GET['state'];
$flink="image of xyz";
$sql=mysqli_query($conn,"select description from mapdata where longname='$place'");
$hasdata= mysqli_fetch_row($sql);
if(!$hasdata)
{
  $url = "http://en.wikipedia.org/w/api.php?action=parse&format=json&prop=text&section=0&callback=?&page=".$place;
  $pdata=file_get_contents($url);
  $tempdata= $pdata;
  $encdata = base64_encode($pdata);
  $fileloc = "asset/geolocation/";
  if (file_exists($fileloc.$place)) {
      ob_start();
      $contents = file_get_contents($fileloc.$place);
      $encodeddata=json_decode($contents);
      $lname=$encodeddata->results[0]->address_components[0]->long_name;
      $sname=$encodeddata->results[0]->address_components[0]->short_name;
      $plc= $encodeddata->results[0]->address_components[1]->long_name;
      //print_r (count($encodeddata->results[0]->address_components));
     //exit();
  }
  $sql=mysqli_query($conn,"insert into mapdata values(0,'$lname','$sname','$encdata','$flink','$place','$plc')");
}
else
{
  $sql=mysqli_query($conn,"select description,id from mapdata where wikiname='$place'");
  $result = mysqli_fetch_array($sql);
}
$sql=mysqli_query($conn,"select description,id from mapdata where wikiname='$place'");
$result = mysqli_fetch_array($sql);
$descdata = base64_decode($result['description']);
echo json_encode($descdata);
?>
