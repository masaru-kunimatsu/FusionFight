<?php
session_start();

include 'functions.php';


$html_top = <<< _aaa_

<div class = "conte">
  <div class = "top_image">
    <div class="text-overlay0">
      <p>アプリ版フュージョンファイトの<br>快適なプレイをサポート！</p>
    </div>
    <div class="text-overlay1">
      <p>便利な機能でアプリを遊びつくそう！</p>
    </div>
    <div class="introduction">
      <img src="material/tittle_logo.webp" class="logo-overlay">
      <div class="download">
        <p><i class="fa-brands fa-apple"></i>iOS</p>
        <img src="material/QR_iOS.webp" class="QR-overlay">
      </div>
      <div class="download">
        <p><i class="fa-brands fa-google-play"></i>Android</p>
        <img src="material/QR_GPlay.webp" class="QR-overlay">
      </div>
    </div>
  </div>

  <div class = "top_image2">
    <div class="text-overlay2">
      <p><img src="material/icon_tri.webp" class='top-icon'>画面のバーコードを読み込んで遊べる !</p>
      <p><img src="material/icon_tri.webp" class='top-icon'>UD3弾までのカードを250種類以上収録 !</p>
      <p><img src="material/icon_tri.webp" class='top-icon'>条件のしぼり込みで簡単検索 !</p>
      <p><img src="material/icon_tri.webp" class='top-icon'>お気に入りのデッキを保存しよう !</p>
    </div>
  </div>

  <div class = "top_image3">
    <div class="text-overlay3">
      <div class="text-overlay3_top">
        <img src="material/icon_z.webp" class='z-icon'>２枚のカードを選んでデッキに登録 !
      </div>
      <div class="text-overlay3_bottom">
        <img src="img\UD1-001.webp" class="text-overlay3_bottom_img">
        <i class="fa-solid fa-xmark fa-2x x-icon"></i>
        <img src="img\G1-001.webp" class="text-overlay3_bottom_img">
      </div>
    </div>
    <div class="text-overlay4">
      <div class="text-overlay3_top">
        <img src="material/icon_z.webp" class='z-icon'>バーコードを読み込んでバトル !
      </div>
      <div class="text-overlay3_bottom">
        <img src="material\battle1.webp" class="text-overlay4_bottom_img">
        <img src="material\battle2.webp" class="text-overlay4_bottom_img">
      </div>
    </div>
  </div>

  <div class = "top_image4">
    <div class="text-overlay5">
      <div class="text-overlay3_top">
        <img src="material/icon_z.webp" class='z-icon'>ド派手な必殺技を楽しもう !
      </div>
      <div class="text-overlay5_bottom">
        <img src="material/skill (0).webp" class="text-overlay5_bottom_img">
        <img src="material/skill (1).webp" class="text-overlay5_bottom_img">
        <img src="material/skill (2).webp" class="text-overlay5_bottom_img">
        <img src="material/skill (3).webp" class="text-overlay5_bottom_img">
        <img src="material/skill (4).webp" class="text-overlay5_bottom_img">
        <img src="material/skill (5).webp" class="text-overlay5_bottom_img">
        <img src="material/skill (6).webp" class="text-overlay5_bottom_img">
        <img src="material/skill (7).webp" class="text-overlay5_bottom_img">
        <img src="material/skill (8).webp" class="text-overlay5_bottom_img">
      </div>
    </div>
  </div>

  <div class = "top_image5">
    <div class="text-overlay6">
      <div class="text-overlay3_top">
        <img src="material/icon_z.webp" class='z-icon'>歴代シリーズから多数参戦 !
      </div>
      <div class="text-overlay6_bottom">
        <img src="logo/ウルトラマンデッカー.webp" class="text-overlay6_bottom_img" id="prog24">
        <img src="logo/ウルトラマントリガー.webp" class="text-overlay6_bottom_img" id="prog23">
        <img src="logo/ウルトラマンZ.webp" class="text-overlay6_bottom_img" id="prog22">
        <img src="logo/ウルトラマンタイガ.webp" class="text-overlay6_bottom_img" id="prog21">
        <img src="logo/ウルトラマンRB.webp" class="text-overlay6_bottom_img" id="prog20">
        <img src="logo/ウルトラマンジード.webp" class="text-overlay6_bottom_img" id="pro19">
        <img src="logo/ウルトラマンオーブ.webp" class="text-overlay6_bottom_img" id="prog18">
        <img src="logo/ウルトラマンX.webp" class="text-overlay6_bottom_img" id="prog17">
        <img src="logo/ウルトラマンギンガシリーズ.webp" class="text-overlay6_bottom_img" id="prog16">
        <img src="logo/ウルトラマンゼロシリーズ.webp" class="text-overlay6_bottom_img" id="prog15">
        <img src="logo/ウルトラマンメビウス.webp" class="text-overlay6_bottom_img" id="prog14">
        <img src="logo/ウルトラマンマックス.webp" class="text-overlay6_bottom_img" id="prog13">
        <img src="logo/ウルトラマンネクサス.webp" class="text-overlay6_bottom_img" id="prog12">
        <img src="logo/ウルトラマンコスモス.webp" class="text-overlay6_bottom_img" id="prog11">
        <img src="logo/ウルトラマンガイア.webp" class="text-overlay6_bottom_img" id="prog10">
        <img src="logo/ウルトラマンダイナ.webp" class="text-overlay6_bottom_img" id="prog9">
        <img src="logo/ウルトラマンティガ.webp" class="text-overlay6_bottom_img" id="prog8">
        <img src="logo/ウルトラマン80.webp" class="text-overlay6_bottom_img" id="prog7">
        <img src="logo/ウルトラマンレオ.webp" class="text-overlay6_bottom_img" id="prog6">
        <img src="logo/ウルトラマンタロウ.webp" class="text-overlay6_bottom_img" id="prog5">
        <img src="logo/ウルトラマンエース.webp" class="text-overlay6_bottom_img" id="prog4">
        <img src="logo/帰ってきたウルトラマン.webp" class="text-overlay6_bottom_img" id="prog3">
        <img src="logo/ウルトラセブン.webp" class="text-overlay6_bottom_img" id="prog2">
        <img src="logo/ウルトラマン.webp" class="text-overlay6_bottom_img" id="prog1">
        <img src="logo/ギャラクシーファイトシリーズ.webp" class="text-overlay6_bottom_img" id="prog25">
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    // 画像をクリックしたときの処理
    $('.text-overlay6_bottom_img').click(function(){
        // クリックされた画像のid属性を取得
        var id = $(this).attr('id').replace('prog', '');

        // idをname属性に変更
        $(this).attr('name', 'tittle');
        
        // 非同期通信を行う
        $.ajax({
            type: 'GET',
            url: 'search.php',
            data: { tittle: id }, // 取得したidをname属性としてsearch.phpに渡す
            success: function(response) {
                // 成功した場合の処理
                console.log('非同期通信成功:', response);
                window.location.href = 'search.php';
            },
            error: function(xhr, status, error) {
                // エラーが発生した場合の処理
                console.error('非同期通信エラー:', status, error);
            }
        });
    });
});
</script>

_aaa_;

$tmpl = $html_top;

$html = HTML($tmpl);


// 画面に出力
echo $html;

exit();