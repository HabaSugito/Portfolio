<?php
if($column1 != $column2 && $column1){

//統計計算用ファイル

/* 分母がある場合とない場合の変数の統合と配列作成 */
$muniList = [];
$calcArray1 = [];
$calcArray2 = [];
$calculated = [];
for ($i=1;$i<count($result);$i++){
    $calcArray1[]= (float)$result[$i]["$column1"];
}
if($column1 && $column2){
    for ($i=1;$i<count($result);$i++){
        $calcArray2[]= (float)$result[$i]["$column2"];
    }
    for ($i=0;$i<count($calcArray1);$i++){
        $calculated[] =number_format((float)$calcArray1[$i]/(float)$calcArray2[$i],4);
    }
    }elseif($column1 && !$column2){
        $calculated = $calcArray1;
    }
for ($i=1;$i<count($result);$i++){
    $muniList[]= [$result[$i]['muniName'],$calculated[$i-1]];
}

/* 合計・平均・偏差・分散・標準偏差・偏差値の計算式 */
$sum = array_sum($calculated); //平均
$average = $sum /count($calculated); //平均
$covarience =0.0;
$deviation =[];
for ($i=0 ;$i<count($calculated) ;$i++){ 
    $deviation[] =$calculated[$i] - $average; //偏差
    $covarience += ($calculated[$i] - $average) ** 2; 
}
$covarience = $covarience / count($calculated); //分散
$sd = sqrt(abs($covarience)); //標準偏差
$stDeviation = [];
for ($i=0 ;$i<count($deviation) ;$i++){ //偏差値
    $stDeviation[] = $deviation[$i] * 10 / $sd +50;
}

/* 画面出力用配列 */
$marge = [];
if(!$column2){
    for($j=1;$j<count($result);$j++){

        $marge[$j-1] =[
            $result[$j][$muni],
            (float)$result[$j][$column1],
            (float)$stDeviation[($j-1)]
        ];
    }
}else{
    for($j=1;$j<count($result);$j++){
        $marge[$j-1] =[
            $result[$j][$muni],
            (float)$result[$j][$column1] / (float)$result[$j][$column2],
            (float)$result[$j][$column1],
            (float)$result[$j][$column2],
            (float)$stDeviation[($j-1)]
        ];
}
}

/* ランキング方式に並び替え */
function sortByKey($keyName, $sortOrder, $marge) {
    foreach ($marge as $key => $value) {
        $standardKeyArray[$key] = $value[$keyName];
    }
    array_multisort($standardKeyArray, $sortOrder, $marge);
    return $marge;
}
$sortedArray = sortByKey('1', SORT_DESC, $marge);


/* 棒グラフ用の値作成 */
$max =$sortedArray[0][1];//最大値
$min =$sortedArray[18][1];//最小値
$gap =$max - $min;
$barSize = [];
$barGraphParam = [];
for ($i=0;$i<=4;$i++){
    if(($max -($gap / 3) * $i)>=0){
    $barGraphParam[] = $max - ($gap / 3) * $i;
    }
}
for($i=0; $i<count($marge); $i++){
$barSize []= ($marge[$i][1] - min($barGraphParam)) / (max($barGraphParam) - min($barGraphParam)) * 100 ;
}

}

