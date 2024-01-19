<?php

session_start();

// セッションにユーザー名が保存されているか確認
if (!isset($_SESSION['user_name'])) {
    header('Location: account.php');
}

// テンプレート読み込み
$file = fopen("build_tmpl.php", "r") or die("build_tmpl.php ファイルを開けませんでした。");
$size = filesize("build_tmpl.php");
$tmpl = fread($file, $size);
fclose($file);

# データベースに接続
$dsn = 'mysql:host=localhost; dbname=fusionfight; charset=utf8';
$user = 'testuser';
$pass = 'testpass';

try{
  $dbh = new PDO($dsn, $user, $pass);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  if ($dbh == null){
    echo "接続に失敗しました。";
  }else{
    #BGMテーブルの取得
    $sql = "SELECT * FROM bgm ORDER BY bgm DESC";

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
   

if ($_GET != NULL){
  if (empty($_SESSION['card1'])){
    $_SESSION['card1'] = array(
      'image' => $_GET["image"],
      'barcode' => $_GET["barcode"],
      'card_id' => $_GET["card_id"],
      'name' => $_GET["name"],
      'form' => $_GET["form"],
      'skill' => $_GET["skill"],
      'climax' => $_GET["climax"],
      'type' => $_GET["type"],
      'prog' => $_GET["prog"],
      'rare' => $_GET["rare"]);
      $tmpl = str_replace("★注意★", "", $tmpl);
    }elseif(empty($_SESSION['card2']) && ($_SESSION['card1']["card_id"] != $_GET["card_id"])){
    $_SESSION['card2'] = array(
      'image' => str_replace("●" , "/" , $_GET["image"]),
      'barcode' => str_replace("●" , "/" , $_GET["barcode"]),
      'card_id' => $_GET["card_id"],
      'name' => $_GET["name"],
      'form' => $_GET["form"],
      'skill' => $_GET["skill"],
      'climax' => $_GET["climax"],
      'type' => $_GET["type"],
      'prog' => $_GET["prog"],
      'rare' => $_GET["rare"]);
      $tmpl = str_replace("★注意★", "", $tmpl);
    }else{
      $tmpl = str_replace("★注意★", "登録できません", $tmpl);
    }
  }else{
    $tmpl = str_replace("★注意★", "", $tmpl);
  }

  if (isset($_SESSION['card1']) && !empty($_SESSION['card1'])) {
    $card1 = "";
    $card1 .= $_SESSION['card1']["card_id"];
    $card1 .= "<br>";
    $card1 .= "<img src='{$_SESSION["card1"]["image"]}' width='20%'>";
    $card1 .= "<br>";
    $card1 .= "<img src='{$_SESSION["card1"]["barcode"]}' width='20%'>";
    $card1 .= "<br>";
    $card1 .= $_SESSION["card1"]["name"];
    $card1 .= "<br>";
    $card1 .= $_SESSION["card1"]["form"];
    $card1 .= "<br>";
    $card1 .= $_SESSION["card1"]["skill"];
    $card1 .= "<br>";
    $card1 .= ($_SESSION["card1"]["climax"] == 1) ? "<img src='CMlogo.png' width='5%'>" : '';
    $card1 .= "<br>";
    $card1 .= "<img src='type●{$_SESSION["card1"]["type"]}.png' height='15px'>";
    $card1 .= "<br>";
    $card1 .= "<img src='logo●{$_SESSION["card1"]["prog"]}.webp' width='15%'>";
    $card1 .= "<br>";
    $card1 .= "<img src='rare●{$_SESSION["card1"]["rare"]}.png' height='20px'>";
    $card1 .= "<form action='mode1.php' method='get'><button type='submit'>カードを削除する</button></form>";
  }else{
    $card1 = "カードを登録しよう！";
    $card1 .= "<form action='index.php' method='get'><button type='submit'>カードを選択する</button></form>";
  }

  if (isset($_SESSION['card2']) && !empty($_SESSION['card2'])) {
    $card2 = "";
    $card2 .= $_SESSION['card2']["card_id"];
    $card2 .= "<br>";
    $card2 .= "<img src='{$_SESSION["card2"]["image"]}' width='20%'>";
    $card2 .= "<br>";
    $card2 .= "<img src='{$_SESSION["card2"]["barcode"]}' width='20%'>";
    $card2 .= "<br>";
    $card2 .= $_SESSION["card2"]["name"];
    $card2 .= "<br>";
    $card2 .= $_SESSION["card2"]["form"];
    $card2 .= "<br>";
    $card2 .= $_SESSION["card2"]["skill"];
    $card2 .= "<br>";
    $card2 .= ($_SESSION["card2"]["climax"] == 1) ? "<img src='CMlogo.png' width='5%'>" : '';
    $card2 .= "<br>";
    $card2 .= "<img src='type●{$_SESSION["card2"]["type"]}.png' height='15px'>";
    $card2 .= "<br>";
    $card2 .= "<img src='logo●{$_SESSION["card2"]["prog"]}.webp' width='15%'>";
    $card2 .= "<br>";
    $card2 .= "<img src='rare●{$_SESSION["card2"]["rare"]}.png' height='20px'>";
    $card2 .= "<form action='mode2.php' method='get'><button type='submit'>カードを削除する</button></form>";
  }else{
    $card2 = "カードを登録しよう！";
    $card2 .= "<form action='index.php' method='get'><button type='submit'>カードを選択する</button></form>";
  }


// 文字列置き換え
$tmpl = str_replace("★1枚目★", $card1, $tmpl);
$tmpl = str_replace("★2枚目★", $card2, $tmpl);
$tmpl = str_replace("★bgmリスト★", $bgm_list, $tmpl);
$tmpl = str_replace("●" , "/" , $tmpl);


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