<?php
require_once 'simple_html_dom.php';
$gq = $_GET["q"];
if ($gq) {
    $url = "http://ja.wikipedia.org/wiki/".urlencode($gq);
    $dom = file_get_html($url);
    if (!$dom) {
        header( 'Content-Type: application/json; charset=UTF-8' );
        echo json_encode(null);exit;
    }
    $datas = $dom->find("#mw-content-text");
    for ($i=0;$i<count($datas[0]->children);$i++) {
        if ($datas[0]->children[$i]->tag == "p") {
            $w_result["main"] .= $datas[0]->children[$i]->plaintext."<br>";
        }
    }
    $detail = $dom->find(".infobox");
    $w_result["detail"] = $detail[0]->plaintext;
}
header( 'Content-Type: application/json; charset=UTF-8' );
echo json_encode($w_result);

?>