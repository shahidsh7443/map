<?php
header('Content-type: application/json');
include_once 'config.php';
if(isset($_POST))
{
  if($_POST['lname']== "" || $_POST['sname']== "" ||$_POST['bnr']== "" ||$_POST['wname']== "" ||$_GET['q']== "" )
  {

  }
  else {
      $lname=$_POST['lname'];
      $sname=$_POST['sname'];
      $flink=$_POST['bnr'];
      $wname=$_POST['wname'];
      $desc=base64_encode($_GET['q']);
      $url="https://maps.googleapis.com/maps/api/geocode/json?&address=".urlencode($lname)."&APPID=AIzaSyBIi0IcN-SFCdy9mQmkSTzxgq_BhX-ibJE";
      $contents = file_get_contents($url);
      $contents1=json_decode($contents);
      $countvalue = count($contents1->results[0]->address_components);
      if($countvalue>2 && $countvalue<=4)
      {
        $placename=$contents1->results[0]->address_components[2]->long_name;
      }
else if($countvalue>4 && $countvalue<6)
{
  $placename=$contents1->results[0]->address_components[2]->long_name;
}
else
{
  $placename=$contents1->results[0]->address_components[0]->long_name;
}
		  $sql=mysqli_query($conn,"insert into mapdata values(0,'$lname','$sname','$desc','$flink','$wname','$placename')");
      $msg1 = "success";
      echo json_encode($msg1);
        }
}
?>
