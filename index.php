<?php
session_start();

include 'functions.php';

$tmpl = GetTmpl('index');

try{
  $dbh = SetDBH();
  if ($dbh == null){
    echo "接続に失敗しました。";
  }else{
    #INSERT文の定義
    $SQL = "SELECT card_id, image FROM m_card ORDER BY RAND() LIMIT 12;";

    # プリペアードステートメント
    $stmt = $dbh->prepare($SQL);

    #SQLの実行
    $stmt->execute();
    // 結果を連想配列として取得
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // card_idをキー、imageを値とする配列を作成
    $card_image_array = [];
    foreach ($result as $row) {
      $card_id = $row['card_id'];
      $image = $row['image'];
      $card_image_array[$card_id] = $image;
    }
    // カード表示部分のHTMLを作成
    $fortune_tmpl = GetTmpl('fortune');
    $card_tmpl = "";
    foreach ($card_image_array as $k => $v) {
      $tmpl_each = $fortune_tmpl;
      $tmpl_each = str_replace("★card_id★", $k, $tmpl_each);
      $tmpl_each = str_replace("★image★", $v, $tmpl_each);
      $card_tmpl .= $tmpl_each;
    }
    $tmpl = str_replace("★image_script★", $card_tmpl, $tmpl);
  }
}catch (PDOException $e){
  echo('エラー内容：'.$e->getMessage());
  die();
}
$dbh = null;

$html = HTML($tmpl);


// 画面に出力
echo $html;

exit();

?>