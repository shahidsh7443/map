
<?php
$q= $_GET["q"];
$suggestedlist;
$fileloc = "asset/suggestedplaces/";
if (file_exists($fileloc.$q)) {
    ob_start();
    $myObj = file_get_contents($fileloc.$q);
}else{
    include('simple_html_dom.php');
    $url = "https://www.google.co.in/complete/search?client=travel_immersive&hl=en-IN&q=".$q;
    //echo $url;
    $content = get_web_page($url);
    $str =  $content['content'];
    $ar =  (explode('mid":"',$str));
    $mid =  (explode('",',$ar[1]));
    $mid =  $mid[0];
    $url = 'https://www.google.co.in/async/decc?async=fs:%5Bnull%2Cnull%2Cnull%2C%5B%5D%2Cnull%2Cnull%2C%22'.urlencode($mid).'%22%5D,tcfs:,dest_mid:'.urlencode($mid).',_id:gws-trips-desktop__cmp-content,_pms:s,_fmt:pc';
    $content =  file_get_contents($url);
    $html = new simple_html_dom();
    $html->load($content);

    $element = $html->find(".gws-trips-desktop__city-card");
    $myObj = new stdClass;
    $myObj->status = "success";
    $myObj->list = [];
    for ($i=0; $i<count($element); $i++ ){
      if ( $element[$i]->find('a')){
        $obj = new stdClass;
        $obj->text  = $element[$i]->find('a h2')[0]->innertext;
        $obj->img  = $element[$i]->find('a img')[0]->src;
        $obj->desc  = $element[$i]->find('a div')[1]->innertext;
        array_push($myObj->list,$obj);
      }
    }


    $cached = fopen($fileloc.$q, 'w');
    $myJSON = json_encode($myObj);
    fwrite($cached, $myJSON);
    fclose($cached);
}

if (isset($_GET["preveiw"])){
  echo "<pre>";
  $myJSON=json_decode($myObj);
  print_r($myJSON);
  echo "</pre>";
}
else{
$suggestedlist = $myObj;
//echo ($suggestedlist);
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
