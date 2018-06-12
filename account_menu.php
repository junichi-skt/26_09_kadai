<?php
session_start();
include("functions.php");
chk_ssid();

// スーパー管理者以外がURLにアクセスしたらログイン画面を表示
if($_SESSION["kanri_flg"]!=1){
  header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>アカウントメニュー</title>
</head>
<body>

        <h3>アカウント管理メニュー</h3>
        <a href="account_create.php">新規アカウント作成</a><br>
        <br>
        <br>
        <a href="account_select.php">アカウント一覧・編集</a><br>
        <br>
        <br>
        <br>
        <br>
        <a href="menu.php">[管理メニューへ]</a><br>
        <br>
        
</body>
</html>
