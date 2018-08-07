<?php
$q= $_GET["q"];
$suggestedlist;
$fileloc = "asset/tourism/";
if (file_exists($fileloc.$q)) {
    ob_start();
    $myObj = file_get_contents($fileloc.$q);
    //echo $myObj;
}
else {
include('simple_html_dom.php');
$q= $_GET["q"];
$q = str_replace('_',' ',$_GET["q"]);
$url = "https://www.google.co.in/complete/search?client=travel_immersive&hl=en-IN&q=".$q;
$str = get_web_page($url);
//print_r($str);
//exit();
$str =  $str['content'];
$ar =  (explode('mid":"',$str));
$mid =  (explode('",',$ar[1]));
$mid =  $mid[0];
$url = 'https://www.google.co.in/travel/things-to-do?&hl=en&gl=in&un=1&dest_src=ts&biw=414&bih=736&dest_mid='.urlencode($mid);
$content =  file_get_contents($url);
$html = new simple_html_dom();
$html->load($content);
$element = $html->find("div div easy-img");
$myObj = new stdClass;
$myObj->status = "success";
$myObj->list = [];
for ($i=0; $i<count($element); $i++ ){
  if ( $element[$i]->find('img')){
    $obj = new stdClass;
    $src = $element[$i]->find('img')[0]->src;
    $datasrc = $element[$i]->find('img')[0]->{'data-src'};
    $obj->img  = $src?$src:$datasrc;
  $elem1 = $element[$i]->parent()->parent();
  $elm = $elem1->find("div")[2]->find("span");
  $obj->desc =  $elm[count($elm)-1]->plaintext;
  $obj->title= $elem1->find("div")[2]->find("div")[0]->plaintext;

    array_push($myObj->list,$obj);
  }
}
$cached = fopen($fileloc.$q, 'w');
$myJSON = json_encode($myObj);
fwrite($cached, $myJSON);
fclose($cached);
}
if (isset($_GET["preview"])){
echo "<pre>";
$myJSON=json_decode($myObj);
print_r($myJSON);
echo "</pre>";
}
else{
  $suggestedlist = $myObj;
}
function getData(){
  global $suggestedlist;
  return $suggestedlist;
}
function get_web_page( $url )
{
//echo $url;
    $user_agent='Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';
    $options = array(
        CURLOPT_CUSTOMREQUEST  =>"GET",        //set request type post or get
        CURLOPT_POST           =>false,        //set to GET
        CURLOPT_USERAGENT      => $user_agent, //set user agent
        CURLOPT_COOKIEFILE     =>"cookie.txt", //set cookie file
        CURLOPT_COOKIEJAR      =>"cookie.txt", //set cookie jar
        CURLOPT_RETURNTRANSFER => true,     // return web page
        CURLOPT_HEADER         => false,    // don't return headers
        CURLOPT_FOLLOWLOCATION => true,     // follow redirects
        CURLOPT_ENCODING       => "",       // handle all encodings
        CURLOPT_AUTOREFERER    => true,     // set referer on redirect
        CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
        CURLOPT_TIMEOUT        => 120,      // timeout on response
        CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
    );

    $ch      = curl_init( $url );

    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);


    curl_setopt_array( $ch, $options );
    $content = curl_exec( $ch );

    $err     = curl_errno( $ch );
    $errmsg  = curl_error( $ch );
    $header  = curl_getinfo( $ch );
    curl_close( $ch );

    $header['errno']   = $err;
    $header['errmsg']  = $errmsg;
    $header['content'] = $content;
    return $header;
}
?>
