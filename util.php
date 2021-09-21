<?php
//ユーティリティファイル


/* エスケープ用関数 */
function es($data, $charset = 'UTF-8') {
    if (is_array($data)) {
        return array_map(__METHOD__, $data);
    } else {
        return htmlspecialchars($data, ENT_QUOTES, $charset);
    }
}

/* エンコードチェック */
function chen(array $data) {
    $result = true;
    foreach ($data as $key => $value) {
        if (is_array($value)) {
            $value = false;
        }
        if (!mb_check_encoding($value)) {
            $result = false;
            break;
        }
    }
    return $result;
}

/* 作業用プリントR関数 */
function pri($v) {
    echo "<pre>";
    print_r($v);
    echo "</pre><hr>";
}
