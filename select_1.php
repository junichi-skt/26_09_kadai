<?php
session_start();
include("functions.php");
chk_ssid();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>ニュース検索・編集</title>
<!-- <link rel="stylesheet" href="./css/reset.css"> -->
<link rel="stylesheet" href="./css/style.css"> 
</head>
<body>

<h3>ニュース検索・編集</h3>
<form method="post" action="select_2.php">
<p>ジャンルを選択してください。</p>
<select name="pagetype">
  <option value="music">音楽</option>
  <option value="comic">コミック</option>
  <option value="owarai">お笑い</option>
  <option value="eiga">映画</option>
  <option value="stage">ステージ</option>
</select><br>
<br>
キーワードを入力してください。<br>
<input name="newsword" type="text">
<br>
<br>
<input type="submit" value="検索">
</form>

<br>
<a href="menu.php">メニューに戻る</a>
</body>
</html>
