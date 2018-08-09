<?php
if (!file_exists('bingcached')) {
    mkdir('bingcached', 0777, true);
}
$_GET["q"] = isset($_GET["q"])? strtolower($_GET["q"]):"";
$arraylist=array();


if(trim ($_GET["q"])==""){
  echo json_encode( $arraylist );
return;
}
ob_start();

header('content-type: application/json; charset=utf-8');
header("access-control-allow-origin: *");

function get_web_page( $url )
{
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

$cachetime = 18000000000;
$cachefile = 'bingcached/'.$_GET["q"].'.html';
  if (file_exists($cachefile) && time() - $cachetime < filemtime($cachefile)) {
        ob_start();
        include($cachefile);
        $myvar = ob_get_contents();
        exit;
      }


$arraylist=array();
$preview = isset($_GET["preview"])?$_GET["preview"]:"";

$url = "http://api.bing.com/osjson.aspx?query=".urlencode($_GET["q"]);
$content = (get_web_page( $url )["content"]);
$content1 = explode(']]',$content)[0];
$content2 = explode(',[',$content1)[1];
$content1 = explode(",",$content2);
for ($i=0; $i< sizeof($content1); $i++){
  $obj=array();
  $t= str_replace('"','', $content1[$i]);
  if($t){
    $obj["title"]  = $t;
    array_push($arraylist,$obj);
  }
}

if($preview){
   echo "<pre>";
   print_r($arraylist);
   echo "</pre>";
}else{
      if (count($arraylist)>0){
        $cached = fopen($cachefile, 'w');
        fwrite($cached, json_encode($arraylist));
        fclose($cached);
      }
     echo json_encode( $arraylist );

}

 ?>
