<?php

session_start();

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

// HTMLの土台を用意
$html_start = <<< _aaa_
<!-- メインコンテンツ -->
<div class="account">
  <div class="account_box">
    <div class="logout">
        <p class = 'white_text'><a href="bgm_form.php"  class = 'white_link'><i class="fa-solid fa-headphones"></i> BGMを追加する</a></p>
    </div>
  </div>
  <div class="account_box">
    <div class="logout">
        <p class = 'white_text'><a href="bgm_edit.php"  class = 'white_link'><i class="fa-solid fa-sliders"></i> BGMを編集・削除する</a></p>
    </div>
  </div>
</div>
  <!-- /メインコンテンツ -->
_aaa_;

$tmpl .= $html_start;

$file = fopen("tmpl/footer.tmpl", "r") or die("tmpl/footer.tmpl ファイルを開けませんでした。");
$size = filesize("tmpl/footer.tmpl");
$tmpl3 = fread($file, $size);
$tmpl .= $tmpl3;
fclose($file);

// 画面に出力
echo $tmpl;

exit;