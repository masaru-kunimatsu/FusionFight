<?php

function GetTmpl($read){

  // footerのテンプレート読み込み
  $text = "tmpl/".$read.".tmpl";
  $file = fopen($text, "r") or die($text." ファイルを開けませんでした。");
  $size = filesize($text);
  $tmpl = fread($file, $size);
  fclose($file);

  return $tmpl;

}


function HTML($main){

  // head要素やheaderのテンプレート読み込み
  $file = fopen("tmpl/head.tmpl", "r") or die("tmpl/head.tmpl ファイルを開けませんでした。");
  $size = filesize("tmpl/head.tmpl");
  $header_html = fread($file, $size);
  fclose($file);
  
  // セッションにユーザー名が保存されているか確認
  if (isset($_SESSION['user_name'])) {
    $user_name = $_SESSION['user_name'];
    $header_html = str_replace("★ユーザー名★", $user_name, $header_html);
  } else {
    $header_html = str_replace("★ユーザー名★", "ゲスト", $header_html);
    }

  $html = $header_html;

  // メインコンテンツのhtmlを追加
  $html .= $main;

  // footerのテンプレート読み込み
  $file = fopen("tmpl/footer.tmpl", "r") or die("tmpl/footer.tmpl ファイルを開けませんでした。");
  $size = filesize("tmpl/footer.tmpl");
  $footer_html = fread($file, $size);
  fclose($file);

  $html .= $footer_html;

  $html = str_replace("●", "/", $html);

  return $html;

}

function SetDBH(){

  // データベースハンドラの設定
  $dsn = 'mysql:host=localhost; dbname=fusionfight; charset=utf8';
  $user = 'testuser';
  $pass = 'testpass';

  $dbh = new PDO($dsn, $user, $pass);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  return $dbh;

}