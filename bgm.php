<?php

session_start();

include 'functions.php';

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

$tmpl = $html_start;

$html = HTML($tmpl);
echo $html;

exit;