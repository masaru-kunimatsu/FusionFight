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

$file = fopen("tmpl/footer.tmpl", "r") or die("tmpl/footer.tmpl ファイルを開けませんでした。");
$size = filesize("tmpl/footer.tmpl");
$tmpl3 = fread($file, $size);
$tmpl .= $tmpl3;
fclose($file);


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

// セッションにユーザー名が保存されているか確認
if (isset($_SESSION['user_name'])) {
  $user_name = $_SESSION['user_name'];
  $tmpl = str_replace("★ユーザー名★", $user_name, $tmpl);
} else {
  $tmpl = str_replace("★ユーザー名★", "ゲスト", $tmpl);
}

echo $tmpl;

exit;
?>