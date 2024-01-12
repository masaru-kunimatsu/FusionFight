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
    $SQL = "SELECT * FROM m_card
    LEFT JOIN m_name on m_card.name_id = m_name.name_id
    LEFT JOIN m_type on m_card.type_id = m_type.type_id
    LEFT JOIN m_prog on m_card.prog_id = m_prog.prog_id
    LEFT JOIN m_rare on m_card.rare_id = m_rare.rare_id
    ORDER BY RAND() LIMIT 15;";

    # プリペアードステートメント
    $stmt = $dbh->prepare($SQL);

    // 表の内容を入れる変数$contentsを用意
    $contents = "";
    
    # SQL文の実行
    if($stmt->execute()){
      while($row = $stmt->fetch()){
        // 表の内容を代入
        $contents .= "<form action='show.php' method='get'>";
        $contents .= "<input type='hidden' name='card_id' value='{$row["card_id"]}'>";
        $contents .= "<input type='hidden' name='image' value='{$row["image"]}'>";
        $contents .= "<input type='hidden' name='barcode' value='{$row["barcode"]}'>";
        $contents .= "<input type='hidden' name='name' value='{$row["name"]}'>";
        $contents .= "<input type='hidden' name='form' value='{$row["form"]}'>";
        $contents .= "<input type='hidden' name='skill' value='{$row["skill"]}'>";
        $contents .= "<input type='hidden' name='climax' value='{$row["climax"]}'>";
        $contents .= "<input type='hidden' name='type' value='{$row["type"]}'>";
        $contents .= "<input type='hidden' name='prog' value='{$row["prog"]}'>";
        $contents .= "<input type='hidden' name='rare' value='{$row["rare"]}'>";
        $contents .= "<input type ='image' name='submit' src='{$row["image"]}' width='18%' hspace='5' vspace='5'>";
        $contents .= "</form>";
      }
    }
  }
}catch (PDOException $e){
  echo('エラー内容：'.$e->getMessage());
  die();
}
$dbh = null;

// テンプレート読み込み
$file = fopen("index_tmpl.php", "r") or die("index_tmpl.php ファイルを開けませんでした。");
$size = filesize("index_tmpl.php");
$tmpl = fread($file, $size);
fclose($file);

// 文字列置き換え
$tmpl = str_replace("★検索結果★", $contents, $tmpl);
$tmpl = str_replace("●", "/", $tmpl);

// 画面に出力
echo $tmpl;

?>

