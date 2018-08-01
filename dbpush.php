<?php
include_once 'config.php';
if(isset($_POST))
{
      $lname=$_POST['lname'];
      $sname=$_POST['sname'];
      $flink=$_POST['bnr'];
      $wname=$_POST['wname'];
      $desc=base64_encode($_GET['q']);
      $state=$_POST['ist'];
		  $sql=mysqli_query($conn,"insert into mapdata values(0,'$lname','$sname','$desc','$flink','$wname','$state')");
      if ($sql) {
                  echo "New record created successfully";
                }
                else {
                   echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                 }
}
?>
