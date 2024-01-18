<?php

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
      session_start();
      $_SESSION['user_id'] = $result['user_id'];
      $_SESSION['user_name'] = $result['name'];
      header('Location: index.php');
      exit;   
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