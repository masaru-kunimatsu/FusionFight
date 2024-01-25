<?php
session_start();

include 'functions.php';
$header_tmpl = GetHeader();
$tmpl = $header_tmpl;

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
} else {
  $tmpl .= $html_out;
}

$footer_tmpl = GetFooter();
$tmpl .= $footer_tmpl;



// 画面に出力
echo $tmpl;

exit();

?>