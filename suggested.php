<?php
include_once 'config.php';
$place=$_GET['q'];
$searchdata=mysqli_query($conn,"select longname,banner,description from mapdata where place='$place'");
$numrowsfetched=mysqli_num_rows($searchdata);
while($row = mysqli_fetch_assoc($searchdata))
{
$mainimage= explode(',' , $row['banner'] );
$minitext = base64_decode(substr($row['description'], 0, 75));
  echo "<div class='design'>";
  echo "<div class='placeimage'><img src='" .$mainimage[0]. "'/></div>";
  echo "<div class='placedata'><h4>".$row['longname']."</h4><p>" .$minitext. "....</p></div>";
  echo "</div>";
}
?>
