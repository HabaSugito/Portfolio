<?php
// index.php用関数

/* セレクターオプション作成関数 */
$col1 = 'column1';
$col2 = 'column2';
function selecter($array,$column){
    $selected = "";
    if(isset($array)){
        foreach ($array as $key => $value){
            if($key === 'id'){
                continue;
            }
            if($key === 'muniName'){
                continue;
            }
            if($key === $_POST["$column"]){
                $selected =' selected';
                echo '<option value="'.$key.'"'.$selected .'>'.$value.'</option>'.PHP_EOL;
            }else{
                echo '<option value="'.$key.'">'.$value.'</option>'.PHP_EOL;

            }
        }
    }
}

/* ポストデータチェック */
$column1 ="";
$column2 ="";
if( isset($_POST['column1'])){
    $column1 =$_POST['column1'];
}
if (isset($_POST['column2'])){
    $column2 =$_POST['column2'];
}

/* 地図の色変更用CSS作成 */
function mapColor($stDeviation) {
echo '<style type="text/css">';
echo '<!--'.PHP_EOL;
for ($i=0; $i<19;$i++){
    $deg = ($stDeviation[$i] - 50) *4.5;
    echo '#map'.($i+1).'{'.PHP_EOL;
        echo 'filter: hue-rotate('.$deg.'deg);'.PHP_EOL;
        echo '}'.PHP_EOL;
    }

}

/* 棒グラフ用関数 */
function barSize($barSize) {

    for ($i=0; $i<19;$i++){
        $long = $barSize[$i];
        echo '#barnum'.($i).'{'.PHP_EOL;
            echo 'height: '. (180 * $long/100 + 17).'px ;'.PHP_EOL;
            echo '}'.PHP_EOL;
        }
    echo '-->'.PHP_EOL;
    echo '</style>'.PHP_EOL;
    }

