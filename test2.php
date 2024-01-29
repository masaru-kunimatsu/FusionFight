<?php
session_start();

include 'functions.php';


$html_top = <<< _aaa_

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
    <img src="material/top2_image.png" alt="Top Image">
    <div class="text-overlay2">
      <p><img src="material/icon_tri.png" class='top-icon'>画面のバーコードを読み込んで遊べる !</p>
      <p><img src="material/icon_tri.png" class='top-icon'>UD3弾までのカードを250種類以上収録 !</p>
      <p><img src="material/icon_tri.png" class='top-icon'>条件のしぼり込みで簡単検索 !</p>
      <p><img src="material/icon_tri.png" class='top-icon'>お気に入りのデッキを保存しよう !</p>
    </div>
  </div>

  <div class = "top_image3">
    <img src="material/top3_image.png" alt="Top Image">
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
    <img src="material/top4_image.png" alt="Top Image">
    <div class="text-overlay5">
    </div>
    <div class="text-overlay4">
    </div>
  </div>

_aaa_;

$tmpl = $html_top;

$html = HTML($tmpl);


// 画面に出力
echo $html;

exit();