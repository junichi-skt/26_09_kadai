
// Firebase接続    
var config = {
  apiKey: "AIzaSyA1gVfIbUfxlYcXCWBqEnTfimspvVAdOyU",
  authDomain: "chatapp-7d850.firebaseapp.com",
  databaseURL: "https://chatapp-7d850.firebaseio.com",
  projectId: "chatapp-7d850",
  storageBucket: "",
  messagingSenderId: "435229506529"
};
firebase.initializeApp(config);


// FirebaseのMSG送受信準備
var newPostRef = firebase.database().ref();


// Youtubeのiframe読み込みに必要な各種設定と初期動画設定。
var ytArea = "player"; // プレーヤーを埋め込む場所の変数
var ytID = "Lve4n8aMKaQ"; // 埋め込むYouTube IDの変数
var ytWidth = 560; // プレイヤーの高さの変数 推奨560
var ytHeight = 315; // プレイヤーの幅の変数 推奨315

var player; 
function onYouTubeIframeAPIReady() {
    player = new YT.Player(ytArea, {
      height: ytHeight, // プレイヤーの高さ
      width: ytWidth, // プレイヤーの幅
      videoId: ytID, // 再生する動画のYouTube ID
      events: {
        "onStateChange": onPlayerStateChange // 状態が変更された時のイベント設定 
      }
    });
  }


// 動画のステータスが変更された時にFirebaseに情報を連携
function onPlayerStateChange(event) {  
    // 現在のプレーヤーの状態とその時の動画の時間を取得  
    var movieStatus = event.data;
    var ytTime = player.getCurrentTime();
    // 再生開始時にステータス(値：1)と動画の時間を連携
    if (movieStatus == YT.PlayerState.PLAYING){
        console.log(movieStatus + "：再生中っす");
        console.log(ytTime);
        console.log(ytID);
        newPostRef.push({
            movieid: ytID,
            status: movieStatus,
            currenttime: ytTime
        });
    }
    // 停止時にステータス(値：2)と動画のID・時間をFireさんに連携
    if (movieStatus == YT.PlayerState.PAUSED){
        console.log(movieStatus + "：停止しますた");
        console.log(ytTime);
        console.log(ytID);
        newPostRef.push({
            movieid: ytID,
            status: movieStatus,
            currenttime: ytTime
        });
    }
    // バッファー時(値：3)はとりあえずコンソールにだすだけ。
    if (movieStatus == YT.PlayerState.BUFFERING){
        console.log(movieStatus + "：バッファ中っす");
        // newPostRef.push({status: movieStatus});
    }
    // 頭出し時(値：5)はとりあえずコンソールにだすだけ。
    if (movieStatus == YT.PlayerState.CUED){
        console.log(movieStatus + "：頭出しっす");
        // newPostRef.push({status: movieStatus});
    }
    // 再生終了時にステータス(値：0)をFireさんに連携
    if (movieStatus == YT.PlayerState.ENDED) {  
        console.log(movieStatus + "：--再生終了っす。--");  
        newPostRef.push({status: movieStatus});
    }  
};

// MSGデータと氏名・日時をFirebaseに送信して入力欄を空にする。
$("#msgsend").on("click",function(){
    var sendDate = new Date();
    newPostRef.push({
        username: $("#username").val(),
        message: $("#msg").val(),
        year: sendDate.getFullYear(),
        month: sendDate.getMonth()+1,
        week: sendDate.getDay(),
        day: sendDate.getDate(),
        hour: sendDate.getHours(),
        minute: sendDate.getMinutes(),
        second: sendDate.getSeconds()
    });
    $("#msg").val(""); //入力欄カラにして
      return false; //処理終了。onclickでブラウザが画面遷移させないようにするおまじない。
});

// FirebaseからのMSGデータ受信処理と受信したデータ種別に応じた処理を記載。
// child_added：毎回1個受信するごとにデータを取得
newPostRef.on("child_added",function(data){
    var v = data.val(); //データ取得
    var k = data.key; //ユニークKEY取得
    var sendDate = v.year + '/' + v.month + '/' + v.day + ' ' + v.hour  + '時' + v.minute + '分' + v.second + '秒';

    //timelineメッセージ作成
    var str = '<dl><dt>'+v.username+'</dt><dd>'+sendDate+'</dd><dd>'+v.message+'</dd></dl>';
    // メッセージが入ってて、動画IDでなかったらコメントをニコニコ風にながしてoutputにも表示。
    if(v.message != null && v.movieid == null){
        $("#nico-screen").comment(v.message);
        $("#output").prepend(str);
    }
    // メッセージも動画ステータスもなかったら(＝動画IDが更新されたら)iframeプレーヤーの動画IDを更新。
    if(v.message == null && v.status == null){
        player.cueVideoById(v.movieid);
        console.log(v.movieid);
    }
    // 受信した動画ステータスが再生中だったら動画を再生
    if(v.status == 1){
        console.log(v.status);
        player.playVideo();
    }
    // 受信した動画ステータスが再生前だったら停止して開始位置へシーク。
    if(v.status == -1){
        player.pauseVideo();
        player.seekTo(0);
    }

    // 受信した動画ステータスが停止中だったら動画を停止
    if(v.status == 2){
        console.log(v.status);
        player.pauseVideo();
    }
    // 受信した動画ステータスが再生終了だったら動画を停止して開始位置へシーク。
    if(v.status == 0){
        player.pauseVideo();
        player.seekTo(0);
    }
});

