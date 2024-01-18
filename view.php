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
      $SQL = "SELECT * FROM deck
      LEFT JOIN user on deck.user_id = user.user_id
      LEFT JOIN m_card AS van_card ON deck.van_id = van_card.card_id
      LEFT JOIN m_card AS rear_card ON deck.rear_id = rear_card.card_id
      LEFT JOIN bgm on deck.bgm_id = bgm.bgm_id
      ORDER BY deck.deck_id;";
      $stmt = $dbh->prepare($SQL);
    }

    // 表示持つ列を代入する変数を用意
    $tittle = "";
    $bgm = "";
    $contents1 = "";  //カード画像の表示
    $contents = "";  //カード画像の表示
    
    # SQL文の実行
    if($stmt->execute()){
      while($row = $stmt->fetch()){

        $contents .= "<P>デッキ名</p>";
        $contents .= " {$row["deck_name"]}<br>";
        $contents .= "<P>BGM</p>";
        $contents .= " {$row["bgm"]}<br>";

        // デッキページにリンクする画像ボタンを作成
        $contents .= " <img src='{$row["image"]}' width='20%'><br>";
        $contents .= " <img src='{$row["barcode"]}' width='20%'><br>";
        $contents .= " {$row["name"]}<br>";
        $contents .= " {$row["form"]}<br>";
        $contents .= " {$row["skill"]}<br>";
        if ($row["climax"]==1) {$contents .= "クライマックス<br>";};
        $contents .= " {$row["type"]}<br>";
        $contents .= " {$row["prog"]}<br>";
        $contents .= " {$row["rare"]}<br>";
        
        // デッキページにリンクする画像ボタンを作成
        $contents .= " <img src='{$row["image"]}' width='20%'><br>";
        $contents .= " <img src='{$row["barcode"]}' width='20%'><br>";
        $contents .= " {$row["name"]}<br>";
        $contents .= " {$row["form"]}<br>";
        $contents .= " {$row["skill"]}<br>";
        if ($row["climax"]==1) {$contents .= "クライマックス<br>";};
        $contents .= " {$row["type"]}<br>";
        $contents .= " {$row["prog"]}<br>";
        $contents .= " {$row["rare"]}<br>";
      }
    }
}catch (PDOException $e){
  echo('エラー内容：'.$e->getMessage());
  die();
}
$dbh = null;

// テンプレート読み込み
$file = fopen("view_tmpl.php", "r") or die("view_tmpl.php ファイルを開けませんでした。");
$size = filesize("view_tmpl.php");
$tmpl = fread($file, $size);
fclose($file);

// 文字列置き換え
$tmpl = str_replace("●", "/", $tmpl);
$tmpl = str_replace("★入れ替え★", $contents, $tmpl);

session_start();
// セッションにユーザー名が保存されているか確認
if (isset($_SESSION['user_name'])) {
    $user_name = $_SESSION['user_name'];
    $tmpl = str_replace("★ユーザー名★", "ようこそ、{$user_name}さん!", $tmpl);
} else {
    $tmpl = str_replace("★ユーザー名★", "ようこそ、ゲストさん!", $tmpl);
}

// 画面に出力
echo $tmpl;

?>

