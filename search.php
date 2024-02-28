<?php
session_start();

// session_destroy();

include 'functions.php';

$tmpl = GetTmpl('search_before');

$tmpl .= GetTmpl('search');

if(isset($_GET['fortune']) && ($_GET['fortune']) != ""){
  $tmpl_open = GetTmpl('result_open');
  $tmpl_result = GetTmpl('result');
  $tmpl_close = GetTmpl('result_close_image');
  $_SESSION['image_view'] = 'image';
}elseif(isset($_POST['mode']) && $_POST['mode'] == 'image'){
  $tmpl_open = GetTmpl('result_open_image');
  $tmpl_result = GetTmpl('result_image');
  $tmpl_close = GetTmpl('result_close_image');
  $_SESSION['image_view'] = 'image';
}elseif(isset($_POST['mode']) && $_POST['mode'] == 'detail'){
  $tmpl_open = GetTmpl('result_open');
  $tmpl_result = GetTmpl('result');
  $tmpl_close = GetTmpl('result_close');
  $_SESSION['image_view'] = 'detail';
}elseif(isset($_SESSION['image_view']) && $_SESSION['image_view'] == 'image'){
  $tmpl_open = GetTmpl('result_open_image');
  $tmpl_result = GetTmpl('result_image');
  $tmpl_close = GetTmpl('result_close_image');
}elseif(isset($_SESSION['image_view']) && $_SESSION['image_view'] == 'detail'){
  $tmpl_open = GetTmpl('result_open');
  $tmpl_result = GetTmpl('result');
  $tmpl_close = GetTmpl('result_close');
}else{
  $tmpl_open = GetTmpl('result_open');
  $tmpl_result = GetTmpl('result');
  $tmpl_close = GetTmpl('result_close');
  $_SESSION['image_view'] = 'detail';
}

if (!isset($_SESSION['total_count'])){
  $_SESSION['total_count'] = "";
}
if (!isset($_SESSION['count_edit'])){
  $_SESSION['count_edit'] = 5;
}
if (!isset($_SESSION['size_edit'])){
  $_SESSION['size_edit'] = 'big';
}

$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
unset($_GET['page']);

// 1ページあたりのアイテム数
if (isset($_POST['count_edit'])){
  $_SESSION['count_edit'] = $_POST['count_edit'];
}

//画像一覧のサイズ表示
if (isset($_POST['size_edit'])){
  $_SESSION['size_edit'] = $_POST['size_edit'];
  $_SESSION['image_view'] = 'image';

}

# 検索窓に用いるカラムの配列
$search_card_array = array(
  'name_id' => 'name',
  'type_id' => 'type',
  'prog_id' => 'prog',
  'rare_id' => 'rare',
  'form'    => 'form'
);

$tmpl_js = GetTmpl('search_js');

foreach($search_card_array as $n => $v){

  $tmpl_js_each = $tmpl_js;
  $tmpl_js_each = str_replace("★condition_name★", $n, $tmpl_js_each);
  $tmpl .= $tmpl_js_each;

  $n2 = $n.'2';
  $n3 = $n.'3';

  if (!isset($_SESSION['card1'])){
    $_SESSION['card1'] = array();
  }
  if (!isset($_SESSION['card2'])){
    $_SESSION['card2'] = array();
  }
  if (!isset($_SESSION['condition'])){
    $_SESSION['condition'] = array();
    $_SESSION['condition'][$n] = "";
    $_SESSION['condition']['form'] = "";
  }
  if (!isset($_SESSION['condition2'])){
    $_SESSION['condition2'] = array();
    $_SESSION['condition2'][$n] = "";
    $_SESSION['condition2']['form'] = "";
  }
  if (!isset($_SESSION['condition3'])){
    $_SESSION['condition3'] = array();
    $_SESSION['condition3'][$n] = "";
    $_SESSION['condition3']['form'] = "";
  }


  if (isset($_GET[$n])){
    if ($_GET[$n] != "" ){
      $_SESSION['condition'][$n] = $_GET[$n];
    }
    else{
      $_SESSION['condition'][$n] = "";
    }
  }
  if (isset($_GET[$n2])){
    if ($_GET[$n2] != "" && $_GET[$n2] != $_SESSION['condition'][$n]){
      $_SESSION['condition2'][$n] = $_GET[$n2];
    }
    else{
      $_SESSION['condition2'][$n] = "";
    }
  }
  if (isset($_GET[$n3])){
    if ($_GET[$n3] != "" &&  $_GET[$n3] != $_SESSION['condition'][$n] && $_GET[$n3] != $_SESSION['condition2'][$n] ){
      $_SESSION['condition3'][$n] = $_GET[$n3];
    }
    else{
      $_SESSION['condition3'][$n] = "";
    }
  }
  
  if (isset($_GET['climax']) && $_GET['climax'] != "" ) {
    $_SESSION['condition']['climax'] = $_GET['climax'];
  }elseif(isset($_GET['climax']) && $_GET['climax'] == "" ){
    $_SESSION['condition']['climax'] = 0;
  }
  if (isset($_GET['text']) && $_GET['text'] != "" ) {
    $_SESSION['condition']['text'] = $_GET['text'];
  }elseif(isset($_GET['text']) && $_GET['text'] == "" ){
    $_SESSION['condition']['text'] = "";
  }
}

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

    $SQLlist = $SQL." ORDER BY m_card.card_id";
    $stmtlist = $dbh->prepare($SQLlist);

    if(isset($_GET['fortune']) && $_GET['fortune'] != null){ 
      # fortuneカードがある場合
      $SQLfor = $SQL;
      $SQLfor .= " WHERE m_card.card_id = {$_GET['fortune']}"; 
      $SQLfor .= " ORDER BY m_card.card_id";
      $stmt = $dbh->prepare($SQLfor);
      $stmtfor = $stmt;
    }elseif(isset($_GET['tittle']) && $_GET['tittle'] != null){ 
      # ロゴからリンクした場合
      $SQLlogo = $SQL;
      $SQLlogo .= " WHERE m_prog.prog_id = {$_GET['tittle']}"; 
      $SQLlogo .= " ORDER BY m_card.card_id ";
      $_SESSION['sql'] = $SQLlogo;

      
      $sql_total = str_replace("SELECT *" , "SELECT COUNT(*)" , $SQLlogo);
      $stmt_total = $dbh->query($sql_total);
      $total_items = $stmt_total->fetchColumn();
      $_SESSION['total_count'] = $total_items;

      if($_SESSION['image_view'] == 'detail'){
        $offset = ($current_page - 1) * $_SESSION['count_edit'] ; // オフセット計算
        $SQLlogo .= " LIMIT $offset , {$_SESSION['count_edit']} ;";
      }

      $stmt = $dbh->prepare($SQLlogo);
      $stmtlogo = $stmt;
      $_SESSION['condition'] = array();
      $_SESSION['condition2'] = array();
      $_SESSION['condition3'] = array();
      $_SESSION['condition']['prog_id'] = $_GET['tittle'];
    }elseif($_GET == null){
      # 検索条件の指定がない場合
      if (isset($_SESSION['sql'])){
        $SQL = $_SESSION['sql'];
      }else{
        $_SESSION['sql'] = $SQL;
      }


      if($_SESSION['total_count'] == ""){
        $sql_total = str_replace("SELECT *" , "SELECT COUNT(*)" , $SQLlist);
        $stmt_total = $dbh->query($sql_total);
        $total_items = $stmt_total->fetchColumn();
        $_SESSION['total_count'] = $total_items;
      }

      if($_SESSION['image_view'] == 'detail'){
        $offset = ($current_page - 1) * $_SESSION['count_edit'] ; // オフセット計算
        $SQL .= " LIMIT $offset , {$_SESSION['count_edit']} ;";
      }

      $stmt = $dbh->prepare($SQL);
    }else{
      # 検索条件の指定がある場合はしぼりこみ表示
      $SQL .= " WHERE 1 = 1"; // これは常に真となる条件を追加;

      // 条件が指定されている場合にのみ追加
      foreach($search_card_array as $n => $v){
        if (isset($_SESSION['condition2'][$n]) && $_SESSION['condition2'][$n] != "" ){
          if (isset($_SESSION['condition'][$n]) && $_SESSION['condition'][$n] == "" ){
            $_SESSION['condition'][$n] = $_SESSION['condition2'][$n];
            $_SESSION['condition2'][$n] = "";
          }
        }
        if (isset($_SESSION['condition3'][$n]) && $_SESSION['condition3'][$n] != "" ){
          if (isset($_SESSION['condition'][$n]) && $_SESSION['condition'][$n] == "" ){
            $_SESSION['condition'][$n] = $_SESSION['condition3'][$n];
            $_SESSION['condition3'][$n] = "";
          }elseif(isset($_SESSION['condition2'][$n]) && $_SESSION['condition2'][$n] == "" ){
            $_SESSION['condition2'][$n] = $_SESSION['condition3'][$n];
            $_SESSION['condition3'][$n] = "";
          }
        }
      }
      foreach($search_card_array as $n => $v){
        $condition = "";
        if (isset($_SESSION['condition'][$n]) && $_SESSION['condition'][$n] != "" ){
          $condition = " AND m_card.$n = {$_SESSION['condition'][$n]}";
          $condition = str_replace($_SESSION['condition']['form'], "'".$_SESSION['condition']['form']."'", $condition);
        }
        if (isset($_SESSION['condition2'][$n]) && $_SESSION['condition2'][$n] != "" ){
          $condition = " AND m_card.$n IN({$_SESSION['condition'][$n]},{$_SESSION['condition2'][$n]})";
          $condition = str_replace($_SESSION['condition']['form'], "'".$_SESSION['condition']['form']."'", $condition);
          $condition = str_replace($_SESSION['condition2']['form'], "'".$_SESSION['condition2']['form']."'", $condition);
        }
        if (isset($_SESSION['condition3'][$n]) && $_SESSION['condition3'][$n] != "" ){
          $condition = " AND m_card.$n IN({$_SESSION['condition'][$n]},{$_SESSION['condition2'][$n]},{$_SESSION['condition3'][$n]})";
          $condition = str_replace($_SESSION['condition']['form'], "'".$_SESSION['condition']['form']."'", $condition);
          $condition = str_replace($_SESSION['condition2']['form'], "'".$_SESSION['condition2']['form']."'", $condition);

          $condition = str_replace($_SESSION['condition3']['form'], "'".$_SESSION['condition3']['form']."'", $condition);
        }

        $SQL .= $condition;
      }

      if (isset($_GET["climax"]) && $_GET["climax"] == 1) {
        $SQL .= " AND m_card.climax = 1";
      }

      if (isset($_GET["text"]) && $_GET["text"] != "") {
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
      }

      // ORDER BY 句の追加
      $SQL .= " ORDER BY m_card.card_id ";
      $_SESSION['sql'] = $SQL;


      $sql_total = str_replace("SELECT *" , "SELECT COUNT(*)" , $SQL);
      $stmt_total = $dbh->query($sql_total);
      $total_items = $stmt_total->fetchColumn();
      $_SESSION['total_count'] = $total_items;

      if($_SESSION['image_view'] == 'detail'){
        $offset = ($current_page - 1) * $_SESSION['count_edit'] ; // オフセット計算
        $SQL .= " LIMIT $offset , {$_SESSION['count_edit']} ;";
      }
      $stmt = $dbh->prepare($SQL);
    }

    $tmpl .= $tmpl_open;

    # 検索条件リスト画面用のSQL文の実行
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
          $cm_img = "<img src='material/CMlogo.webp'>";
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

    $tmpl = str_replace("★image_size★", $_SESSION['size_edit'], $tmpl);
    $tmpl = str_replace("★".$_SESSION['size_edit']."_checked★", "checked", $tmpl);
    
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
        foreach($search_card_array as $n =>$v){
          ${$v.'_list2'} = ${$v.'_list'};
          ${$v.'_list3'} = ${$v.'_list'};
        }
      }
    }
  }
}catch (PDOException $e){
  echo('エラー内容：'.$e->getMessage());
  die();
}
$dbh = null;

$tmpl .= $tmpl_close;

// 検索後に値を保持するため、クライマックスロゴ表示のための文字列置換
foreach($search_card_array as $n => $v){

  if (isset($_SESSION['condition'][$n]) && $_SESSION['condition'][$n] != "" ){
    $default = "<option value={$_SESSION['condition'][$n]}>";
    $selected = "<option value={$_SESSION['condition'][$n]} selected>";
    ${$v.'_list'} = str_replace($default, $selected, ${$v.'_list'});
  }
    if (isset($_SESSION['condition2'][$n]) && $_SESSION['condition2'][$n] != "" ){
    $default2 = "<option value={$_SESSION['condition2'][$n]}>";
    $selected2 = "<option value={$_SESSION['condition2'][$n]} selected>";
    ${$v.'_list2'} = str_replace($default2, $selected2, ${$v.'_list2'});
    $tmpl = str_replace("★".$n."_hidden2★", "", $tmpl);
  }
  if (isset($_SESSION['condition3'][$n]) && $_SESSION['condition3'][$n] != "" ){
    $default3 = "<option value={$_SESSION['condition3'][$n]}>";
    $selected3 = "<option value={$_SESSION['condition3'][$n]} selected>";
    ${$v.'_list3'} = str_replace($default3, $selected3, ${$v.'_list3'});
    $tmpl = str_replace("★".$n."_hidden3★", "", $tmpl);
  }

  $tmpl = str_replace("★".$n."_hidden2★", "hidden =".true, $tmpl);
  $tmpl = str_replace("★".$n."_hidden3★", "hidden =".true, $tmpl);
}

if (isset($_SESSION['condition']["climax"]) && $_SESSION['condition']["climax"]==1){
  $tmpl = str_replace(">クライマックス技</option>", " selected>クライマックス技</option>", $tmpl);
}

if (isset($_SESSION['condition']["text"]) && $_SESSION['condition']["text"] != ""){
  $tmpl = str_replace('value="" placeholder', "value='{$_SESSION['condition']["text"]}' placeholder", $tmpl);
}

// 取得した表示列をテンプレに入れる
foreach($search_card_array as $n =>$v){
  $tmpl = str_replace("★".$v."★", ${$v.'_list'}, $tmpl);
  $tmpl = str_replace("★".$v."2"."★", ${$v.'_list2'}, $tmpl);
  $tmpl = str_replace("★".$v."3"."★", ${$v.'_list3'}, $tmpl);
}

if ($_SESSION['image_view'] == 'detail'){

  $tmpl = str_replace("★count_edit★", $_SESSION['count_edit'], $tmpl);

  $paging = "";
  $total_pages = ceil($_SESSION['total_count'] / $_SESSION['count_edit']);

  $tmpl = str_replace("★total_pages★", $total_pages, $tmpl);

  $start_page = max(1, $current_page - 2);
  $end_page = min($total_pages, $start_page + 4);

  // 最終ページが5ページよりも前にある場合、開始ページを調整
  if ($end_page - $start_page < 4) {
    $start_page = max(1, $end_page - 4);
  }

  if ($start_page >= 2){
    $paging .= "<i class='fa-solid fa-ellipsis'></i>";
  }

  for ($i = $start_page; $i <= $end_page; $i++) {
    $isActive = ($i == $current_page) ? " isActive" : "";
    $paging .= "<li class='Pagination-Item'><a class='Pagination-Item-Link{$isActive}' href='?page={$i}'><span>{$i}</span></a></li>";
  }

  if ($total_pages-2 > $current_page ){
    $paging .= "<i class='fa-solid fa-ellipsis'></i>";
  }

  $tmpl = str_replace("★paging★", $paging, $tmpl);
}

$html = HTML($tmpl);

echo $current_page."<br>";
echo $start_page."<br>";
echo $total_pages."<br>";
echo $_SESSION['total_count']."<br>";
echo $_SESSION['count_edit']."<br>";
echo $end_page."<br>";

echo $html;
