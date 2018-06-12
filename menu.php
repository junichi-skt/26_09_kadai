<?php
session_start();
//0.外部ファイル読み込み
include("functions.php");
chk_ssid();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>データ登録</title>
</head>
<body>

        <h3>管理メニュー</h3>
        <a href="index.php">ニュース取得</a><br>
        <br>
        <br>
        <a href="select_json.php">ニュースJSON作成</a><br>
        <br>
        <br>        
        <a href="select_1.php">ニュース検索・編集</a><br>
        <br>
        <br>
        <a href="analysis.php">DB取得済ニュース集計情報</a><br>
        <br>
        <br>
        <br>
        <br>
        <?php if($_SESSION["kanri_flg"]==1){ ?>
        <a href="account_menu.php">[アカウント管理メニューへ]</a><br>
        <?php } ?> 
        <br>
        <a href="logout.php">[ログアウト]</a><br>        
        <br>
        <br>
        
</body>
</html>
