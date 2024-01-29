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
        <img src="material/QR_iOS.png" class="QR-overlay">
      </div>
      <div class="download">
        <p><i class="fa-brands fa-google-play"></i>Android</p>
        <img src="material/QR_GPlay.png" class="QR-overlay">
      </div>
    </div>
  </div>

  <div class = "top_image2">
    <div class="text-overlay2">
      <p><img src="material/icon_tri.png" class='top-icon'>画面のバーコードを読み込んで遊べる !</p>
      <p><img src="material/icon_tri.png" class='top-icon'>UD3弾までのカードを250種類以上収録 !</p>
      <p><img src="material/icon_tri.png" class='top-icon'>条件のしぼり込みで簡単検索 !</p>
      <p><img src="material/icon_tri.png" class='top-icon'>お気に入りのデッキを保存しよう !</p>
    </div>
  </div>

  <div class = "top_image3">
    <div class="text-overlay3">
      <div class="text-overlay3_top">
        <img src="material/icon_z.png" class='z-icon'>２枚のカードを選んでデッキに登録 !
      </div>
      <div class="text-overlay3_bottom">
        <img src="img\UD1-001.png" class="text-overlay3_bottom_img">
        <i class="fa-solid fa-xmark fa-2x x-icon"></i>
        <img src="img\G1-001.png" class="text-overlay3_bottom_img">
      </div>
    </div>
    <div class="text-overlay4">
      <div class="text-overlay3_top">
        <img src="material/icon_z.png" class='z-icon'>バーコードを読み込んでバトル !
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
        <img src="material/icon_z.png" class='z-icon'>ド派手な必殺技を楽しもう !
      </div>
      <div class="text-overlay5_bottom">
        <img src="material/skill (1).png" class="text-overlay5_bottom_img">
        <img src="material/skill (2).png" class="text-overlay5_bottom_img">
        <img src="material/skill (3).png" class="text-overlay5_bottom_img">
        <img src="material/skill (4).png" class="text-overlay5_bottom_img">
        <img src="material/skill (5).png" class="text-overlay5_bottom_img">
        <img src="material/skill (6).png" class="text-overlay5_bottom_img">
        <img src="material/skill (7).png" class="text-overlay5_bottom_img">
        <img src="material/skill (8).png" class="text-overlay5_bottom_img">
      </div>
    </div>
  </div>

  <div class = "top_image5">
    <div class="text-overlay6">
      <div class="text-overlay3_top">
        <img src="material/icon_z.png" class='z-icon'>歴代シリーズから多数参戦 !
      </div>
      <div class="text-overlay6_bottom">
        <img src="logo/ウルトラマンデッカー.webp" class="text-overlay6_bottom_img">
        <img src="logo/ウルトラマントリガー.webp" class="text-overlay6_bottom_img">
        <img src="logo/ウルトラマンZ.webp" class="text-overlay6_bottom_img">
        <img src="logo/ウルトラマンタイガ.webp" class="text-overlay6_bottom_img">
        <img src="logo/ウルトラマンRB.webp" class="text-overlay6_bottom_img">
        <img src="logo/ウルトラマンジード.webp" class="text-overlay6_bottom_img">
        <img src="logo/ウルトラマンオーブ.webp" class="text-overlay6_bottom_img">
        <img src="logo/ウルトラマンX.webp" class="text-overlay6_bottom_img">
        <img src="logo/ウルトラマンギンガシリーズ.webp" class="text-overlay6_bottom_img">
        <img src="logo/ウルトラマンゼロシリーズ.webp" class="text-overlay6_bottom_img">
        <img src="logo/ウルトラマンメビウス.webp" class="text-overlay6_bottom_img">
        <img src="logo/ウルトラマンマックス.webp" class="text-overlay6_bottom_img">
        <img src="logo/ウルトラマンネクサス.webp" class="text-overlay6_bottom_img">
        <img src="logo/ウルトラマンコスモス.webp" class="text-overlay6_bottom_img">
        <img src="logo/ウルトラマンガイア.webp" class="text-overlay6_bottom_img">
        <img src="logo/ウルトラマンダイナ.webp" class="text-overlay6_bottom_img">
        <img src="logo/ウルトラマンティガ.webp" class="text-overlay6_bottom_img">
        <img src="logo/ウルトラマン80.webp" class="text-overlay6_bottom_img">
        <img src="logo/ウルトラマンレオ.webp" class="text-overlay6_bottom_img">
        <img src="logo/ウルトラマンタロウ.webp" class="text-overlay6_bottom_img">
        <img src="logo/ウルトラマンエース.webp" class="text-overlay6_bottom_img">
        <img src="logo/帰ってきたウルトラマン.webp" class="text-overlay6_bottom_img">
        <img src="logo/ウルトラセブン.webp" class="text-overlay6_bottom_img">
        <img src="logo/ウルトラマン.webp" class="text-overlay6_bottom_img">
        <img src="logo/ギャラクシーファイトシリーズ.webp" class="text-overlay6_bottom_img">
      </div>
    </div>
  </div>
</div>
_aaa_;

$tmpl = $html_top;

$html = HTML($tmpl);


// 画面に出力
echo $html;

exit();