<?php

session_start();

include 'functions.php';

$html_in = <<< _aaa_
<!-- メインコンテンツ -->
<div class="account">
  <div class="account_box">
    <form action="login.php" method="POST" class="login-form">
      <h1 class='form_tittle' >ログイン</h1>
      <p class="form-label" for="signin-id">メールアドレス</p>
      <input id="signin-id" name="email" type="email" placeholder="メールアドレスを入力">
      <br>
      <p class="form-label" for="signin-pass">パスワード</p>
      <input id="signin-pass" name="pass" type="password" placeholder="パスワードを入力">
      <br>
      <button name="login" type="submit" class="login_button">ログインする</button>
    </form>
  </div>
</div>
  <!-- /メインコンテンツ -->
_aaa_;

$html_comp = <<<_aaa_
<div class="white_bg">
  <div class="white_bg_box">
    <h1 class='white_tittle' >正常にログインしました</h1>
    <p class = 'white_text'><i class="fa-solid fa-angles-left"></i><a href="★パス★"  class = 'white_link'> ★リンク先★</a></p>
  </div>
</div>
_aaa_;

if (isset($_POST['email']) && isset($_POST['pass'])){

  #データベースに接続
  try{
    $dbh = SetDBH();
    if ($dbh == null){
      echo "接続に失敗しました。";
    }else{
      # プレースホルダーの利用
      $SQL = "SELECT * FROM user WHERE email = :email and pass = :pass";

      # プリペアードステートメント
      $stmt = $dbh->prepare($SQL);
      $stmt->execute(array(':email' => $_POST['email'], ':pass' => $_POST['pass']));
      $result = $stmt->fetch();
      $stmt = null;

      //ログイン認証ができたときの処理
      if ($result[0] != 0){
        $_SESSION['user_id'] = $result['user_id'];
        $_SESSION['user_name'] = $result['name'];
        $_SESSION['user_mail'] = $result['email'];
      //アカウント情報が間違っていたときの処理
      }else{
      $err_msg = "アカウント情報が間違っています。";
      }
    }
  }catch (PDOException $e){
    echo('エラー内容：'.$e->getMessage());
    die();
  }
  $dbh = null;
  $tmpl = $html_comp;
  if (!isset($_SESSION['path'])){
    $tmpl = str_replace("★パス★", 'index.php', $tmpl);
    $tmpl = str_replace("★リンク先★", "トップページへ", $tmpl);
  }elseif($_SESSION['path'] == 'build.php'){
    $tmpl = str_replace("★パス★", $_SESSION['path'], $tmpl);
    $tmpl = str_replace("★リンク先★", "デッキ作成ページへ", $tmpl);
  }elseif($_SESSION['path'] == 'view.php'){
    $tmpl = str_replace("★パス★", $_SESSION['path'], $tmpl);
    $tmpl = str_replace("★リンク先★", "デッキ確認ページへ", $tmpl);
  }
  unset($_SESSION['path']);

}else{
  $tmpl = $html_in;
}

$html = HTML($tmpl);
echo $html;

exit;
?>