<?php

session_start();

include 'functions.php';
$header_tmpl = GetHeader();
$tmpl = $header_tmpl;

// HTMLの土台を用意
$html = <<<_aaa_
<div class="white_bg">
  <div class="white_bg_box">
    <h1 class='white_tittle' >登録が完了しました</h1>
    <p class = 'white_text'><i class="fa-solid fa-angles-left"></i><a href="index.php"  class = 'white_link'> トップページ</a></p>
  </div>
</div>
_aaa_;

$tmpl .= $html;

$footer_tmpl = GetFooter();
$tmpl .= $footer_tmpl;


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
    $SQL = "UPDATE user SET name = :name, email = :email, pass = :pass WHERE user_id = :user;";

    # プリペアードステートメント
    $stmt = $dbh->prepare($SQL);
    $stmt->execute(array(':email' => $_POST['email'], ':name' => $_POST['name'], ':pass' => $_POST['pass'], ':user' => $_SESSION['user_id']));
    $result = $stmt->fetch();
    $stmt = null;
    $db = null;

    $_SESSION['user_name'] = $_POST['name'];
    $_SESSION['user_mail'] = $_POST['email'];
  }
}catch (PDOException $e){
  echo('エラー内容：'.$e->getMessage());
  die();
}
$dbh = null;

echo $tmpl;

exit;
?>