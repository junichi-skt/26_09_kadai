<?php
session_start();
include("functions.php");
chk_ssid();

// DBに格納されていてjson_flg=1となっているニュースのなかから最新5件についてAlexaスキルのお作法どおりのJSONにする関数
function build_json() {
	$dbh  = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
	$stmt = $dbh-> query("SET NAMES utf8;");
	$stmt = $dbh->query("SELECT * FROM natalie_news_table WHERE json_flg=1 ORDER BY news_date DESC limit 5");

	$res  = [];
	foreach ($stmt as $row) {
		// print($row['news_contents']);
		$newsDateJson = str_replace(" ","T",$row['news_date']);
		array_push(
			$res,
			array(
				'uid'			 => $row['news_id'],
				'titleText'		 => $row['news_title'],
				'updateDate'	 => $newsDateJson.".0Z",
				// 'updateDate'	 => "2018-05-29T00:00:00.0Z",
				// 'updateDate'	 => $row['news_date'].".0Z",
				'mainText'		 => $row['news_contents'],
				'redirectionUrl' => "https://natalie.mu/".$row['news_type']."/news/".$row['news_id']
			)
        );
        echo "［".$row['news_title']."］のJSON作成完了<br>";
	}

	$json = json_encode($res, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
	return $json;
}


// build_json関数で作ったJSONファイルをWEBに転送してAlexaさんが読めるように同期する関数。
// pemさんを配置してない環境では転送できませんよー。
function scp_json($file) {
	// echo "hoge";
	#$cmd = ‘cp test.php test2.php’;
	$cmd = "scp -o 'StrictHostKeyChecking=no' -i ./pem/sekita.pem ./gs.json ec2-user@54.91.175.119:/usr/share/nginx/html/";
	$array = [];
	if ( !exec("$cmd 2>&1",$array)) {
	   //command失敗を検知して処理したい
	   echo "NG";
	}
	var_dump($array);
	}


// JSONデータを作って変数に格納したらgs.jsonってファイルにUTF8で保存してscpでWEBに同期します。
$json = build_json();
$filename = 'gs.json';
$json_utf8 = mb_convert_encoding($json, 'UTF-8');
// print($json);
file_put_contents($filename, $json_utf8);
scp_json($filename);

?>