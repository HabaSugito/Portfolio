<?php
//データベース用ファイル

/* ログイン用データ宣言 */
$user = '****';
$pass = '****';
$host = 'localhost';
$dbName = "hsenglish";
$dsn = "mysql:host={$host};dbname={$dbName};charset=utf8";
$muni ="muniName";


try {
    /* PDOクラスの作成とエムレート・エラーモードの変更 */
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    if($column1){
        if (!$column2){
        $sql = "select $muni,$column1 from shiga order by id";
        $stm = $pdo->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        } elseif($column2) {
        $sql = "select $muni,$column1,$column2 from shiga order by id";
        $stm = $pdo->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);

        }
    }
    $sql2 = 'select * from shiga where muniName = "shiga"';
    $stm2 = $pdo->prepare($sql2);
    $stm2->execute();
    $result2 = $stm2->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $e) {
    /* エラー処理 */
    echo $e->getMessage();
    exit();
}



if(isset($result[1]['taxable'])){
    for ($i=1;$i<count($result);$i++){
    $result[$i]['taxable'] =((float)$result[$i]['taxable'] / 100);
}
}