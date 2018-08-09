<?php
include_once 'config.php';
if(isset($_GET['state'])){
  include 'tourist1.php';
}
$jsondata = json_decode(getData2());
$countplaces=($jsondata->list);
$place=$_GET['q'];
$id=$_GET['id'];
foreach($jsondata->list as $list)
{
  if($list->text == "Bengaluru"){
        $placename = "Bangalore";
    }
    else{
          $placename = $list->text;
      }
  echo "<div class='design1'>";
  echo "<div class='placeimage'><a href='http://localhost/wikilogy/mpdata.php?q=$placename&id=$id' ><img src='" .$list->img. "'/></a></div>";
  echo "<div class='placedata'><div class='bgoverlay'><a href='http://localhost/wikilogy/mpdata.php?q=$placename&id=$id'><h4>".$placename."</h4></a></div><h6>" .$list->desc. "</h6></div>";
  echo "</div>";
}
?>
