<?php
session_start();

include 'functions.php';

$tmpl = GetTmpl('search');
$tmpl_result = GetTmpl('result');

if (!isset($_SESSION['card1'])){
  $_SESSION['card1'] = array();
}
if (!isset($_SESSION['card2'])){
  $_SESSION['card2'] = array();
}
# 検索窓に用いるカラムの配列
$search_card_array = array(
  'name_id' => 'name',
  'type_id' => 'type',
  'prog_id' => 'prog',
  'rare_id' => 'rare',
  'form'    => 'form'
);

#データベースに接続
try{
  $dbh = SetDBH();
  if ($dbh == null){
    echo "接続に失敗しました。";
  }else{

    #SQL文を作成
    $SQL = "SELECT * FROM m_card
    LEFT JOIN m_name on m_card.name_id = m_name.name_id
    LEFT JOIN m_type on m_card.type_id = m_type.type_id
    LEFT JOIN m_prog on m_card.prog_id = m_prog.prog_id
    LEFT JOIN m_rare on m_card.rare_id = m_rare.rare_id ";

    if(isset($_POST['fortune']) && $_POST['fortune'] != null){ 
      # fortuneカードがある場合
      $SQLlist = $SQL;
      $SQLlist .= " ORDER BY m_card.card_id";
      $SQLfor = $SQL;
      $SQLfor .= " WHERE m_card.card_id = {$_POST['fortune']}"; 
      $SQLfor .= " ORDER BY m_card.card_id";
      $stmt = $dbh->prepare($SQLfor);
      $stmtfor = $stmt;
      $stmtlist = $dbh->prepare($SQLlist);
    }elseif($_GET== null){
      # 検索条件の指定がない場合は全件表示
      $SQL .= "ORDER BY m_card.card_id;";
      $stmt = $dbh->prepare($SQL);
      $stmtlist = $stmt;
    }else{
      # 検索条件の指定がある場合はしぼりこみ表示
      $SQLlist = $SQL;
      $SQLlist .= " ORDER BY m_card.card_id";
      $SQL .= "WHERE 1 = 1"; // これは常に真となる条件を追加;

      // 条件が指定されている場合にのみ追加
      foreach($search_card_array as $n => $v){
        if (isset($_GET[$n]) && $_GET[$n] != "" ) {
          $condition = " AND m_card.$n = {$_GET[$n]}";
          $SQL .= $condition;
        }
      }
      $SQL = str_replace($_GET['form'], "'".$_GET['form']."'", $SQL);
      if ($_GET["climax"] == 1) {
        $SQL .= " AND m_card.climax = 1";
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
      if (isset($_GET['fortune_card_id'])) {
        $SQL .= " AND m_card.card_id = {$_GET['fortune_card_id']}";
        echo $SQL;
      }

      // ORDER BY 句の追加
      $SQL .= " ORDER BY m_card.card_id";
      $stmt = $dbh->prepare($SQL);
      $stmtlist = $dbh->prepare($SQLlist);
    }
    
    # 検索結果画面用のSQL文の実行
    if(isset($_POST['fortune']) && $_POST['fortune'] != null){ 
      $stmtfor->execute();

      // カード表示画面に値を渡す
      while($row = $stmt->fetch()){
        $tmpl_each = $tmpl_result;

        $card_column_array = array(
          'card_id',
          'image',
          'barcode',
          'name',
          'form',
          'skill',
          'climax',
          'type',
          'rare',
          'prog',
        );
        
        foreach($card_column_array as $n){
          $tmpl_each = str_replace("★".$n."★", $row[$n], $tmpl_each);
        }
        if ($row['climax'] == 1) {
          $cm_img = "<img src='material/CMlogo.png'>";
          $tmpl_each = str_replace("★cm_img★", $cm_img, $tmpl_each);
        }else{
          $tmpl_each = str_replace("★cm_img★", "", $tmpl_each);
        }
        $tmpl .= $tmpl_each;
      }

    }else{
      if($stmt->execute()){
        $record_found = false;
        $card_id = "";

        // カード表示画面に値を渡す
        while($row = $stmt->fetch()){
          $tmpl_each = $tmpl_result;

          $card_column_array = array(
            'card_id',
            'image',
            'barcode',
            'name',
            'form',
            'skill',
            'climax',
            'type',
            'rare',
            'prog',
          );
          
          foreach($card_column_array as $n){
            $tmpl_each = str_replace("★".$n."★", $row[$n], $tmpl_each);
          }
          if ($row['climax'] == 1) {
            $cm_img = "<img src='material/CMlogo.png'>";
            $tmpl_each = str_replace("★cm_img★", $cm_img, $tmpl_each);
          }else{
            $tmpl_each = str_replace("★cm_img★", "", $tmpl_each);
          }
          $tmpl .= $tmpl_each;
          $record_found = true;
        }
        // 該当するレコードがない場合のメッセージを表示
        if (!$record_found) {
          $tmpl_none = GetTmpl('none');
          $tmpl_none = str_replace("★該当なしのテキスト★", "該当するカードが存在しません。<br>検索条件を変更してください。", $tmpl_none);
          $tmpl .= $tmpl_none;
        }
      }
    }
    // 表示列を代入する変数を用意
    foreach($search_card_array as $n =>$v){
      ${$v.'_list'} = "";
      ${$v.'s'} = array();
    }
    # リスト用SQL文の実行
    if($stmtlist->execute()){
      while($row = $stmtlist->fetch()){
        # リストを作成
        foreach($search_card_array as $n =>$v){
          if (!in_array($row[$n], ${$v.'s'})){
            ${$v.'_list'}  .= "<option value={$row[$n]}>{$row[$v]}</option>";
            ${$v.'s'}[] = $row[$n]; // 配列に追加
          }
        }
      }
    }
  }
}catch (PDOException $e){
  echo('エラー内容：'.$e->getMessage());
  die();
}
$dbh = null;

$tmpl_close = GetTmpl('search2');
$tmpl .= $tmpl_close;

// 検索後に値を保持するため、クライマックスロゴ表示のための文字列置換
if ($_GET != null){
  foreach($search_card_array as $n =>$v){
    $default = "<option value={$_GET[$n]}>";
    $selected = "<option value={$_GET[$n]} selected>";
    ${$v.'_list'} = str_replace($default, $selected, ${$v.'_list'});
  }

  if ($_GET["climax"]==1){
    $tmpl = str_replace(">クライマックス技</option>", " selected>クライマックス技</option>", $tmpl);
  }

  if ($_GET["text"] != ""){
    $tmpl = str_replace('value="" placeholder', "value='{$_GET["text"]}' placeholder", $tmpl);
  }
}

// 取得した表示列をテンプレに入れる
foreach($search_card_array as $n =>$v){
  $tmpl = str_replace("★".$v."★", ${$v.'_list'}, $tmpl);
}

$html = HTML($tmpl);
echo $html;