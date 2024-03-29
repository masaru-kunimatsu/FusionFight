<?php

session_start();

include 'functions.php';

$tmpl = GetTmpl('confirm');
    
if ($_GET != NULL){
  if (isset($_GET['mode']) && $_GET['mode'] == 'delete'){
    $_SESSION['card1'] = array(
      'image' => $_GET["van_image"],
      'barcode' => $_GET["van_barcode"],
      'card_id' => $_GET["van_card_id"],
      'name' => $_GET["van_name"],
      'form' => $_GET["van_form"],
      'skill' => $_GET["van_skill"],
      'climax' => $_GET["van_climax"],
      'rare' => $_GET["van_rare"]);
    $_SESSION['card2'] = array(
      'image' => $_GET["rear_image"],
      'barcode' => $_GET["rear_barcode"],
      'card_id' => $_GET["rear_card_id"],
      'name' => $_GET["rear_name"],
      'form' => $_GET["rear_form"],
      'skill' => $_GET["rear_skill"],
      'climax' => $_GET["rear_climax"],
      'rare' => $_GET["rear_rare"]);
    $_SESSION['textbox'] = $_GET["deck_name"];
    $_SESSION['bgm_value'] = $_GET['bgm'];
    $tmpl = str_replace("★アクション★", "deck_delete.php", $tmpl);
    $tmpl = str_replace("★クラス★", "conf_delete_button", $tmpl);
    $tmpl = str_replace("★テキスト★", "デッキを削除する<i class='fa-solid fa-trash-can'></i>", $tmpl);
    $tmpl = str_replace("★デッキid★", $_GET['deck_id'], $tmpl);
    $tmpl = str_replace("★モード★", "", $tmpl);
  }else{
    $tmpl = str_replace("★アクション★", "comp.php", $tmpl);
    $tmpl = str_replace("★クラス★", "conf_save_button", $tmpl);
    $tmpl = str_replace("★テキスト★", "デッキを保存する<i class='fa-solid fa-database'></i>", $tmpl);
    if (isset ($_SESSION['deck_id']) && $_SESSION['deck_id'] != null){
      $tmpl = str_replace("★モード★", "edit", $tmpl);
      $tmpl = str_replace("★デッキid★", $_SESSION['deck_id'], $tmpl);
    }else{
      $tmpl = str_replace("★モード★", "", $tmpl);
      $tmpl = str_replace("★デッキid★", "", $tmpl);
    }
  }
}

$build_alert = array(
  'alert_card1' => $_SESSION['card1'],
  'alert_card2' => $_SESSION['card2'],
  'alert_textbox' => $_SESSION['textbox'],
  'alert_bgm_value' => $_SESSION['bgm_value']
);

$redirect = false;

foreach ($build_alert as $n => $v){
  if(!isset($v) || empty($v)){
    $_SESSION[$n] = 'alert';
    $redirect = true;
  }
}

if ($redirect) {
  $redirect = false;
  header("Location: build.php");
  exit;
}

# データベースに接続

try{
  $dbh = SetDBH();
  if ($dbh == null){
    echo "接続に失敗しました。";
  }else{
    #BGMテーブルの取得
    $sql = "SELECT * FROM bgm WHERE bgm_id = :id";

    # プリペアードステートメント
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(':id' => $_GET['bgm']));
    $stmt->execute();
    // 結果の取得
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        // 取得した結果を変数に代入
        $bgmValue = $result['bgm'];
    } else {
        echo "該当するレコードが見つかりませんでした。";
    }
} 
}catch (PDOException $e){
  echo('エラー内容：'.$e->getMessage());
  die();
}
$dbh = null;

// デッキ名のテキストの処理
if (isset($_GET["deck_name"]) && $_GET["deck_name"] != "") {

    $security_text = TextSecurity($_GET["deck_name"]);
    $deck_name = $security_text;
    
}


$skillValue1 = $_SESSION['card1']['skill'];
if ($_SESSION["card1"]["climax"] == 1) {
  $skillValue1 .= "<img src='material/CMlogo.webp'>";
}

$skillValue2 = $_SESSION['card2']['skill'];
if ($_SESSION["card2"]["climax"] == 1) {
  $skillValue2 .= "<img src='material/CMlogo.webp'>";
}


// 文字列置き換え
$tmpl = str_replace("★デッキ名★", $deck_name, $tmpl);
$tmpl = str_replace("★BGM名★", $bgmValue, $tmpl);
$tmpl = str_replace("★BGMid★", $_GET['bgm'], $tmpl);

$tmpl = str_replace("★画像1★", $_SESSION['card1']['image'], $tmpl);
$tmpl = str_replace("★キャラ1★", $_SESSION['card1']['name'], $tmpl);
$tmpl = str_replace("★形態1★", $_SESSION['card1']['form'], $tmpl);
$tmpl = str_replace("★ワザ1★", $skillValue1, $tmpl);
$tmpl = str_replace("★レア1★", $_SESSION['card1']['rare'], $tmpl);
$tmpl = str_replace("★コード1★", $_SESSION['card1']['barcode'], $tmpl);
$tmpl = str_replace("★id1★", $_SESSION['card1']["card_id"], $tmpl);

$tmpl = str_replace("★画像2★", $_SESSION['card2']['image'], $tmpl);
$tmpl = str_replace("★キャラ2★", $_SESSION['card2']['name'], $tmpl);
$tmpl = str_replace("★形態2★", $_SESSION['card2']['form'], $tmpl);
$tmpl = str_replace("★ワザ2★", $skillValue2, $tmpl);
$tmpl = str_replace("★レア2★", $_SESSION['card2']['rare'], $tmpl);
$tmpl = str_replace("★コード2★", $_SESSION['card2']['barcode'], $tmpl);
$tmpl = str_replace("★id2★", $_SESSION['card2']["card_id"], $tmpl);

$html = HTML($tmpl);
echo $html;

exit();
?>