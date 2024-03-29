<?php

session_start();

include 'functions.php';

$html_up = <<< _aaa_
<!-- メインコンテンツ -->
<div class="account">
  <div class="account_box">
    <form action="signup.php" method="POST" class="login-form">
      <h1 class='form_tittle' >新規ユーザー登録</h1>
      <p class="form-label" for="signin-id">ユーザーネーム</p>
      <input id="signin-id" name="name" type="text" placeholder="名前を入力" >
      <br>
      <p class="form-label" for="signin-id">メールアドレス</p>
      <input id="signin-id" name="email" type="email" placeholder="メールアドレスを入力" >
      <br>
      <p class="form-label" for="signin-pass">パスワード</p>
      <input id="signin-pass" name="pass" type="password" placeholder="パスワードを入力">
      <br>
      <button name="login" type="submit" class="login_button">登録する</button>
      <input type='hidden' name='mode' value='conf'>
    </form>
  </div>
</div>
  <!-- /メインコンテンツ -->
_aaa_;

$html_conf = <<< _aaa_
<!-- メインコンテンツ -->
<div class="account">
  <div class="account_box">
    <form action="signup_comp.php" method="POST" class="login-form">
      <h1 class='form_tittle' >以下の内容で登録しますか?</h1>
      <p class="form-label" for="signin-id">ユーザーネーム</p>
      <p class="form-text" >★ユーザー名★</p>
      <br>
      <p class="form-label" for="signin-id">メールアドレス</p>
      <p class="form-text" >★ユーザーメール★</p>
      <br>
      <p class="form-label" for="signin-id">password</p>
      <p class="form-text" >(表示されません)</p>
      <br>
      <button name="submit" type="submit" class="login_button">保存する</button>
      <input type='hidden' name='name' value='★ユーザー名★'>
      <input type='hidden' name='email' value='★ユーザーメール★'>
      <input type='hidden' name='pass' value='★ユーザーパス★'>
    </form>
  </div>
</div>
  <!-- /メインコンテンツ -->
_aaa_;

if (isset($_POST['mode']) && $_POST['mode'] == "conf"){
  $tmpl = $html_conf;
  $tmpl = str_replace("★ユーザー名★", $_POST['name'], $tmpl);
  $tmpl = str_replace("★ユーザーメール★", $_POST['email'], $tmpl);
  $tmpl = str_replace("★ユーザーパス★", $_POST['pass'], $tmpl);
}else{
  $tmpl = $html_up;
}

$html = HTML($tmpl);
echo $html;

exit;
?>