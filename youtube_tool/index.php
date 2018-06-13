<?php
include("../functions.php");

//1.  DB接続します
$pdo = db_conn();

//２．json_flgが1となっているニュースを最新順に並べてとってくるSQL処理
$stmt = $pdo->prepare("SELECT * FROM natalie_news_table ORDER BY news_date DESC LIMIT 5");
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
    $view .= '<div class="article"><p class="news-date">'.$result["news_date"].'</p><br>';
    $view .= '<p class="news-title">'.$result["news_title"].'</p><br>';
    $view .= '<p class="news-contents">'.$result["news_contents"].'</p><br>';
    $view .= '</div><hr>';
  }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>Chatアプリ</title>
<link rel="stylesheet" href="./css/reset.css">
<link rel="stylesheet" href="./css/style.css">
</head>
<body>
YouTube同時閲覧ツール
<div class="main">
    <!-- 動画プレーヤー部分 -->
    <div class="area-video">
        <!-- ニコニコ風表示部分(コメント動作の細部は主にnncoment.jsで制御) -->
        <div id="nico-screen" class="nnc-screen">
            <!-- Youtubeのiframe表示部分 -->
            <div  id="player" class="wrap-frame"></div>
        </div>

        <!-- コメント投稿部分 -->
        <div class="area-input">
            <div class="name-input">       
            <span>名前</span><input type="text" id="username">
            </div>
            <div class="comment-input">
            <form id="comment" action="#">
                <span>コメント</span><textarea id="msg" rows="1"></textarea>
                <button id="msgsend">送信</button>
            </form>
            </div>
        </div>
        <!-- コメントリスト表示部分 -->
        <div class="area-comment">
            <div id="output">
            </div>
        </div>
    </div>

    <!-- youtube検索部分(主にauth.jsとsearch.jsで制御) -->
    <div class="area-search">
    <span>動画検索(見たい動画の画像をクリック)</span>
        <div id="buttons" class="wrap-search">
            <label> <input id="query" value='' type="text"/><button id="search-button" disabled onclick="search()">Search</button></label>
        </div>
        <div id="search-container" class="wrap-result">
        </div>
    </div>

    <!-- ニューストピック表示部分 -->
    <div class="area-news">
    <span>最新ニューストピック</span>
    <br>
    <br>
        <div><?= $view ?></div>
    </div>
    
</div>




    <!-- 以下JavaScript領域 -->
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <!-- 以下Firebase、Youtube関連、ニコニコ風、JSファイルの順で読み込み -->
    <script src="https://www.gstatic.com/firebasejs/4.12.1/firebase.js"></script>
    <script src="./js/auth.js"></script>
    <script src="./js/search.js"></script>
    <script src="https://apis.google.com/js/client.js?onload=googleApiClientReady"></script>
    <script src="//www.youtube.com/iframe_api"></script>
    <script src="./js/nncomment.js"></script>
    <script src="./js/index.js"></script>


</body>
</html>
































