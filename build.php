<?php

session_start();

// セッションにユーザー名が保存されているか確認
if (!isset($_SESSION['user_name'])) {
    header('Location: account.php');
}

$file = fopen("head.tmpl", "r") or die("head.tmpl ファイルを開けませんでした。");
$size = filesize("head.tmpl");
$tmpl = fread($file, $size);
fclose($file);

$file = fopen("header.tmpl", "r") or die("header.tmpl ファイルを開けませんでした。");
$size = filesize("header.tmpl");
$tmpl2 = fread($file, $size);
$tmpl .= $tmpl2;
fclose($file);

$file = fopen("build.tmpl", "r") or die("build.tmpl ファイルを開けませんでした。");
$size = filesize("build.tmpl");
$tmpl3 = fread($file, $size);
$tmpl .= $tmpl3;
fclose($file);

$file = fopen("footer.tmpl", "r") or die("footer.tmpl ファイルを開けませんでした。");
$size = filesize("footer.tmpl");
$tmpl4 = fread($file, $size);
$tmpl .= $tmpl4;
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
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM bgm WHERE user_id = $user_id ORDER BY bgm DESC";

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
    }else{
      $tmpl = str_replace("★注意★", "<i class='fa-solid fa-exclamation'></i> カードは2枚以上登録できません <i class='fa-solid fa-exclamation'></i>", $tmpl);
    }
  }else{
    $tmpl = str_replace("★注意★", "", $tmpl);
  }

  $contents1="";
  $contents2="";

  if (isset($_SESSION['card1']) && !empty($_SESSION['card1'])) {
    $contents1 .= "<div class='decksheet'>";
    $contents1 .= "<div class='deckleftsheet'><img src='{$_SESSION["card1"]["image"]}'></div>";
    $contents1 .= "<div class='deckrightsheet'>";
    $contents1 .= "<div class='deckrightsheet_name'>{$_SESSION["card1"]["name"]}</div>";
    $contents1 .= "<div class='deckrightsheet_tit'>タイプ</div>";
    $contents1 .= "<div class='deckrightsheet_form'>{$_SESSION["card1"]["form"]}</div>";
    $contents1 .= "<div class='deckrightsheet_tit'>ワザ</div>";
    $contents1 .= "<div class='deckrightsheet_form'>{$_SESSION["card1"]["skill"]}";
    $contents1 .= ($_SESSION["card1"]["climax"] == 1) ? "<img src='CMlogo.png'>" : '';
    $contents1 .= "</div>";
    $contents1 .= "<div class='deckrightsheet_bottom'>";
    $contents1 .= "<img src='rare●{$_SESSION["card1"]["rare"]}.png'>";
    $contents1 .= "<img src='{$_SESSION["card1"]["barcode"]}'>";
    $contents1 .= "</div></div></div>";
  }else{
    $contents1 .= "<div class='decksheet_none'>";
    $contents1 .= "<div class='decksheet_none_text'>カードを登録しよう！";
    $contents1 .= "<form action='index.php' method='get'>";
    $contents1 .= "<button type='submit' class='decknone_button'><i class='fa-solid fa-angles-left'></i> カードを選択する</button>";
    $contents1 .= "</form></div></div>";
  }

  if (isset($_SESSION['card2']) && !empty($_SESSION['card2'])) {
    $contents2 .= "<div class='decksheet'>";
    $contents2 .= "<div class='deckleftsheet'><img src='{$_SESSION["card2"]["image"]}'></div>";
    $contents2 .= "<div class='deckrightsheet'>";
    $contents2 .= "<div class='deckrightsheet_name'>{$_SESSION["card2"]["name"]}</div>";
    $contents2 .= "<div class='deckrightsheet_tit'>タイプ</div>";
    $contents2 .= "<div class='deckrightsheet_form'>{$_SESSION["card2"]["form"]}</div>";
    $contents2 .= "<div class='deckrightsheet_tit'>ワザ</div>";
    $contents2 .= "<div class='deckrightsheet_form'>{$_SESSION["card2"]["skill"]}";
    $contents2 .= ($_SESSION["card2"]["climax"] == 1) ? "<img src='CMlogo.png'>" : '';
    $contents2 .= "</div>";
    $contents2 .= "<div class='deckrightsheet_bottom'>";
    $contents2 .= "<img src='rare●{$_SESSION["card2"]["rare"]}.png'>";
    $contents2 .= "<img src='{$_SESSION["card2"]["barcode"]}'>";
    $contents2 .= "</div></div></div>";
  }else{
    $contents2 .= "<div class='decksheet_none'>";
    $contents2 .= "<div class='decksheet_none_text'>カードを登録しよう！";
    $contents2 .= "<form action='index.php' method='get'>";
    $contents2 .= "<button type='submit' class='decknone_button'><i class='fa-solid fa-angles-left'></i> カードを選択する</button>";
    $contents2 .= "</form></div></div>";
  }





// 文字列置き換え
$tmpl = str_replace("★1枚目★", $contents1, $tmpl);
$tmpl = str_replace("★2枚目★", $contents2, $tmpl);
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