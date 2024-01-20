<?php
session_start();

$file = fopen("head.tmpl", "r") or die("head.tmpl ファイルを開けませんでした。");
$size = filesize("head.tmpl");
$tmpl = fread($file, $size);
fclose($file);

$file = fopen("header.tmpl", "r") or die("header.tmpl ファイルを開けませんでした。");
$size = filesize("header.tmpl");
$tmpl2 = fread($file, $size);
$tmpl .= $tmpl2;
fclose($file);

// セッションにユーザー名が保存されているか確認
if (isset($_SESSION['user_name'])) {
  $file = fopen("account_out.tmpl", "r") or die("account_out.tmpl ファイルを開けませんでした。");
  $size = filesize("account_out.tmpl");
  $tmpl3 = fread($file, $size);
  $tmpl .= $tmpl3;
  fclose($file);
  $user_name = $_SESSION['user_name'];
  $tmpl = str_replace("★ユーザー名★", $user_name, $tmpl);
} else {
  $file = fopen("account_in.tmpl", "r") or die("account_in.tmpl ファイルを開けませんでした。");
  $size = filesize("account_in.tmpl");
  $tmpl4 = fread($file, $size);
  $tmpl .= $tmpl4;
  fclose($file);
  $tmpl = str_replace("★ユーザー名★", "ゲスト", $tmpl);
}

$file = fopen("footer.tmpl", "r") or die("footer.tmpl ファイルを開けませんでした。");
$size = filesize("footer.tmpl");
$tmpl5 = fread($file, $size);
$tmpl .= $tmpl5;
fclose($file);

// 画面に出力
echo $tmpl;

exit();

?>