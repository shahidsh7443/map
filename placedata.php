<?php
header('Content-type: application/json');
include_once 'config.php';
$place=$_GET['state'];
$sql=mysqli_query($conn,"select description from mapdata where longname='$place'");
$hasdata= mysqli_fetch_row($sql);
if(!$hasdata)
{
  include 'ababeen.php';
  include 'wikibeen.php';
  $wikiname = getWikiName($place);
  $url = "http://en.wikipedia.org/w/api.php?action=query&format=json&prop=extracts&exlimits=max&explaintext&exintro&titles=".$wikiname;
  $pdata=file_get_contents($url);
  $pdata = explode('"extract":"', $pdata);
  $flink=array($arraylist1[0]['url'],$arraylist1[1]['url'],$arraylist1[2]['url']);
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
      $lname=strtolower($encodeddata->results[0]->address_components[0]->long_name);
      $sname=strtolower($encodeddata->results[0]->address_components[0]->short_name);
      //$plc= $encodeddata->results[0]->address_components[1]->long_name;
      $countvalue = count($encodeddata->results[0]->address_components);
      if($countvalue>2 && $countvalue<=4)
      {
        $plc=strtolower($encodeddata->results[0]->address_components[2]->long_name);
      }
else if($countvalue>4 && $countvalue<6)
{
  $plc=strtolower($encodeddata->results[0]->address_components[2]->long_name);
}
else
{
  $plc=strtolower($encodeddata->results[0]->address_components[0]->long_name);
}
  }
  if($place == "Bangalore")
  {
    $lname = strtolower($place);
  }
  elseif ($place == "Mangalore") {
    $lname = strtolower($place);
  }
  else {
$lname = strtolower($place);
  }
  $sql=mysqli_query($conn,"insert into mapdata values(0,'$lname','$sname','$encdata','$imagelinks','$wikiname','$plc')");
  $sql1=mysqli_query($conn,"select description,id,banner from mapdata where longname='$place'");
  $result = mysqli_fetch_array($sql1);
  $descdata = base64_decode(($result['description']));
  $return = new stdClass();
  $return->content = empty($descdata)?"":$descdata;
  $return->banner = $result['banner'];
  echo json_encode($return);
}
else
{
  $sql=mysqli_query($conn,"select description,id,banner from mapdata where longname='$place'");
  $result = mysqli_fetch_array($sql);
  $descdata = base64_decode(($result['description']));
  $return = new stdClass();
  $return->content = empty($descdata)?"":$descdata;
  $return->banner = $result['banner'];
  echo json_encode($return);
}
?>
