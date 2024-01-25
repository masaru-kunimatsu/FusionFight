<?php

function GetHeader(){

  // head要素やheaderのテンプレート読み込み
  $file = fopen("tmpl/head.tmpl", "r") or die("tmpl/head.tmpl ファイルを開けませんでした。");
  $size = filesize("tmpl/head.tmpl");
  $tmpl = fread($file, $size);
  fclose($file);

  // セッションにユーザー名が保存されているか確認
  if (isset($_SESSION['user_name'])) {
    $user_name = $_SESSION['user_name'];
    $tmpl = str_replace("★ユーザー名★", $user_name, $tmpl);
  } else {
    $tmpl = str_replace("★ユーザー名★", "ゲスト", $tmpl);
  }

  return $tmpl;

}

function GetFooter(){

  // footerのテンプレート読み込み

  $file = fopen("tmpl/footer.tmpl", "r") or die("tmpl/footer.tmpl ファイルを開けませんでした。");
  $size = filesize("tmpl/footer.tmpl");
  $tmpl = fread($file, $size);
  fclose($file);

  return $tmpl;

}
