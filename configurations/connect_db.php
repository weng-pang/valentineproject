<?php
// 建立資料庫連線
$link = mysql_connect($cfgDB_HOST . ":" . $cfgDB_PORT, $cfgDB_USERNAME, $cfgDB_PASSWORD);

// 選擇資料庫
mysql_select_db($cfgDB_NAME, $link);
?>