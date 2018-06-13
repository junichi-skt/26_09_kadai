// Youtube Data APIを使った動画検索と検索時の動画ID取得、Fireさん連携に関するJSです。

// Youtube Data APIが正常にロードされると検索ボタンが活性化するようになってる。
function handleAPILoaded() {
  $('#search-button').attr('disabled', false);
}

// Search for a specified string.
function search() {
  var q = $('#query').val();
  var request = gapi.client.youtube.search.list({
    q: q,
    part: 'snippet',
    type: 'video'
  });

  request.execute(function(response) {
    var str = JSON.stringify(response.result);
    var json = response.result;
	console.log(str);
	console.log(json.items);

  // まず、検索結果部分をまっさらにする(検索結果が無限に出ないようにするため）
  $('#search-container').html("");
  //検索結果i個(今はデフォルト設定なので上限5個)まで動画情報をとってくるループ処理。 
  for(var i in json.items) {
    var title = json.items[i].snippet.title;
    var id    = json.items[i].id.videoId;
    var channel = json.items[i].snippet.channelTitle;
    var img_url = json.items[i].snippet.thumbnails.high.url
    //search-containerの下に検索結果のサムネイル画像を表示する処理と検索結果表示の仕込み。
    var $wrap = $('<p>').html(title + '<br>' + channel　+"<br>").css({'background-color': 'black', border: 'red', width: '80%', height: 'auto' ,overflow: "hidden"}),
        $image = $('<img>').attr('src', img_url ).css({ width: '20%', height: 'auto' });
    $wrap.addClass("some-class");
    $wrap.attr('data-id', id);

    // まず、画像をsearch-containerに表示する処理。
    $wrap.append( $image );

    // 検索結果の部分をクリックしたら動画IDをとってFireさんに送る処理を実行。
    $wrap.on('click', function(event){
      var $target = $(event.target);
      console.log("------------------");
      console.log($target.data().id);
      console.log("------------------");
      newPostRef.push({
        movieid: $target.data().id
      })
    });
    // search-containerに動画検索結果を表示
    $('#search-container').append( $wrap);
}
    //$('#search-container').html('<pre>' + str + '</pre>');
  });
}

