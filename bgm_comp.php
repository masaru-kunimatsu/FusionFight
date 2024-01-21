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

# データベースに接続
$dsn = 'mysql:host=localhost; dbname=fusionfight; charset=utf8';
$user = 'testuser';
$pass = 'testpass';

try{
  $dbh = new PDO($dsn, $user, $pass);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
    echo("BGMを追加しました。");
  }
}catch (PDOException $e){
  echo('エラー内容：'.$e->getMessage());
  die();
}
$dbh = null;

// HTMLの土台を用意
$html = <<<_aaa_
<div class="white_bg">
  <div class="white_bg_box">
    <h1 class='white_tittle' >登録が完了しました</h1>
    <p class = 'white_text'><i class="fa-solid fa-angles-left"></i><a href="build.php"  class = 'white_link'> デッキ作成ページに戻る</a></p>
  </div>
</div>
_aaa_;

$tmpl .= $html;

$file = fopen("tmpl/footer.tmpl", "r") or die("tmpl/footer.tmpl ファイルを開けませんでした。");
$size = filesize("tmpl/footer.tmpl");
$tmpl3 = fread($file, $size);
$tmpl .= $tmpl3;
fclose($file);


// 画面に出力
echo $tmpl;

exit;
?>