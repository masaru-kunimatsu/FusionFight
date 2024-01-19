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

    if ($_GET== null){
      # 検索条件の指定がない場合は全件表示
      # プレースホルダーの利用
      $SQL = "SELECT * FROM m_card
      LEFT JOIN m_name on m_card.name_id = m_name.name_id
      LEFT JOIN m_type on m_card.type_id = m_type.type_id
      LEFT JOIN m_prog on m_card.prog_id = m_prog.prog_id
      LEFT JOIN m_rare on m_card.rare_id = m_rare.rare_id
      ORDER BY m_card.card_id;";
      $stmt = $dbh->prepare($SQL);
    }else{
      # 検索条件の指定がある場合はしぼりこみ表示
      # プレースホルダーの利用
      $SQL = "SELECT * FROM m_card
      LEFT JOIN m_name on m_card.name_id = m_name.name_id
      LEFT JOIN m_type on m_card.type_id = m_type.type_id
      LEFT JOIN m_prog on m_card.prog_id = m_prog.prog_id
      LEFT JOIN m_rare on m_card.rare_id = m_rare.rare_id
      WHERE 1 = 1"; // これは常に真となる条件を追加;

      // 条件が指定されている場合にのみ追加
      if ($_GET["name"] != "") {
        $SQL .= " AND m_card.name_id = {$_GET["name"]}";
      }
      if ($_GET["form"] != "") {
        $SQL .= " AND m_card.form = '{$_GET["form"]}'";
      }
      if ($_GET["climax"] == 1) {
        $SQL .= " AND m_card.climax = 1";
      }
      if ($_GET["type"] != "") {
        $SQL .= " AND m_card.type_id = {$_GET["type"]}";
      }
      if ($_GET["prog"] != "") {
        $SQL .= " AND m_card.prog_id = {$_GET["prog"]}";
      }
      if ($_GET["rare"] != "") {
        $SQL .= " AND m_card.rare_id = {$_GET["rare"]}";
      }
      if ($_GET["text"] != "") {
          // テキスト入力内容を$aにコピー
          $a = $_GET["text"];
    
          # 文字コードをUTF-8 に統一
          $enc = mb_detect_encoding($a);
          $a = mb_convert_encoding($a, "UTF-8", $enc);
    
          # クロスサイトスクリプティング対策※文字コードを整えてから処理する必要がある
          $a = htmlentities($a, ENT_QUOTES, "UTF-8");
    
          # 改行コード処理
          $a = str_replace("\r\n", "", $a);
          $a = str_replace("\n", "", $a);
          $a = str_replace("\r", "", $a);
    
          $input["text"] = $a;
          
        $SQL .= " AND  (m_name.name LIKE '%{$input["text"]}%' 
                  OR   m_card.form LIKE '%{$input["text"]}%' 
                  OR   m_card.skill LIKE '%{$input["text"]}%' 
                  OR   m_type.type LIKE '%{$input["text"]}%' 
                  OR   m_prog.prog LIKE '%{$input["text"]}%' 
                  OR   m_rare.rare LIKE '%{$input["text"]}%')";
      }


      // ORDER BY 句の追加
      $SQL .= " ORDER BY m_card.card_id";
      $stmt = $dbh->prepare($SQL);
    }

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
        $contents .= "<section id='main_sheet'><form action='build.php' method='get'>";
        $contents .= "<div class='sheet'>";
        $contents .= "<div class='leftsheet'>";
        $contents .= "<img src='{$row["image"]}' height=70%;></div>";
        $contents .= "<div class='rightsheet'>";
        $contents .= "<div class='rightsheet_name'>{$row['name']}</div>";
        $contents .= "<div class='rightsheet_tit'>タイプ:<span class='rightsheet_form'><br>{$row['form']}</span></div>";
        $contents .= "<div class='rightsheet_tit'>必殺技:<span class='rightsheet_form'><br>{$row['skill']}</span>";
        $contents .= ($row["climax"] == 1) ? "<img src='CMlogo.png'><br>" : '';
        $contents .= "</div>";
        $contents .= "<div class='rightuppersheet'>";
        $contents .= "<img src='type●{$row['type']}.png' >";
        $contents .= "<img src='rare●{$row['rare']}.png' >";
        $contents .= "<img src='logo●{$row['prog']}.webp' ></div>";
        $contents .= "<div class='rightbottomsheet'>";
        $contents .= "<img src='{$row['barcode']}'>";
        $contents .= "<button class='rightbottomsheet_button' type='submit' name='sub'>";
        $contents .= "デッキに追加する <i class='fa-solid fa-forward'></i></button>";
        $contents .= "</div></div></div>";
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
        $contents .= "</form></section>";
        
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
          $type_list .= "<option value={$row["type_id"]}>{$row["type"]}</option>";
          $types[] = $row["type"]; // 配列に追加
        }
        if (!in_array($row["prog"], $progs)) {
          $prog_list .= "<option value={$row["prog_id"]}>{$row["prog"]}</option>";
          $progs[] = $row["prog"]; // 配列に追加
        }
        if (!in_array($row["rare"], $rares)) {
          $rare_list .= "<option value={$row["rare_id"]}>{$row["rare"]}</option>";
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

$file = fopen("head.tmpl", "r") or die("head.tmpl ファイルを開けませんでした。");
$size = filesize("head.tmpl");
$tmpl = fread($file, $size);
fclose($file);

$file = fopen("header.tmpl", "r") or die("header.tmpl ファイルを開けませんでした。");
$size = filesize("header.tmpl");
$tmpl2 = fread($file, $size);
$tmpl .= $tmpl2;
fclose($file);

$file = fopen("index.tmpl", "r") or die("index.tmpl ファイルを開けませんでした。");
$size = filesize("index.tmpl");
$tmpl3 = fread($file, $size);
$tmpl .= $tmpl3;
fclose($file);

$file = fopen("footer.tmpl", "r") or die("footer.tmpl ファイルを開けませんでした。");
$size = filesize("footer.tmpl");
$tmpl4 = fread($file, $size);
$tmpl .= $tmpl4;
fclose($file);

// 文字列置き換え
if ($_GET != null){
  $name_list = str_replace("<option value={$_GET["name"]}>", "<option value={$_GET["name"]} selected>", $name_list);
  $form_list = str_replace("<option value={$_GET["form"]}>", "<option value={$_GET["form"]} selected>", $form_list);
  $type_list = str_replace("<option value={$_GET["type"]}>", "<option value={$_GET["type"]} selected>", $type_list);
  $prog_list = str_replace("<option value={$_GET["prog"]}>", "<option value={$_GET["prog"]} selected>", $prog_list);
  $rare_list = str_replace("<option value={$_GET["rare"]}>", "<option value={$_GET["rare"]} selected>", $rare_list);
  if ($_GET["climax"]==1){
    $tmpl = str_replace(">クライマックス技</option>", " selected>クライマックス技</option>", $tmpl);
  }
}
$tmpl = str_replace("★検索結果★", $contents, $tmpl);
$tmpl = str_replace("●", "/", $tmpl);
$tmpl = str_replace("★名前リスト★", $name_list, $tmpl);
$tmpl = str_replace("★形態リスト★", $form_list, $tmpl);
$tmpl = str_replace("★分類リスト★", $type_list, $tmpl);
$tmpl = str_replace("★作品リスト★", $prog_list, $tmpl);
$tmpl = str_replace("★レアリティリスト★", $rare_list, $tmpl);

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

