<?php

session_start();

include 'functions.php';

// HTMLの土台を用意
$html_conf = <<< _aaa_
<!-- メインコンテンツ -->
<div class="account">
  <div class="account_box">
    <form action="account_delete.php" method="POST" class="login-form">
      <h1 class='form_tittle' >以下のアカウントを削除しますか?</h1>
      <p class="form-label" for="signin-id">ユーザーネーム</p>
      <p class="form-text" >★ユーザー名★</p>
      <br>
      <p class="form-label" for="signin-id">メールアドレス</p>
      <p class="form-text" >★ユーザーメール★</p>
      <br>
      <p class="form-label" for="signin-id">password</p>
      <p class="form-text" >(表示されません)</p>
      <br>
      <button name="submit" type="submit" class="login_button">削除する</button>
      <input type='hidden' name='mode' value='comp'>
      <input type='hidden' name='name' value='★ユーザー名★'>
      <input type='hidden' name='email' value='★ユーザーメール★'>
      <input type='hidden' name='id' value='★ユーザーid★'>
    </form>
  </div>
</div>
<!-- /メインコンテンツ -->
_aaa_;

$html_comp = <<<_aaa_
<div class="white_bg">
  <div class="white_bg_box">
    <h1 class='white_tittle' >  削除が完了しました</h1>
    <p class = 'white_text'><i class="fa-solid fa-angles-left"></i><a href="index.php" class = 'white_link'> トップページ</a></p>
  </div>
</div>
_aaa_;

if (isset($_POST['mode']) && $_POST['mode'] == "comp"){
  $tmpl = $html_comp;

  #データベースに接続
  try{
    $dbh = SetDBH();
    if ($dbh == null){
      echo "接続に失敗しました。";
    }else{
      # プレースホルダーの利用
      $SQL = "DELETE FROM user WHERE user_id = :user;";

      # プリペアードステートメント
      $stmt = $dbh->prepare($SQL);
      $stmt->execute(array(':user' => $_SESSION['user_id']));
      $stmt = null;

      unset($_SESSION['user_id']);
      unset($_SESSION['user_name']);
      unset($_SESSION['user_mail']);
    }
  }catch (PDOException $e){
    echo('エラー内容：'.$e->getMessage());
    die();
  }
  $dbh = null;
}else{
  $tmpl = $html_conf;
  $tmpl = str_replace("★ユーザー名★", $_SESSION['user_name'], $tmpl);
  $tmpl = str_replace("★ユーザーメール★", $_SESSION['user_mail'], $tmpl);
  $tmpl = str_replace("★ユーザーid★", $_SESSION['user_id'], $tmpl);
}

$html = HTML($tmpl);
echo $html;

exit;
?>