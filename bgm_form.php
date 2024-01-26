<?php

session_start();

include 'functions.php';

$html_form = <<<_aaa_
<!-- / メインナビゲーション -->
<div class="account">
  <div class="account_box">
    <form action="bgm_form.php" method="get" class="login-form">
      <h1 class='form_tittle' >BGM登録</h1>
      <p class="form-label">BGM入力</p>
      <input id="signin-id" name="text" type="text" placeholder="登録するBGMを入力してください" size = 30>
      <br>
      <button name="login" type="submit" class="login_button">登録する</button>
      <input type='hidden' name='mode' value='comp'>
    </form>
  </div>
  <button class='login_button' type='submit' name='sub' onclick="history.back()">
    <i class="fa-solid fa-reply"></i>
    戻る
  </button>
</div>
<!-- / メインナビゲーション -->
_aaa_;



$html_comp = <<<_aaa_
<div class="white_bg">
  <div class="white_bg_box">
    <h1 class='white_tittle' >登録が完了しました</h1>
    ★リンク★
  </div>
</div>
_aaa_;


if(isset($_GET['mode']) && $_GET['mode'] == "edit"){

$html_edit = <<<_aaa_
<!-- / メインナビゲーション -->
<div class="account">
  <div class="account_box">
    <form action="bgm_form.php" method="get" class="login-form">
      <h1 class='form_tittle' >BGM編集</h1>
      <p class="form-label">内容を編集し 保存する を押してください</p>
      <input id="signin-id" name="text" type="text" value="{$_GET['bgm']}" size = 30>
      <br>
      <button name="login" type="submit" class="login_button">保存する</button>
      <input type='hidden' name='mode' value='edit_comp'>
      <input type='hidden' name='id' value='{$_GET['id']}'>
      <input type='hidden' name='bgm' value='{$_GET['bgm']}'>
    </form>
  </div>
  <button class='login_button' type='submit' name='sub' onclick="history.back()">
    <i class="fa-solid fa-reply"></i>
    戻る
  </button>
</div>
<!-- / メインナビゲーション -->
_aaa_;

}

if (isset($_GET['mode']) && $_GET['mode'] == "comp"){

  # データベースに接続
  try{
    $dbh = SetDBH();
    if ($dbh == null){
      echo "接続に失敗しました。";
    }else{
      #INSERT文の定義
      $sql = "INSERT INTO bgm (bgm,user_id) VALUES (:text,:user)";
      # プリペアードステートメント
      $stmt = $dbh->prepare($sql);

      #bindParamによるパラメータ－と変数の紐付け
      $stmt -> bindParam(':text',$_GET["text"]);
      $stmt -> bindParam(':user',$_SESSION['user_id']);

      #INSERTの実行
      $stmt->execute();
      $tmpl = $html_comp;
      $tmpl = str_replace("★リンク★", "<p class = 'white_text'><i class='fa-solid fa-angles-left'></i><a href='build.php'  class = 'white_link'> デッキ作成ページに戻る</a></p>", $tmpl);
    }
  }catch (PDOException $e){
    echo('エラー内容：'.$e->getMessage());
    die();
  }
  $dbh = null;
}elseif(isset($_GET['mode']) && $_GET['mode'] == "edit"){

  $html_edit = <<<_aaa_
  <!-- / メインナビゲーション -->
  <div class="account">
    <div class="account_box">
      <form action="bgm_form.php" method="get" class="login-form">
        <h1 class='form_tittle' >BGM編集</h1>
        <p class="form-label">内容を編集し 保存する を押してください</p>
        <input id="signin-id" name="edit_bgm" type="text" value="{$_GET['bgm']}" size = 30>
        <br>
        <button name="login" type="submit" class="login_button">保存する</button>
        <input type='hidden' name='mode' value='edit_comp'>
        <input type='hidden' name='id' value='{$_GET['id']}'>
        <input type='hidden' name='bgm' value='{$_GET['bgm']}'>
      </form>
    </div>
    <button class='login_button' type='submit' name='sub' onclick="history.back()">
      <i class="fa-solid fa-reply"></i>
      戻る
    </button>
  </div>
  <!-- / メインナビゲーション -->
  _aaa_;
  $tmpl = $html_edit;
  }elseif(isset($_GET['mode']) && $_GET['mode'] == "edit_comp"){
  # データベースに接続
  try{
    $dbh = SetDBH();
    if ($dbh == null){
      echo "接続に失敗しました。";
    }else{
      #UPDATE文の定義
      $sql = "UPDATE bgm SET bgm= :text WHERE bgm_id = :id";
      # プリペアードステートメント
      $stmt = $dbh->prepare($sql);

      #bindParamによるパラメータ－と変数の紐付け
      $stmt -> bindParam(':text',$_GET['edit_bgm']);
      $stmt -> bindParam(':id',$_GET['id']);

      #INSERTの実行
      $stmt->execute();
      $tmpl = $html_comp;
      $tmpl = str_replace("★リンク★", "<p class = 'white_text'><i class='fa-solid fa-angles-left'></i><a href='bgm_edit.php'  class = 'white_link'> BGM一覧ページに戻る</a></p>", $tmpl);
    }
  }catch (PDOException $e){
    echo('エラー内容：'.$e->getMessage());
    die();
  }
  $dbh = null;
}else{
  $tmpl = $html_form;
}

$html = HTML($tmpl);
echo $html;

exit;