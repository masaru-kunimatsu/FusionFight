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
    ORDER BY m_card.card_id;";
    $stmt = $dbh->prepare($SQL);

    // 表示持つ列を代入する変数を用意
    $contents = "";  //カード画像の表示
    $name_list = "";
    $names = array();
    $form_list = "";
    $forms = array();
    $type_list = "";
    $types = array();
    $prog_list = "";
    $progs = array();
    $rare_list = "";
    $rares = array();
    
    # SQL文の実行
    if($stmt->execute()){
      while($row = $stmt->fetch()){
        // デッキページにリンクする画像ボタンを作成
        $contents .= "<form action='show.php' method='get'>";
        $contents .= " <img src='{$row["image"]}' width='20%'><br>";
        $contents .= " <img src='{$row["barcode"]}' width='20%'><br>";
        $contents .= " {$row["name"]}<br>";
        $contents .= " {$row["form"]}<br>";
        $contents .= " {$row["skill"]}<br>";
        if ($row["climax"]==1) {$contents .= "クライマックス<br>";};
        $contents .= " {$row["type"]}<br>";
        $contents .= " {$row["prog"]}<br>";
        $contents .= " {$row["rare"]}<br>";
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
        $contents .= "<input type='submit' name='sub' value='デッキに追加する'>";
        $contents .= "</form>";

        // リスト用に重複を排除して変数に代入
        if (!in_array($row["name_id"], $names)) {
          $name_list .= "<option value={$row["name_id"]}>{$row["name"]}</option>";
          $names[] = $row["name_id"]; // 配列に追加
        }
        if (!in_array($row["form"], $forms)) {
          $form_list .= "<option value={$row["form"]}>{$row["form"]}</option>";
          $forms[] = $row["form"]; // 配列に追加
        }
        if (!in_array($row["type"], $types)) {
          $type_list .= "<option value={$row["type"]}>{$row["type"]}</option>";
          $types[] = $row["type"]; // 配列に追加
        }
        if (!in_array($row["prog"], $progs)) {
          $prog_list .= "<option value={$row["prog"]}>{$row["prog"]}</option>";
          $progs[] = $row["prog"]; // 配列に追加
        }
        if (!in_array($row["rare"], $rares)) {
          $rare_list .= "<option value={$row["rare"]}>{$row["rare"]}</option>";
          $rares[] = $row["rare"]; // 配列に追加
        }
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
$tmpl = str_replace("★名前リスト★", $name_list, $tmpl);
$tmpl = str_replace("★形態リスト★", $form_list, $tmpl);
$tmpl = str_replace("★分類リスト★", $type_list, $tmpl);
$tmpl = str_replace("★作品リスト★", $prog_list, $tmpl);
$tmpl = str_replace("★レアリティリスト★", $rare_list, $tmpl);


// 画面に出力
echo $tmpl;

?>

