<?php
// echo "<pre>";
// var_dump($_GET);
// echo "</pre>";

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
    $sql = "INSERT INTO deck (user_id,deck_name,van_id,rear_id,bgm_id) VALUES (:user_id,:deck_name,:van_id,:rear_id,:bgm_id)";
    # プリペアードステートメント
    $stmt = $dbh->prepare($sql);

    session_start();
    #bindParamによるパラメータ－と変数の紐付け
    $user_id = $_SESSION['user_id']; // 変数に代入
    $stmt -> bindParam(':user_id', $user_id);
    $stmt -> bindParam(':deck_name',$_GET["deck_name"]);
    $stmt -> bindParam(':van_id',$_GET["van_id"]);
    $stmt -> bindParam(':rear_id',$_GET["rear_id"]);
    $stmt -> bindParam(':bgm_id',$_GET['bgm']);

    #INSERTの実行
    $stmt->execute();
    unset($_SESSION['card1']);
    unset($_SESSION['card2']);
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
    <title>フォーム</title>
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
exit();
?>