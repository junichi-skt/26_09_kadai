<?php
//認証処理と関数読み込み
session_start();
include("functions.php");
chk_ssid();

//入力チェック(受信確認処理追加)
if(
  !isset($_GET["news_id"]) || $_GET["news_id"]=="" ||
  !isset($_GET["news_title"]) || $_GET["news_title"]==""||
  !isset($_GET["news_contents"]) || $_GET["news_contents"]==""||
  !isset($_GET["json_flg"]) || $_GET["json_flg"]==""
){
  exit('ParamError');
}

//1. GETデータ取得
$newsId   = $_GET["news_id"];
$newsTitle = $_GET["news_title"];
$newsContents = $_GET["news_contents"];
$jsonFlg = $_GET["json_flg"];

// //2. DB接続します(エラー処理もあり)
// include("functions.php");
// $pdo = db_conn();


// //３．データ削除SQL作成。bindValueさんはSQLインジェクション対策だよ。
// $stmt = $pdo->prepare("DELETE FROM natalie_news_table WHERE news_id=:newsId");
// $stmt->bindValue(':newsId', $newsId);
// $status = $stmt->execute();

// //４．データ登録処理後
// $view ="";// 削除結果表示用に変数を設定しとくよ。
// if($status==false){
//   errorMsg($stmt);
// }else{
//   //５．index.phpへリダイレクト。exitはおまじないで処理終了。
//   $view .= '<p>ニュースID：'.$newsId.'<br>';
//   $view .= "タイトル：".$newsTitle.'<br>';
//   $view .= "のDB削除が完了したよ</p>";
//   // header("Location: select.php");
//   // exit;
// }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>

<form method="post" action="update.php">
  <div class="jumbotron">
   <fieldset>
    <legend>ニュース記事の編集</legend>
    <label>Alexa連携対象フラグ：
    <select name="jsonFlg">
      <?php if($jsonFlg==0){ ?>
      <option value="<?= $jsonFlg?>">対象外</option>
      <option value="1">対象</option>
      <?php } ?>
      <?php if($jsonFlg==1){ ?>
      <option value="<?= $jsonFlg?>">対象</option>
      <option value="0">対象外</option>
      <?php } ?>
    </select>
      </label><br>
     <label>ＩＤ：<input type="text" name="newsId" value="<?= $newsId?>" readonly></label><br>
     <label>表題：<textArea name="newsTitle" rows="1" cols="100"><?= $newsTitle?></textArea></label><br>
     <label>記事：<textArea name="newsContents" rows="10" cols="100"><?= $newsContents?></textArea></label><br>
     <br>
     <input type="submit" value="更新する">
    </fieldset>
  </div>
</form>
  <br>
  <a href="menu.php">メニューに戻る</a>
</body>
</html>
