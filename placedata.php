<?php
header('Content-type: application/json');
include_once 'config.php';
$place=$_GET['state'];
$sql=mysqli_query($conn,"select description from mapdata where wikiname='$place'");
$hasdata= mysqli_fetch_row($sql);
if(!$hasdata)
{
  include 'ababeen.php';
  $url = "http://en.wikipedia.org/w/api.php?action=query&format=json&prop=extracts&exlimits=max&explaintext&exintro&titles=".$place;
  $pdata=file_get_contents($url);
  $pdata = explode('"extract":"', $pdata);
  $flink=array($arraylist[0]['url'],$arraylist[1]['url'],$arraylist[2]['url']);
  $imagelinks = implode(',',$flink);
if (count($pdata)>0){
  $pdata = $pdata[1];
  $pdata = str_replace('"}}}}',' ',$pdata);
}
  $encdata = base64_encode($pdata);
  $fileloc = "asset/geolocation/";
  if (file_exists($fileloc.$place)) {
      ob_start();
      $contents = file_get_contents($fileloc.$place);
      $encodeddata=json_decode($contents);
      $lname=$encodeddata->results[0]->address_components[0]->long_name;
      $sname=$encodeddata->results[0]->address_components[0]->short_name;
      //$plc= $encodeddata->results[0]->address_components[1]->long_name;
      $countvalue = count($encodeddata->results[0]->address_components);
      if($countvalue>2 && $countvalue<=4)
      {
        $plc=$encodeddata->results[0]->address_components[2]->long_name;
      }
else if($countvalue>4 && $countvalue<6)
{
  $plc=$encodeddata->results[0]->address_components[2]->long_name;
}
else
{
  $plc=$encodeddata->results[0]->address_components[0]->long_name;
}
  }

  $sql=mysqli_query($conn,"insert into mapdata values(0,'$lname','$sname','$encdata','$imagelinks','$place','$plc')");
}
else
{
  $sql=mysqli_query($conn,"select description,id from mapdata where wikiname='$place'");
  $result = mysqli_fetch_array($sql);
}
$sql=mysqli_query($conn,"select description,id from mapdata where wikiname='$place'");
$result = mysqli_fetch_array($sql);
$descdata = base64_decode(($result['description']));
echo json_encode($descdata);
?>
