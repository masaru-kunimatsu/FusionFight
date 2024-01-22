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
    <p class = 'white_text'><i class="fa-solid fa-angles-left"></i><a href="index.php"  class = 'white_link'> トップページ</a></p>
  </div>
</div>
_aaa_;

if (isset($_POST['email']) && isset($_POST['pass'])){

  #データベースに接続
  $dsn = 'mysql:host=localhost; dbname=fusionfight; charset=utf8';
  $user = 'testuser';
  $pass = 'testpass';

  try{
    $dbh = new PDO($dsn, $user, $pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
      $db = null;

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
  $tmpl .= $html_comp;
}else{
  $tmpl .= $html_in;
}

$file = fopen("tmpl/footer.tmpl", "r") or die("tmpl/footer.tmpl ファイルを開けませんでした。");
$size = filesize("tmpl/footer.tmpl");
$tmpl5 = fread($file, $size);
$tmpl .= $tmpl5;
fclose($file);

// セッションにユーザー名が保存されているか確認
if (isset($_SESSION['user_name'])) {
  $user_name = $_SESSION['user_name'];
  $tmpl = str_replace("★ユーザー名★", $user_name, $tmpl);
} else {
  $tmpl = str_replace("★ユーザー名★", "ゲスト", $tmpl);
}

// 画面に出力
echo $tmpl;

exit;
?>