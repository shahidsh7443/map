<?php
header('Access-Control-Allow-Origin: *');
header('content-type: application/json; charset=utf-8');
if (!file_exists('cache-image')) {
    mkdir('cache-image', 0777, true);
}
$_GET["state"] = isset($_GET["state"])? strtolower($_GET["state"]):"";
$count = isset($_GET["count"])? $_GET["count"]:"100";

if(trim ($_GET["state"])==""){
		echo '{"error": "search string can not be empty."}';
		return;
}
$file = $_GET["state"];
$cachefile = 'cache-image/'.$file.'.html';
$cachefile_search = 'cache-image-search/'.$file.'.html';

$cachetime = 18000000000;

// Serve from the cache if it is younger than $cachetime
if (file_exists($cachefile) && time() - $cachetime < filemtime($cachefile)) {
		ob_start();
		include($cachefile);
		$myvar = ob_get_contents();
		global $count;
		ob_end_clean();
		$jArr = json_decode($myvar, true);
 		$arraylist=array();

		for ($i=0; ($i<sizeof($jArr) && $i<$count); $i++){
          array_push($arraylist,$jArr[$i]);
		}

    if(isset($_GET['preview']))
    {
      echo "<pre>";
print_r($arraylist);
echo "</pre>";
}else{
  //echo json_encode( $arraylist );
}
}
ob_start(); // Start the output buffer


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

if(strlen($_GET["state"])>=70){
echo '{"error":"max search string  length should be 70 character ."}';
return;

}
$url = "https://www.google.co.in/search?q=".$_GET["state"]." Tourism&num=100&safe=off&espv=2&source=lnms&tbm=isch";

$url =str_replace(" ","+", $url);

$content = get_web_page( $url )["content"];
$content1 = explode("{",$content);
//echo $content;
  $arraylist=array();
for ($i=0; $i< sizeof($content1); $i++){
    if (strpos($content1[$i], '}') !== false){
        $content2 =  "{".explode("}",$content1[$i])[0]."}" ;
        $jArr = json_decode($content2, true);
        if(isset($jArr["tu"])){
            $imgobj=array();
            $imgobj["imageId"] = $jArr["id"];
            $imgobj["visibleUrl"] = $jArr["isu"];
            $imgobj["height"] = $jArr["oh"];
            $imgobj["width"] = $jArr["ow"];
            $imgobj["url"] = $jArr["ou"];
            $imgobj["content"] = $jArr["pt"];
            $imgobj["originalContextUrl"] = $jArr["ru"];
            $imgobj["title"] = $jArr["s"];
            $imgobj["tbWidth"] = $jArr["tw"];
            $imgobj["tbHeight"] = $jArr["th"];
            $imgobj["tbUrl"] = $jArr["tu"];

          array_push($arraylist,$imgobj);
        }
    }
}

    if (count($arraylist)>0){


        $alist=array();

        for ($i=0; ($i<sizeof($arraylist) && $i<$count); $i++){
          array_push($alist,$arraylist[$i]);
        }


        echo json_encode( $alist );

				$cached = fopen($cachefile, 'w');
				fwrite($cached, json_encode($arraylist));
				fclose($cached);

				ob_end_flush(); // Send the output to the browser

    }else{
        echo "{because of server load service is down.}";
    }

 ?>
