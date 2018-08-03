<?php
include_once 'config.php';
$sql =mysqli_query($conn,"select * from mapdata");
echo "<div class='text-center placenames'>";
while($row = mysqli_fetch_array($sql))
{
echo "<a class='text-center' href='adminform.php?id=".$row['id']."'>".$row['longname']."</a> | ";
}
echo "</div>";
 ?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
	<title>Add Data</title>
	<link rel="stylesheet" type="text/css" href="./map-style.css" />
	<link rel="stylesheet" href="./bootstrap.min.css">
		<script src="./jquery.min.js" type="text/javascript"></script>
 <script src="./bootstrap.min.js"></script>
	<script src="./map-config.js" type="text/javascript"></script>
	<script src="./pin-config.js" type="text/javascript"></script>
	<script src="./map-interact.js" type="text/javascript"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="./css/froala_editor.css">
  <link rel="stylesheet" href="./css/froala_style.css">
  <link rel="stylesheet" href="./css/plugins/code_view.css">
  <link rel="stylesheet" href="./css/plugins/image_manager.css">
  <link rel="stylesheet" href="./css/plugins/image.css">
  <link rel="stylesheet" href="./css/plugins/table.css">
  <link rel="stylesheet" href="./css/plugins/video.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css">

</head>
<script type="text/javascript">
$( document ).ready(function() {
$(".mform").submit(function(e){
e.preventDefault();
var form_data = new FormData(this);
var descdata = $('.fr-view').text();
//$(this).serialize(),
$.ajax({
							 url: 'dbpush.php?q='+descdata,
							 type: 'post',
							 dataType : 'json',
													contentType: false,
													cache: false,
													processData:false,
							 data: form_data,
							 success: function( data ){
                 $("#sbt").closest("div").append(" <span class='error'>Data submitted successfully</span>");
                 $('.error').css({'display':'inline-block'});
                $('.mform')[0].reset();
                var myvar = setTimeout(hidemessage, 3000);
                  function hidemessage()
                  {
                    $('.error').css({'display':'none'});
                    clearInterval(myvar);
                  }

							},
							 error: function( aa ){

                 $("#sbt").closest("div").append(" <span class='errordanger'>Please fill all the fields</span>");
                 $('.errordanger').css({'display':'inline-block'});
                 myvar = setInterval(hidemessage, 3000);
                  function hidemessage()
                  {
                    $('.errordanger').css({'display':'none'});
                      clearInterval(myvar);

                  }
							 }
					 });


});
});
</script>
<body style="background:url('/wikilogy/wp-content/uploads/2017/09/bodybg.jpg');">
	<div class="container-fluid">
    <div id="gohome">
<a href="index.php">HOME</a>
    </div>
<div class="fdata">

<?php
$desc = "";
	if(isset($_GET['id'])){
		$sql =mysqli_query($conn,"select * from mapdata where id=".$_GET['id']);
	 $row1  = mysqli_fetch_array($sql);
	echo "<h2 class='text-center linkname'>" .$row1["longname"]."</h2>";
	$desc =  base64_decode($row1["description"]);
}

	?>


<form class="mform" method="post" enctype="multipart/form-data">
	<h3>Enter Details</h3>
  <div class="row " id="sep">
    <div class="col-lg-5 col-xs-5">
  <hr class="hr1"></div><div class="col-lg-2 col-xs-2"><div class="text-center stars"><span class="s-colors1"><i class="fa fa-star"></i></span><span class="s-colors1"><i class="fa fa-star"></i></span><span class="s-colors1"><i class="fa fa-star"></i></span><span class="s-color"><i class="fa fa-star"></i></span><span class="s-color1"><i class="fa fa-star"></i></span><span class="s-color2">
    <i class="fa fa-star"></i></span><span class="s-colors1"><i class="fa fa-star"></i></span><span class="s-colors1"><i class="fa fa-star"></i></span><span class="s-colors1"><i class="fa fa-star"></i></span></div></div><div class="col-lg-5 col-xs-5"><hr class="hr1"></div></div>
	<div class="row">
<div class="col-lg-4 col-xs-12">
	  <input type="text" id="lname" name="lname" placeholder="Long Name">
</div>
<div class="col-lg-4 col-xs-12">
	  <input type="text" id="sname" name="sname" placeholder="Short Name">
</div>
<div class="col-lg-4 col-xs-12">
		<input type="text" id="wname" name="wname" placeholder="Wiki Name">
</div>
	</div>
	<div class="row">
<div class="col-lg-12 col-xs-12">
		<textarea  id="bnr" name="bnr" rows="5" col="100" placeholder="Banner Image URL Seperated by ' , ' (Eg : xyz.jpg , asd.png...)"></textarea>
</div>
	</div>
	<div class="row">
<div class="col-lg-12 col-xs-12 rtext">
		<textarea id='edit' name="dsc" placeholder="Description" cols="100" rows="10">

			<?php
			echo $desc;
			?>
		</textarea></textarea>
</div>
</div>
<div class="row">
<div class="col-lg-12 col-xs-12 sbutton">
	<button type="submit" value="SUBMIT" id="sbt" name="submit" >SUBMIT</button>
</div>
</form>

</div>
</div>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js"></script>
  <script type="text/javascript" src="./js/froala_editor.min.js"></script>
  <script type="text/javascript" src="./js/plugins/align.min.js"></script>
  <script type="text/javascript" src="./js/plugins/code_beautifier.min.js"></script>
  <script type="text/javascript" src="./js/plugins/code_view.min.js"></script>
  <script type="text/javascript" src="./js/plugins/draggable.min.js"></script>
  <script type="text/javascript" src="./js/plugins/image.min.js"></script>
  <script type="text/javascript" src="./js/plugins/image_manager.min.js"></script>
  <script type="text/javascript" src="./js/plugins/link.min.js"></script>
  <script type="text/javascript" src="./js/plugins/lists.min.js"></script>
  <script type="text/javascript" src="./js/plugins/paragraph_format.min.js"></script>
  <script type="text/javascript" src="./js/plugins/paragraph_style.min.js"></script>
  <script type="text/javascript" src="./js/plugins/table.min.js"></script>
  <script type="text/javascript" src="./js/plugins/video.min.js"></script>
  <script type="text/javascript" src="./js/plugins/url.min.js"></script>
  <script type="text/javascript" src="./js/plugins/entities.min.js"></script>

  <script>
      $(function(){
        $('#edit')
          .on('froalaEditor.initialized', function (e, editor) {
            $('#edit').parents('form').on('submit', function () {
              console.log($('#edit').val());
              return false;
            })
          })
          .froalaEditor({enter: $.FroalaEditor.ENTER_P, placeholderText: null})
      });
  </script>
</body>
</html>
