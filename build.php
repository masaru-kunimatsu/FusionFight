<?php

session_start();

include 'functions.php';

// セッションにユーザー名が保存されているか確認
if (!isset($_SESSION['user_name'])) {
  $_SESSION['path'] = 'build.php';
  header('Location: account.php');
}

$tmpl = GetTmpl('build');


# データベースに接続
try{
  $dbh = SetDBH();
  if ($dbh == null){
    echo "接続に失敗しました。";
  }else{
    #BGMテーブルの取得
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM bgm WHERE user_id = $user_id ORDER BY sort";

    # プリペアードステートメント
    $stmt = $dbh->prepare($sql);

    #SQLの実行
    $stmt->execute();
  }
}catch (PDOException $e){
  echo('エラー内容：'.$e->getMessage());
  die();
}
$dbh = null;

$bgm_list="";
if($stmt->execute()){
  while($row = $stmt->fetch()){
    $bgm_list .= "<option value={$row["bgm_id"]}>{$row["bgm"]}</option>";
  }
}

$edit_flag = FALSE;
if ($_GET != NULL) {
  if (isset($_GET['mode']) && $_GET['mode'] == 'edit'){
      $_SESSION['card1_edit'] = array(
        'image' => $_GET["van_image"],
        'barcode' => $_GET["van_barcode"],
        'card_id' => $_GET["van_card_id"],
        'name' => $_GET["van_name"],
        'form' => $_GET["van_form"],
        'skill' => $_GET["van_skill"],
        'climax' => $_GET["van_climax"],
        'rare' => $_GET["van_rare"]);
      $_SESSION['card2_edit'] = array(
        'image' => $_GET["rear_image"],
        'barcode' => $_GET["rear_barcode"],
        'card_id' => $_GET["rear_card_id"],
        'name' => $_GET["rear_name"],
        'form' => $_GET["rear_form"],
        'skill' => $_GET["rear_skill"],
        'climax' => $_GET["rear_climax"],
        'rare' => $_GET["rear_rare"]);
      $_SESSION['deck_id'] = $_GET['deck_id'];
      $tmpl = str_replace("★注意★", "", $tmpl);
      $tmpl = str_replace("★デッキid★", $_SESSION['deck_id'], $tmpl);
      $edit_flag = TRUE;
  }else{
        $tmpl = str_replace("★注意★", "<i class='fa-solid fa-exclamation'></i> カードは2枚以上登録できません <i class='fa-solid fa-exclamation'></i>", $tmpl);
        $tmpl = str_replace("★デッキid★", "", $tmpl);
  }
} else {
  $tmpl = str_replace("★注意★", "", $tmpl);
  $tmpl = str_replace("★デッキid★", "", $tmpl);
}
  $contents1="";
  $contents2="";

  if($edit_flag){
    $contents1 .= "<div class='decksheet'>";
    $contents1 .= "<div class='deckleftsheet'><img src='{$_SESSION["card1_edit"]["image"]}'  class ='add_shadow' ></div>";
    $contents1 .= "<div class='deckrightsheet'>";
    $contents1 .= "<div class='deckrightsheet_name'>{$_SESSION["card1_edit"]["name"]}</div>";
    $contents1 .= "<div class='deckrightsheet_tit'>タイプ</div>";
    $contents1 .= "<div class='deckrightsheet_form'>{$_SESSION["card1_edit"]["form"]}</div>";
    $contents1 .= "<div class='deckrightsheet_tit'>ワザ</div>";
    $contents1 .= "<div class='deckrightsheet_form'>{$_SESSION["card1_edit"]["skill"]}";
    $contents1 .= ($_SESSION["card1_edit"]["climax"] == 1) ? "<img src='material/CMlogo.png'>" : '';
    $contents1 .= "</div>";
    $contents1 .= "<div class='deckrightsheet_bottom'>";
    $contents1 .= "<img src='rare●{$_SESSION["card1_edit"]["rare"]}.png'>";
    $contents1 .= "<img src='{$_SESSION["card1_edit"]["barcode"]}' class = 'add_shadow' >";
    $contents1 .= "</div></div></div>";
  }elseif (isset($_SESSION['card1']) && !empty($_SESSION['card1']['card_id'])) {
    $contents1 .= "<div class='decksheet'>";
    $contents1 .= "<div class='deckleftsheet'><img src='{$_SESSION["card1"]["image"]}'  class ='add_shadow' ></div>";
    $contents1 .= "<div class='deckrightsheet'>";
    $contents1 .= "<div class='deckrightsheet_name'>{$_SESSION["card1"]["name"]}</div>";
    $contents1 .= "<div class='deckrightsheet_tit'>タイプ</div>";
    $contents1 .= "<div class='deckrightsheet_form'>{$_SESSION["card1"]["form"]}</div>";
    $contents1 .= "<div class='deckrightsheet_tit'>ワザ</div>";
    $contents1 .= "<div class='deckrightsheet_form'>{$_SESSION["card1"]["skill"]}";
    $contents1 .= ($_SESSION["card1"]["climax"] == 1) ? "<img src='material/CMlogo.png'>" : '';
    $contents1 .= "</div>";
    $contents1 .= "<div class='deckrightsheet_bottom'>";
    $contents1 .= "<img src='rare●{$_SESSION["card1"]["rare"]}.png'>";
    $contents1 .= "<img src='{$_SESSION["card1"]["barcode"]}' class = 'add_shadow' >";
    $contents1 .= "</div></div></div>";
  }else{
    $contents1 .= "<div class='decksheet_none'>";
    $contents1 .= "<div class='decksheet_none_text'>カードを登録しよう！";
    $contents1 .= "<form action='search.php' method='get'>";
    $contents1 .= "<button type='submit' class='decknone_button'><i class='fa-solid fa-angles-left'></i> カードを選択する</button>";
    $contents1 .= "</form></div></div>";
  }

  if($edit_flag){
    $contents2 .= "<div class='decksheet'>";
    $contents2 .= "<div class='deckleftsheet'><img src='{$_SESSION["card2_edit"]["image"]}'  class ='add_shadow' ></div>";
    $contents2 .= "<div class='deckrightsheet'>";
    $contents2 .= "<div class='deckrightsheet_name'>{$_SESSION["card2_edit"]["name"]}</div>";
    $contents2 .= "<div class='deckrightsheet_tit'>タイプ</div>";
    $contents2 .= "<div class='deckrightsheet_form'>{$_SESSION["card2_edit"]["form"]}</div>";
    $contents2 .= "<div class='deckrightsheet_tit'>ワザ</div>";
    $contents2 .= "<div class='deckrightsheet_form'>{$_SESSION["card2_edit"]["skill"]}";
    $contents2 .= ($_SESSION["card2_edit"]["climax"] == 1) ? "<img src='material/CMlogo.png'>" : '';
    $contents2 .= "</div>";
    $contents2 .= "<div class='deckrightsheet_bottom'>";
    $contents2 .= "<img src='rare●{$_SESSION["card2_edit"]["rare"]}.png'>";
    $contents2 .= "<img src='{$_SESSION["card2_edit"]["barcode"]}' class = 'add_shadow' >";
    $contents2 .= "</div></div></div>";
  }elseif (isset($_SESSION['card2']) && !empty($_SESSION['card2']['card_id'])) {
    $contents2 .= "<div class='decksheet'>";
    $contents2 .= "<div class='deckleftsheet'><img src='{$_SESSION["card2"]["image"]}' class = 'add_shadow' ></div>";
    $contents2 .= "<div class='deckrightsheet'>";
    $contents2 .= "<div class='deckrightsheet_name'>{$_SESSION["card2"]["name"]}</div>";
    $contents2 .= "<div class='deckrightsheet_tit'>タイプ</div>";
    $contents2 .= "<div class='deckrightsheet_form'>{$_SESSION["card2"]["form"]}</div>";
    $contents2 .= "<div class='deckrightsheet_tit'>ワザ</div>";
    $contents2 .= "<div class='deckrightsheet_form'>{$_SESSION["card2"]["skill"]}";
    $contents2 .= ($_SESSION["card2"]["climax"] == 1) ? "<img src='material/CMlogo.png'>" : '';
    $contents2 .= "</div>";
    $contents2 .= "<div class='deckrightsheet_bottom'>";
    $contents2 .= "<img src='rare●{$_SESSION["card2"]["rare"]}.png'>";
    $contents2 .= "<img src='{$_SESSION["card2"]["barcode"]}' class = 'add_shadow' >";
    $contents2 .= "</div></div></div>";
  }else{
    $contents2 .= "<div class='decksheet_none'>";
    $contents2 .= "<div class='decksheet_none_text'>カードを登録しよう！";
    $contents2 .= "<form action='search.php' method='get'>";
    $contents2 .= "<button type='submit' class='decknone_button'><i class='fa-solid fa-angles-left'></i> カードを選択する</button>";
    $contents2 .= "</form></div></div>";
  }

// 文字列置き換え
$tmpl = str_replace("★1枚目★", $contents1, $tmpl);
$tmpl = str_replace("★2枚目★", $contents2, $tmpl);



if ($edit_flag) {
  // 編集モードの処理を行う
  $tmpl = str_replace("★初期値★", $_GET['deck_name'], $tmpl);
  $bgm_list = str_replace("<option value={$_GET["bgm_id"]}>", "<option value={$_GET["bgm_id"]} selected>", $bgm_list);
}else{

  if(isset ($_SESSION['textbox'])){
    $tmpl = str_replace("★初期値★", $_SESSION['textbox'], $tmpl);
  }else{
    $tmpl = str_replace("★初期値★", "", $tmpl);
  }

  if(isset ($_SESSION['bgm_value'])){
    $bgm_list = str_replace("<option value={$_SESSION['bgm_value']}>", "<option value={$_SESSION['bgm_value']} selected>", $bgm_list);
  }
}


$build_alert = array(
  'alert_card1'  => '1枚目のカードを選択してください',
  'alert_card2' => '2枚目のカードを選択してください',
  'alert_textbox' => 'デッキ名を入力してください',
  'alert_bgm_value' => 'BGMを選択してください'
);

$ogtext = "<div class='deckalert'></div>";

foreach ($build_alert as $n => $v){
  if(isset($_SESSION[$n]) && $_SESSION[$n] == 'alert'){
    $tmpl = str_replace($ogtext , "<div class='deckalert'><i class='fa-solid fa-triangle-exclamation'></i> ".$v." <i class='fa-solid fa-triangle-exclamation'></i></div>".$ogtext, $tmpl);
    unset($_SESSION[$n]);
  }
}

$tmpl = str_replace("★bgmリスト★", $bgm_list, $tmpl);

$html = HTML($tmpl);
echo $html;

?>