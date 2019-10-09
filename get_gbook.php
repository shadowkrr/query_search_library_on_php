<?php
require_once 'simple_html_dom.php';

$gq = $_GET["q"];
if ($gq) {
    $url = "https://www.google.co.jp/search?q=".urlencode($gq)."&tbm=bks";

    $dom = file_get_html($url);

    $g_cnt=0;
    foreach ($dom->find('h3[class=r]') as $element) {
        $text = $element->children[0]->plaintext;
        $g_result[$g_cnt]["title"] = $text;
        $g_result[$g_cnt]["href"] = $element->children[0]->href;
        $g_cnt++;
    }
    foreach ($dom->find('div[id=resultStats]') as $element) {
        $result_text = $element->plaintext;
        $pp = explode(" ",$result_text);
        if (is_numeric($pp[0])) {
            $result_text = $pp[0];
        } else {
            $result_text = $pp[1];
        }
    }
    $g_result[0]["max"] = $g_cnt;
    $g_result[0]["result"] = $result_text;
}
header( 'Content-Type: application/json; charset=UTF-8' );
echo json_encode($g_result);

?>