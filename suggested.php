
<?php
include_once 'config.php';
include 'tourist.php';
 $jsondata = json_decode(getData());
$countplaces=($jsondata->list);
//include 'suggestedplaces.php?q=karnataka';
$place=$_GET['q'];
$id=$_GET['id'];
foreach($jsondata->list as $list)
{
  if($list->title == "Bengaluru"){
        $placename = "Bangalore";
    }
    else {
      $placename = $list->title;
    }
  echo "<div class='design'>";
  echo "<div class='placeimage'><a href='http://localhost/wikilogy/mpdata.php?q=$placename&id=$id' ><img src='" .$list->img. "'/></a></div>";
  echo "<div class='placedata'><div class='bgoverlay'><a href='http://localhost/wikilogy/mpdata.php?q=$placename&id=$id'><h4>".$placename."</h4></a></div><p>" .$list->desc. "</p></div>";
  echo "</div>";
}
?>
