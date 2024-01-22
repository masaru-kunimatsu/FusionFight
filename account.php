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

$html_in = <<< _aaa_
<!-- メインコンテンツ -->
<div class="account">
  <div class="account_box">
    <div class="logout">
        <p class = 'white_text'><a href="account_edit.php"  class = 'white_link'>ユーザー情報を編集する <i class="fa-regular fa-pen-to-square"></i></a></p>
    </div>
  </div>
  <div class="account_box">
    <div class="logout">
        <p class = 'white_text'><a href="logout.php"  class = 'white_link'>ログアウトする <i class="fa-solid fa-person-walking-arrow-right"></i></a></p>
    </div>
  </div>
  <div class="account_box">
    <div class="logout">
        <p class = 'white_text'><a href="account_delete.php"  class = 'white_link'>アカウントを削除する <i class="fa-solid fa-user-xmark"></i></a></p>
    </div>
  </div>
</div>
  <!-- /メインコンテンツ -->
_aaa_;

$html_out = <<< _aaa_
<!-- メインコンテンツ -->
<div class="account">
  <div class="account_box">
    <div class="logout">
        <p class = 'white_text'><a href="signup.php"  class = 'white_link'>新規ユーザー登録 <i class="fa-solid fa-users"></i></a></p>
    </div>
  </div>
  <div class="account_box">
    <div class="logout">
        <p class = 'white_text'><a href="login.php"  class = 'white_link'>ログイン <i class="fa-solid fa-right-to-bracket"></i></a></p>
    </div>
  </div>
</div>
  <!-- /メインコンテンツ -->
_aaa_;

// セッションにユーザー名が保存されているか確認
if (isset($_SESSION['user_name'])) {
  $tmpl .= $html_in;
  $user_name = $_SESSION['user_name'];
  $tmpl = str_replace("★ユーザー名★", $user_name, $tmpl);
} else {
  $tmpl .= $html_out;
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