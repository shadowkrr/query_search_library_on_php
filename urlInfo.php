<?php
require('simple_html_dom.php');

$url = $_GET['url'];
if (!$url) exit;

header("Access-Control-Allow-Origin: *");
$url = urldecode($url);
$html = file_get_html($url);
$arrData['url'] =  $url;
$arrData['title'] =  $html->find('title',0)->innertext;
$arrData['description'] = $html->find('meta[name=description]',0)->attr['content'];

echo json_encode($arrData);
return json_encode($arrData);
?>