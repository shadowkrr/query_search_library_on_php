<?php
require_once 'simple_html_dom.php';
$gq = $_GET["q"];
if ($gq) {
    $url = "https://www.google.co.jp/search?q=".urlencode($gq)."&tbm=isch&h=jp";
    $dom = file_get_html($url);

    $g_cnt=0;
    foreach ($dom->find('h3[class=r]') as $element) {
        $g_result[$g_cnt]["title"] = $element->children[0]->plaintext;
        $g_result[$g_cnt]["href"] = "https://www.google.co.jp".$element->children[0]->href;
        $g_cnt++;
    }
    foreach ($dom->find('div[id=resultStats]') as $element) {
        $pp = explode(" ",$element->plaintext);
    }
    $img_cnt = 0;
    foreach ($dom->find('img') as $element) {
        $g_result[$img_cnt]["src"] = $element->src;
        $img_cnt++;
        if ($img_cnt>=5) break;
    }
    $g_result[0]["max"] = $g_cnt;
    $g_result[0]["result"] = $pp[1];

    $url_yahoo = "http://image.search.yahoo.co.jp/search?p=".urlencode($gq);
    $dom = file_get_html($url_yahoo);
    $yahoo_cnt = 0;
    foreach ($dom->find('a[target=imagewin]') as $element) {
        $g_result[$yahoo_cnt]["srcY"] = $element->href;
        $yahoo_cnt++;
        if ($yahoo_cnt>=5) break;
    }
}
header( 'Content-Type: application/json; charset=UTF-8' );
echo json_encode($g_result);

?>