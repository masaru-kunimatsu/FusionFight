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
      $SQL = "SELECT 
      deck.deck_id AS deck_id, 
      deck.user_id AS user_id, 
      deck.deck_name AS deck_name, 
      bgm.bgm AS bgm, 
      van_card.image AS van_image, 
      van_card.barcode AS van_barcode, 
      van_name.name AS van_name, 
      van_card.form AS van_form, 
      van_card.skill AS van_skill, 
      van_card.climax AS van_climax, 
      van_type.type AS van_type, 
      van_prog.prog AS van_prog, 
      van_rare.rare AS van_rare, 
      rear_card.image AS rear_image, 
      rear_card.barcode AS rear_barcode, 
      rear_name.name AS rear_name, 
      rear_card.form AS rear_form, 
      rear_card.skill AS rear_skill, 
      rear_card.climax AS rear_climax, 
      rear_type.type AS rear_type, 
      rear_prog.prog AS rear_prog, 
      rear_rare.rare AS rear_rare  
      FROM deck
      LEFT JOIN user on deck.user_id = user.user_id
      LEFT JOIN m_card AS van_card ON deck.van_id = van_card.card_id
      LEFT JOIN m_name AS van_name ON van_card.name_id = van_name.name_id
      LEFT JOIN m_prog AS van_prog ON van_card.prog_id = van_prog.prog_id
      LEFT JOIN m_rare AS van_rare ON van_card.rare_id = van_rare.rare_id
      LEFT JOIN m_type AS van_type ON van_card.type_id = van_type.type_id
      LEFT JOIN m_card AS rear_card ON deck.rear_id = rear_card.card_id
      LEFT JOIN m_name AS rear_name ON rear_card.name_id = rear_name.name_id
      LEFT JOIN m_prog AS rear_prog ON rear_card.prog_id = rear_prog.prog_id
      LEFT JOIN m_rare AS rear_rare ON rear_card.rare_id = rear_rare.rare_id
      LEFT JOIN m_type AS rear_type ON rear_card.type_id = rear_type.type_id
      LEFT JOIN bgm on deck.bgm_id = bgm.bgm_id
      ORDER BY deck.deck_id;";
      $stmt = $dbh->prepare($SQL);
    }

    // 表示持つ列を代入する変数を用意
    $contents = "";  //カード画像の表示
    
    # SQL文の実行
    if($stmt->execute()){
      while($row = $stmt->fetch()){

        $contents .= "<P>デッキ名</p>";
        $contents .= " {$row["deck_name"]}<br>";
        $contents .= "<P>BGM</p>";
        $contents .= " {$row["bgm"]}<br>";

        // デッキページにリンクする画像ボタンを作成
        $contents .= " <img src='{$row["van_image"]}' width='20%'><br>";
        $contents .= " <img src='{$row["van_barcode"]}' width='20%'><br>";
        $contents .= " {$row["van_name"]}<br>";
        $contents .= " {$row["van_form"]}<br>";
        $contents .= " {$row["van_skill"]}<br>";
        if ($row["van_climax"]==1) {$contents .= "<img src='CMlogo.png' width='5%'><br>";};
        $contents .= "<img src='type●{$row["van_type"]}.png' height='15px'>";
        $contents .= "<img src='logo●{$row["van_prog"]}.webp' width='15%'><br>";
        $contents .= "<img src='rare●{$row["van_rare"]}.png' height='20px'><br>";
        
        // デッキページにリンクする画像ボタンを作成
        $contents .= " <img src='{$row["rear_image"]}' width='20%'><br>";
        $contents .= " <img src='{$row["rear_barcode"]}' width='20%'><br>";
        $contents .= " {$row["rear_name"]}<br>";
        $contents .= " {$row["rear_form"]}<br>";
        $contents .= " {$row["rear_skill"]}<br>";
        if ($row["rear_climax"]==1) {$contents .= "<img src='CMlogo.png' width='5%'><br>";};
        $contents .= "<img src='type●{$row["rear_type"]}.png' height='15px'>";
        $contents .= "<img src='logo●{$row["rear_prog"]}.webp' width='15%'><br>";
        $contents .= "<img src='rare●{$row["rear_rare"]}.png' height='20px'><br>";
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
$tmpl = str_replace("★入れ替え★", $contents, $tmpl);
$tmpl = str_replace("●", "/", $tmpl);

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

