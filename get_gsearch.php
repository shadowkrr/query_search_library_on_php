<?php
require_once 'simple_html_dom.php';

header("Access-Control-Allow-Origin: *");

$gq = $_GET["q"];

if ($gq) {
    $url = "https://www.google.com/search?q=".urlencode($gq)."";
    $dom = file_get_html($url);

    $g_cnt=0;
    foreach ($dom->find('h3[class=r]') as $element) {
        $g_result[$g_cnt]["title"] = $element->children[0]->plaintext;
        $g_result[$g_cnt]["href"] = "https://www.google.co.jp".$element->children[0]->href;
        $g_result[$g_cnt]["href"] = str_replace('https://www.google.co.jp/url?q=', '', $g_result[$g_cnt]["href"]);
        $g_cnt++;
    }
    foreach ($dom->find('div[id=resultStats]') as $element) {
        $pp = explode(" ",$element->plaintext);
    }
    $g_result[0]["max"] = $g_cnt;
    $g_result[0]["result"] = $pp[1];
}
echo json_encode($g_result);
return json_encode($g_result);

?>