<?php

session_start();

include 'functions.php';

// HTMLの土台を用意
$html = <<<_aaa_
<div class="white_bg">
  <div class="white_bg_box">
    <h1 class='white_tittle' >登録が完了しました</h1>
    <p class = 'white_text'><i class="fa-solid fa-angles-left"></i><a href="★パス★"  class = 'white_link'> ★リンク先★</a></p>
  </div>
</div>
_aaa_;

$tmpl = $html;

#データベースに接続
try{
  $dbh = SetDBH();
  if ($dbh == null){
    echo "接続に失敗しました。";
  }else{
    # プレースホルダーの利用
    $SQL = "INSERT INTO user (email, pass, name) VALUES (:email, :pass, :name);";

    # プリペアードステートメント
    $stmt = $dbh->prepare($SQL);
    $stmt->execute(array(':email' => $_POST['email'], ':name' => $_POST['name'], ':pass' => $_POST['pass']));
    $result = $stmt->fetch();
    $stmt = null;

    # プレースホルダーの利用
    $SQL = "SELECT * FROM user WHERE email = :email and pass = :pass";

    # プリペアードステートメント
    $stmt = $dbh->prepare($SQL);
    $stmt->execute(array(':email' => $_POST['email'], ':pass' => $_POST['pass']));
    $result = $stmt->fetch();
    $stmt = null;
    
    $_SESSION['user_id'] = $result['user_id'];
    $_SESSION['user_name'] = $result['name'];
    $_SESSION['user_mail'] = $result['email'];
  }
}catch (PDOException $e){
  echo('エラー内容：'.$e->getMessage());
  die();
}
$dbh = null;

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

$html = HTML($tmpl);
echo $html;

exit;
?>