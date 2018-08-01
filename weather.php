
<?php
include('geocode.php');
echo "<div id='lat' style='display:none;'>" . $lat ."</div>";
echo "<div id='lon' style='display:none;'>" . $lng ."</div>";
echo "<div id='addr' style='display:none;'>" . $addr ."</div>";
echo "<div id='tocolor' style='display:none;'>" . $_GET['id'] ."</div>";
?>
<script>
$(document).ready(function(){
  var address=$('#addr').text();
  var lat=$('#lat').text();
  var lon=$('#lon').text();
//var googlemap_url ="https://maps.googleapis.com/maps/api/geocode/json?&address=lalbagh";
//var weather_url= "http://api.openweathermap.org/data/2.5/weather?lat="+lat+"&lon="+lon+"&units=metric&cnt=7&lang=en&APPID=de78f33e2d51bdf4c7468874ed89ca9f";
getTemp(lat,lon);
function getTemp(lat,lon){
$.ajax({
        type  : "GET",
        url: "http://api.openweathermap.org/data/2.5/weather?lat="+lat+"&lon="+lon+"&units=metric&cnt=7&lang=en&APPID=de78f33e2d51bdf4c7468874ed89ca9f",
        success: function (data, textStatus, jqXHR) {
          console.log(data);
          if(data &&  data.main && data.main.temp){
          var imgsource="http://openweathermap.org/img/w/"+data.weather[0].icon+".png";
          var roundtemp = data.main.temp;
          var temp = roundtemp.toFixed();
          var tocolor = "map_"+$('#tocolor').text();
          $('#'+tocolor).css({'fill':'red'});
        //var googlemap_url ="https://m
        //  $('#weather1').html(data.main.temp);
          $('.date').text(address);
          $('#stitle .title').text(address);
          $('.temp').text(temp+String.fromCharCode(176));
          $('.temp').append('<span>c</span>');
          $('.icon img').attr('src',imgsource);
          }
        },
        error: function (errorMessage) {
        }
    });
  }
  });
</script>
<!--<div id="weather1"></div>-->
