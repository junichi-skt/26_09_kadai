<?php
session_start();
include("functions.php");
chk_ssid();

//1.  DB接続します
$pdo = db_conn();

//２．json_flgが1となっているニュースを最新順に並べてとってくるSQL処理
$stmt = $pdo->prepare("SELECT * FROM natalie_news_table WHERE json_flg = 1 ORDER BY news_date DESC LIMIT 30");
$status = $stmt->execute();

//３．SQLでとってきたデータを表示
$view="";
if($status==false) {
  errorMsg($stmt);
}else{
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  //演算子.=を使うのはwhile処理でどんどん変数に加えていくから。
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){ 
    $view .= '<div class="article"><p class="news-date">'.$result["news_date"].'［JSONフラグ：'.$result["json_flg"].'］</p><br>';
    $view .= '<p class="news-title">'.$result["news_title"].'</p><br>';
    $view .= '<p class="news-contents">'.$result["news_contents"].'</p><br>';
    $view .= '<a href="edit.php?news_id='.$result["news_id"].'&news_title='.$result["news_title"].'&news_contents='.$result["news_contents"].'&json_flg='.$result["json_flg"].'">';
    $view .= '[記事を編集]';
    $view .= '</a>　';
    $view .= '<a href="delete.php?news_id='.$result["news_id"].'&news_title='.$result["news_title"].'">';
    $view .= '[記事を削除]';
    $view .= '</a>';
    $view .= '</div><hr>';
  }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>JSON変作成対象ニュース一覧</title>
  <!-- <link rel="stylesheet" href="./css/reset.css"> -->
  <link rel="stylesheet" href="./css/style.css"> 
</head>

<div>
<h3>JSON作成対象ニュース一覧</h3>
<p>対象ニュース(最大表示件数：最新30件まで)</p>
<p>(配信日が最新の5つまでがJSONに変換されるよ)</p>




  <input id ="creJson" type="BUTTON" value="JSON作成" onClick="location.href='create_json.php'">
  <input id ="read" type="BUTTON" value="タイトル音声読み上げ">
  <br>
  <br>
  <div id="search-result"><?=$view?></div>
</div>


  <br>
  <a href="menu.php">メニューに戻る</a>

<script src="http://code.jquery.com/jquery-3.2.1.js"></script>
<script src="./js/yomiagechan.js"></script>

</body>
</html>