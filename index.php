<?php
session_start();

include 'functions.php';

$tmpl = GetTmpl('index');
$tmpl_result = GetTmpl('result');



#データベースに接続
try{
  $dbh = SetDBH();
  if ($dbh == null){
    echo "接続に失敗しました。";
  }else{
    $SQL = "SELECT * FROM m_card
    LEFT JOIN m_name on m_card.name_id = m_name.name_id
    LEFT JOIN m_type on m_card.type_id = m_type.type_id
    LEFT JOIN m_prog on m_card.prog_id = m_prog.prog_id
    LEFT JOIN m_rare on m_card.rare_id = m_rare.rare_id ";

    if ($_GET== null){
      # 検索条件の指定がない場合は全件表示
      # プレースホルダーの利用
      $SQL .= "ORDER BY m_card.card_id;";
      $stmt = $dbh->prepare($SQL);
      $stmtlist = $stmt;
    }else{
      $SQLlist = $SQL;
      $SQLlist .= " ORDER BY m_card.card_id";
      # 検索条件の指定がある場合はしぼりこみ表示
      # プレースホルダーの利用
      $SQL .= "WHERE 1 = 1"; // これは常に真となる条件を追加;

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

        $security_text = TextSecurity($_GET["text"]);
        $search_text = $security_text;
          
        $SQL .= " AND  (m_name.name LIKE '%{$search_text}%' 
                  OR   m_card.form LIKE '%{$search_text}%' 
                  OR   m_card.skill LIKE '%{$search_text}%' 
                  OR   m_type.type LIKE '%{$search_text}%' 
                  OR   m_prog.prog LIKE '%{$search_text}%' 
                  OR   m_rare.rare LIKE '%{$search_text}%')";
      }


      // ORDER BY 句の追加
      $SQL .= " ORDER BY m_card.card_id";
      $stmt = $dbh->prepare($SQL);
      $stmtlist = $dbh->prepare($SQLlist);
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

      $record_found = false;
      $card_id = "";

      while($row = $stmt->fetch()){
        // デッキページにリンクする画像ボタンを作成
        $card_id = $row['card_id'];
        $button_id = "deckAddButton".$row['card_id'];

        $tmpl_each = $tmpl_result;
        $tmpl_each = str_replace("★button_id★", $button_id, $tmpl_each);
        $tmpl_each = str_replace("★card_id★", $card_id, $tmpl_each);
        $tmpl_each = str_replace("★row['image']★", $row['image'], $tmpl_each);
        $tmpl_each = str_replace("★row['name']★", $row['name'], $tmpl_each);
        $tmpl_each = str_replace("★row['form']★", $row['form'], $tmpl_each);
        $skillValue = $row['skill']."</span>";
          if ($row['climax'] == 1) {
            $skillValue .= "<img src='material/CMlogo.png'>";
          }
        $tmpl_each = str_replace("★skillValue★", $skillValue, $tmpl_each);
        $tmpl_each = str_replace("★row['type']★", $row['type'], $tmpl_each);
        $tmpl_each = str_replace("★row['rare']★", $row['rare'], $tmpl_each);
        $tmpl_each = str_replace("★row['prog']★", $row['prog'], $tmpl_each);
        $tmpl_each = str_replace("★row['barcode']★", $row['barcode'], $tmpl_each);

        $tmpl .= $tmpl_each;

        $record_found = true;
      }

      if (!$record_found) {
        // 該当するレコードがない場合のメッセージを表示
        $tmpl_none = GetTmpl('none');
        $tmpl_none = str_replace("★該当なしのテキスト★", "該当するカードが存在しません。<br>検索条件を変更してください。", $tmpl_none);
        $tmpl .= $tmpl_none;
      }

    }
    # リスト用SQL文の実行
    if($stmtlist->execute()){
      while($row = $stmtlist->fetch()){
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

$tmpl_close = GetTmpl('index2');
$tmpl .= $tmpl_close;

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

$tmpl = str_replace("★名前リスト★", $name_list, $tmpl);
$tmpl = str_replace("★形態リスト★", $form_list, $tmpl);
$tmpl = str_replace("★分類リスト★", $type_list, $tmpl);
$tmpl = str_replace("★作品リスト★", $prog_list, $tmpl);
$tmpl = str_replace("★レアリティリスト★", $rare_list, $tmpl);

$html = HTML($tmpl);
echo $html;

?>

