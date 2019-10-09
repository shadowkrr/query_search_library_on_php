<?php
header("Access-Control-Allow-Origin: *");
$url = "http://api.openweathermap.org/data/2.5/weather?q=Tokyo,jp";
$json = file_get_contents($url);
$json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');

$arr = json_decode($json,true);
if ($arr === NULL) {
    exit;
} else {
    // 天気アイコンのファイル名の先頭2文字を取得
    $weatherIcon = substr($arr['weather'][0]['icon'], 0, 2);

    // 天気アイコンのファイル名が取得できない場合は、取得不可を示す「00」をセット
    if (!$weatherIcon) {
        $weatherIcon = '00';
    }

    // 天気アイコンのファイル名から天気名に変換するためのリスト
    $convList = array(
        '01'    => '晴れ',
        '02'    => '晴れ',
        '03'    => '曇り',
        '04'    => '曇り',
        '09'    => '雨',
        '10'    => '雨',
        '11'    => '雷雨',
        '13'    => '雪',
        '50'    => '霧',
        '00'    => '取得不可',
    );

    // 天気アイコンのファイル名を天気名に変換
    $weatherName = $convList[$weatherIcon];
    $arr['weatherName'] = $weatherName;

    $arr = json_encode($arr);
    echo $arr;
}