<?php

session_start();

include 'functions.php';

// HTMLの土台を用意
$html = <<<_aaa_
<div class="white_bg">
  <div class="white_bg_box">
    <h1 class='white_tittle' >削除が完了しました</h1>
    <p class = 'white_text'><i class="fa-solid fa-angles-left"></i><a href="view.php"  class = 'white_link'> デッキ一覧ページを表示する</a></p>
  </div>
</div>
_aaa_;

$tmpl = $html;

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
    $sql = "DELETE FROM deck WHERE deck_id = :id";
    # プリペアードステートメント
    $stmt = $dbh->prepare($sql);

    #bindParamによるパラメータ－と変数の紐付け
    $stmt -> bindParam(':id',$_SESSION['deck_id']);

    #INSERTの実行
    $stmt->execute();

    unset($_SESSION['card1']);
    unset($_SESSION['card2']);
    unset($_SESSION['deck_id']);
  }

}catch (PDOException $e){
  echo('エラー内容：'.$e->getMessage());
  die();
}
$dbh = null;


$html = HTML($tmpl);
echo $html;

exit;

?>