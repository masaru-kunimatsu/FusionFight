<?php

include 'functions.php';

# データベースに接続
try{
  $dbh = SetDBH();
  if ($dbh == null){
    echo "接続に失敗しました。";
  }else{
    #DELETE文の定義
    $sql = "DELETE FROM bgm WHERE bgm_id = :bgm_id;";
    # プリペアードステートメント
    $stmt = $dbh->prepare($sql);

    #bindParamによるパラメータ－と変数の紐付け
    $stmt -> bindParam(':bgm_id',$_GET["id"]);

    #INSERTの実行
    $stmt->execute();
    header('Location: bgm_edit.php');
  }
}catch (PDOException $e){
  echo('エラー内容：'.$e->getMessage());
  die();
}
$dbh = null;