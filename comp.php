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
    <p class = 'white_text'><i class="fa-solid fa-angles-left"></i><a href="view.php"  class = 'white_link'> デッキ一覧ページを表示する</a></p>
  </div>
</div>
_aaa_;

$tmpl .= $html;

$file = fopen("tmpl/footer.tmpl", "r") or die("tmpl/footer.tmpl ファイルを開けませんでした。");
$size = filesize("tmpl/footer.tmpl");
$tmpl3 = fread($file, $size);
$tmpl .= $tmpl3;
fclose($file);

// セッションにユーザー名が保存されているか確認
if (isset($_SESSION['user_name'])) {
  $user_name = $_SESSION['user_name'];
  $tmpl = str_replace("★ユーザー名★", $user_name, $tmpl);
} else {
  $tmpl = str_replace("★ユーザー名★", "ゲスト", $tmpl);
}

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
    if ($_GET['mode'] === 'edit'){
      $sql = "UPDATE deck SET user_id = :user_id, deck_name = :deck_name, van_id = :van_id, rear_id = :rear_id, bgm_id = :bgm_id WHERE deck_id = :deck_id";
      $stmt = $dbh->prepare($sql);
      $stmt -> bindParam(':deck_id', $_SESSION['deck_id']);

    }else{
      #INSERT文の定義
      $sql = "INSERT INTO deck (user_id,deck_name,van_id,rear_id,bgm_id) VALUES (:user_id,:deck_name,:van_id,:rear_id,:bgm_id)";
      # プリペアードステートメント
      $stmt = $dbh->prepare($sql);
    }

    #bindParamによるパラメータ－と変数の紐付け
    $user_id = $_SESSION['user_id']; // 変数に代入
    $stmt -> bindParam(':user_id', $user_id);
    $stmt -> bindParam(':deck_name',$_GET["deck_name"]);
    $stmt -> bindParam(':van_id',$_GET["van_id"]);
    $stmt -> bindParam(':rear_id',$_GET["rear_id"]);
    $stmt -> bindParam(':bgm_id',$_GET['bgm']);

    #SQLの実行
    $stmt->execute();

    unset($_SESSION['card1']);
    unset($_SESSION['card2']);
    unset($_SESSION['deck_id']);
    unset($_SESSION['textbox']);
    unset($_SESSION['bgm_value']);
  }

}catch (PDOException $e){
  echo('エラー内容：'.$e->getMessage());
  die();
}
$dbh = null;


// 画面に出力
echo $tmpl;

exit();

?>