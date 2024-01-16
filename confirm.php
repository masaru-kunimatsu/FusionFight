<?php
  // セッションの開始
  session_start();

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
    $card1 .= ($_SESSION["card1"]["climax"] == 1) ? 'クライマックス' : '';
    $card1 .= "<br>";
    $card1 .= $_SESSION["card1"]["type"];
    $card1 .= "<br>";
    $card1 .= $_SESSION["card1"]["prog"];
    $card1 .= "<br>";
    $card1 .= $_SESSION["card1"]["rare"];

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
    $card2 .= ($_SESSION["card2"]["climax"] == 1) ? 'クライマックス' : '';
    $card2 .= "<br>";
    $card2 .= $_SESSION["card2"]["type"];
    $card2 .= "<br>";
    $card2 .= $_SESSION["card2"]["prog"];
    $card2 .= "<br>";
    $card2 .= $_SESSION["card2"]["rare"];

    if ($_GET["deck_name"] != "") {
      // テキスト入力内容を$aにコピー
      $a = $_GET["deck_name"];

      # 文字コードをUTF-8 に統一
      $enc = mb_detect_encoding($a);
      $a = mb_convert_encoding($a, "UTF-8", $enc);

      # クロスサイトスクリプティング対策※文字コードを整えてから処理する必要がある
      $a = htmlentities($a, ENT_QUOTES, "UTF-8");

      # 改行コード処理
      $a = str_replace("\r\n", "", $a);
      $a = str_replace("\n", "", $a);
      $a = str_replace("\r", "", $a);

      $deck_name = $a;}

    if ($_GET["bgm"] != "") {
      // テキスト入力内容を$bにコピー
      $b = $_GET["bgm"];
  
      # 文字コードをUTF-8 に統一
      $enc2 = mb_detect_encoding($b);
      $b = mb_convert_encoding($b, "UTF-8", $enc2);

      # クロスサイトスクリプティング対策※文字コードを整えてから処理する必要がある
      $b = htmlentities($b, ENT_QUOTES, "UTF-8");

      # 改行コード処理
      $b = str_replace("\r\n", "", $b);
      $b = str_replace("\n", "", $b);
      $b = str_replace("\r", "", $b);

      $bgm = $b;}


// HTMLの土台を用意
$tmpl = <<<_aaa_
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>確認画面</title>
</head>
<body>
    <h1>確認画面</h1>

    <div>
      １枚目のカード
      <br>
      ★1枚目★
      <br>
    </div>
    <div>
      ２枚目のカード
      <br>
      ★2枚目★
      <br>
    </div>

    <form action="comp.php" method="get">
        <input type="hidden" name="van_id" value="{$_SESSION['card1']["card_id"]}">
        <input type="hidden" name="rear_id" value="{$_SESSION['card2']["card_id"]}">
        <input type="hidden" name="deck_name" value="{$deck_name}">
        <input type="hidden" name="bgm" value="{$bgm}">
        <input type="submit" value="登録する">
        <input type="button" value="戻る" onclick="history.back()">
    </form>
</body>
</html>
_aaa_;

// 文字列置き換え
$tmpl = str_replace("★1枚目★", $card1, $tmpl);
$tmpl = str_replace("★2枚目★", $card2, $tmpl);

// 画面に出力
echo $tmpl;

exit();
?>