<?php

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
    $sql = "INSERT INTO bgm (bgm) VALUES (:text)";
    # プリペアードステートメント
    $stmt = $dbh->prepare($sql);

    #bindParamによるパラメータ－と変数の紐付け
    $stmt -> bindParam(':text',$_GET["text"]);

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
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>BGMの追加</title>
</head>
<body>
    <h1>完了画面</h1>
    <p>登録完了しました！</p>
    <p><a href="index.php">一覧ページへ</a></p>
</body>
</html>
_aaa_;

// 画面に出力
echo $html;
?>