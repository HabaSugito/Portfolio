<?php
require_once "util.php";
require_once "function.php";
require_once "getDB.php";
require_once "calc.php";
if (!chen($_POST)) {
    $encording = mb_internal_encoding();
    $err = "Encording Error! The expected encording is " . $encording;
    exit($err);
}
?>
<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
    <?php if($column1 != $column2 && $column1){ 
        mapColor($stDeviation);/* 地図カラー読み込み */
        barSize($barSize);   /* バーサイズ読み込み */     
        }; ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@300&display=swap" rel="stylesheet">
</head>
<body>
    <div id="wrap">
    <header>
    <h1>滋賀県 市町村別統計情報比較</h1>
    <p>滋賀県の市町村別の統計情報を簡易比較ができるwebサイトです。</p>
    </header>
    <section class="form">
        <form method="post" action="">
            <div id="formcontainer">
                <div class="left">
            分子：
            <select name="column1" id="selecter1">
                <option value="">値を選んでください(必須)</option>
                <?php
                /* 分子セレクト作成 */
                selecter($result2[0],$col1);
                ?>
            </select><span class="red">※必須</span>
            <br>
            分母：
            <select name="column2" id="selecter2">　　　
            <option value="">値を選んでください(任意)</option>
                <?php
                /* 分母セレクト作成 */
                selecter($result2[0],$col2);
                ?>
            </select>
            </div>
            </div>
            <input type="submit" value="実行">
        </form>
    </section>
    <section class="graph">
    <div id="graphFrame">
                <h2 class="variable">
            <?php
            /* 利用する変数名を表示 */
            if($column1 && !$column2){
                $useVariable = '値:'.$result[0][$column1];
            }elseif($column1 === $column2){
                $useVariable = "分子と分母にそれぞれ異なる値を入力してください";
            }elseif ($column1 && $column2){
                $useVariable = '分子 ：'. $result[0][$column1]. ' / 分母 ：'. $result[0][$column2];
            }else{
                $useVariable = "分子と分母にそれぞれ異なる値を入力してください";
            }
            echo $useVariable;
            ?>
        </h2>

        <?php 

        if($column1 != $column2 && $column1){ 
            ?>
        
        <h3>棒グラフ比較</h3>
            <div id="graph">
                <div id="memory">
                    <?php
                    /* 棒グラフの左側パラメータの表示 */
                    if ($column2){
                        $check = 4;
                    } else {
                        $check = 0;
                    }
                    foreach($barGraphParam as $index => $value){
                        echo '<div id="param'.$index.'">'.number_format($value,$check).'</div>'.PHP_EOL;
                    }

                    ?>
                </div>
                <div id="bargraph">
                    <div id="bar">
                        <!-- 棒グラフの棒を表示 -->
                        <?php
                        $check=0;
                        if($column2){
                            $check=4;
                        }
                        if($column1=='taxable'){
                            for($i=0;$i<count($marge);$i++){
                            echo '<div class="barspace" id="barnum'.$i.'">'.number_format((float)$marge[$i][1],2).'</div>'.PHP_EOL;
                            }
                        }else{
                            for($i=0;$i<count($marge);$i++){
                                echo '<div class="barspace" id="barnum'.$i.'">'.number_format((float)$marge[$i][1],$check).'</div>'.PHP_EOL;
                        }
                        }
                        ?>
                    </div>
                    <div id="barname">
                        <!-- 棒グラフの各棒の名前を表示 -->
                        <?php
                        for($i=0;$i<count($marge);$i++){
                            echo '<div id="bar'.$i.'">'.$marge[$i][0].'</div>'.PHP_EOL;
                            }
                        ?>
                    </div>
                </div>
            </div>
        <br>
        <br>
        <h3>ランキング</h3>
        <div id="ranking">
            <table><tr>
            <th>順位</th>
            <th>市町村名</th>
        <?php
        if($column2){
            /* テーブルでランキング表題の作成 */
        echo '<th>比較の値</th>';
        }
        foreach($result[0] as $key => $value){
            if($value == 'shiga'){
                continue;
            }
            echo '<th>',$result[0][$key],'</th>';
        }
        echo '<th>偏差値</th>';
        echo '</tr>';  
        /* テーブル中身の作成 */
        for($j=0;$j<count($sortedArray);$j++){
            echo '<td>',($j+1),'</td>';
            echo '<td>',$sortedArray[$j][0],'</td>'.PHP_EOL;
                if($column2){
                    echo '<td><b>',number_format($sortedArray[$j][1],4),'</b></td>'.PHP_EOL;
                    echo '<td>',number_format($sortedArray[$j][2]),'</td>'.PHP_EOL;
                    echo '<td>',number_format($sortedArray[$j][3]),'</td>'.PHP_EOL;
                    echo '<td>',number_format($sortedArray[$j][4],1),'</td>'.PHP_EOL;
                } elseif($column1 ==="taxable") {
                    echo '<td><b>',number_format($sortedArray[$j][1],2),'</b></td>'.PHP_EOL;
                    echo '<td>',number_format($sortedArray[$j][2]),'</td>'.PHP_EOL;
                } else {
                    echo '<td><b>',number_format($sortedArray[$j][1]),'</b></td>'.PHP_EOL;
                    echo '<td>',number_format($sortedArray[$j][2]),'</td>'.PHP_EOL;
                }
            echo '</tr>'.PHP_EOL;
        }

        ?>
        </table>
        </div>

   　   <h3>偏差値地図</h3>
            <div id="map">
                <div id="mapexprain">
                <dl>
                    <dt><img src="images/pic.png" id="deg135"></dt>
                    <dd>偏差値80</dd>
                    <dt><img src="images/pic.png" id="deg90"></dt>
                    <dd>偏差値70</dd>
                    <dt><img src="images/pic.png" id="deg45"></dt>
                    <dd>偏差値60</dd>
                    <dt><img src="images/pic.png" id="deg0"></dt>
                    <dd>偏差値50</dd>
                    <dt><img src="images/pic.png" id="deg-45"></dt>
                    <dd>偏差値40</dd>
                    <dt><img src="images/pic.png" id="deg-90"></dt>
                    <dd>偏差値30</dd>
                    <dt><img src="images/pic.png" id="deg-135"></dt>
                    <dd>偏差値20</dd>
                </dl>
                </div>
                <div id="mapfigure">
                    <?php
                    /* マップ画像表示 */
                    for ($i=19; $i>=0;$i--){
                    echo '<img src="images/'.$i.'.png" class="map" id="map'.$i.'">';
                    }
                    ?>
                </div>
            </div>
        <?php } ?>
    </div>

    </section>
    <section class="rank">

    </section>
    <section class="explaination">
        このデータは総務省の統計局のデータを用いています。<br>
        市区町村データは、2020年3月31日時点の市区町村で整備しています。<br>
        データに関する詳細は総務省統計局でお調べください。
        <ul>
            <li>取得日：2021年9月16日</li>
            <li>リンク：<a href="https://www.e-stat.go.jp/regional-statistics/ssdsview">総務省統計局</a></li>
        </ul>
    </section>
    <footer>
        <small> created by Haba 2021</small>
    </footer>
    </div>
</body>
</html>
