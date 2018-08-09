<?php
function get_web_page1( $url )
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

function getWikiName($name){

$plcname = explode(" ",$name);
if(count($plcname)>1)
{
$url = "https://www.google.co.in/search?q=Wiki".$name."&num=10&safe=off&espv=2&source=lnms&tbm=isch";

$url =str_replace(" ","+", $url);

$content = get_web_page1( $url )["content"];
$content1 = explode("{",$content);
  $arraylist=array();
for ($i=0; $i<sizeof($content1);$i++){
    if (strpos($content1[$i], '}') !== false){
        $content2 =  "{".explode("}",$content1[$i])[0]."}" ;
        $jArr = json_decode($content2, true);
        if(isset($jArr["tu"])){
            $imgobj=array();

            $imgobj["originalContextUrl"] = $jArr["ru"];

          array_push($arraylist,$imgobj);
        }
    }
}
$wname = explode("/", $arraylist[0]['originalContextUrl']);
  return  $wname[count($wname)-1];
}
else {
return  ucfirst($name);
}

  }

 ?>
