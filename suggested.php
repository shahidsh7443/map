<?php
include_once 'config.php';
if(isset($_GET['state'])){
    include 'suggestedplaces.php';
}
else {
    include 'tourist.php';
}
$jsondata = json_decode(getData());
$countplaces=($jsondata->list);
$place=$_GET['q'];
$id=$_GET['id'];
echo "<div class='row splaces'>";
foreach($jsondata->list as $list)
{
  if($list->text == "Bengaluru"){
        $placename = "Bangalore";
    }
    else{
          $placename = $list->text;
      }
  echo "<div class='col-lg-4 col-cs-12'>";
  echo "<div class='design'>";
  echo "<div class='placeimage'><a href='http://localhost/wikilogy/mpdata.php?q=$placename&id=$id' ><img src='" .$list->img. "'/></a></div>";
  echo "<div class='placedata'><div class='bgoverlay'><a href='http://localhost/wikilogy/mpdata.php?q=$placename&id=$id'><h4>".$placename."</h4></a></div><h6>" .$list->desc. "</h6></div>";
  echo "</div>";
  echo "</div>";
}
echo "</div>";
?>
