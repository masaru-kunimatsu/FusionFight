<?php
session_start();

$file = fopen("tmpl/head.tmpl", "r") or die("tmpl/head.tmpl ファイルを開けませんでした。");
$size = filesize("tmpl/head.tmpl");
$tmpl = fread($file, $size);
fclose($file);

$file = fopen("tmpl/header.tmpl", "r") or die("tmpl/header.tmpl ファイルを開けませんでした。");
$size = filesize("tmpl/header.tmpl");
$tmpl2 = fread($file, $size);
$tmpl .= $tmpl2;
fclose($file);

// セッションにユーザー名が保存されているか確認
if (isset($_SESSION['user_name'])) {
  $file = fopen("tmpl/account_out.tmpl", "r") or die("tmpl/account_out.tmpl ファイルを開けませんでした。");
  $size = filesize("tmpl/account_out.tmpl");
  $tmpl3 = fread($file, $size);
  $tmpl .= $tmpl3;
  fclose($file);
  $user_name = $_SESSION['user_name'];
  $tmpl = str_replace("★ユーザー名★", $user_name, $tmpl);
} else {
  $file = fopen("tmpl/account_in.tmpl", "r") or die("tmpl/account_in.tmpl ファイルを開けませんでした。");
  $size = filesize("tmpl/account_in.tmpl");
  $tmpl4 = fread($file, $size);
  $tmpl .= $tmpl4;
  fclose($file);
  $tmpl = str_replace("★ユーザー名★", "ゲスト", $tmpl);
}

$file = fopen("tmpl/footer.tmpl", "r") or die("tmpl/footer.tmpl ファイルを開けませんでした。");
$size = filesize("tmpl/footer.tmpl");
$tmpl5 = fread($file, $size);
$tmpl .= $tmpl5;
fclose($file);

// 画面に出力
echo $tmpl;

exit();

?>