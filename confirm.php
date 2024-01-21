<?php
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
    $card1 .= ($_SESSION["card1"]["climax"] == 1) ? "<img src='material/CMlogo.png' width='5%'>" : '';
    $card1 .= "<br>";
    $card1 .= "<img src='type●{$_SESSION["card1"]["type"]}.png' height='15px'>";
    $card1 .= "<br>";
    $card1 .= "<img src='logo●{$_SESSION["card1"]["prog"]}.webp' width='15%'>";
    $card1 .= "<br>";
    $card1 .= "<img src='rare●{$_SESSION["card1"]["rare"]}.png' height='20px'>";

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
    $card2 .= ($_SESSION["card2"]["climax"] == 1) ? "<img src='material/CMlogo.png' width='5%'>" : '';
    $card2 .= "<br>";
    $card2 .= "<img src='type●{$_SESSION["card2"]["type"]}.png' height='15px'>";
    $card2 .= "<br>";
    $card2 .= "<img src='logo●{$_SESSION["card2"]["prog"]}.webp' width='15%'>";
    $card2 .= "<br>";
    $card2 .= "<img src='rare●{$_SESSION["card2"]["rare"]}.png' height='20px'>";

    if (isset($_GET["deck_name"]) && $_GET["deck_name"] != "") {
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
    
        $deck_name = htmlspecialchars($a, ENT_QUOTES, "UTF-8");
    }



// HTMLの土台を用意
$tmpl = <<<_aaa_
<!DOCTYPE html>
<html dir="ltr" lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=yes, maximum-scale=1.0, minimum-scale=1.0">
  <title>ウルトラマン フュージョンファイト！ ウルトラファイル 専用サイト</title>
  <meta name="keywords" content="">
  <meta name="description" content="">
  <link rel="stylesheet" href="style.css" type="text/css" media="screen">
  <!--[if lt IE 9]>
  <script src="js/html5.js"></script>
  <script src="js/css3-mediaqueries.js"></script>
  <![endif]-->
  <script src="js/jquery1.7.2.min.js"></script>
  <script src="js/script.js"></script>
</head>

<body>

<header id="header">
  <!-- ロゴ -->
	<div class="logo">
		<a href="index.php"><img src="bnr_ultrafile.png" width="20%"><span>専用サイト</span></a>
    <p>★ユーザー名★</p>
	</div>
	<!-- / ロゴ -->
	<!-- メインナビゲーション -->
	<nav id="mainNav">
		<div class="inner">
			<a class="menu" id="menu"><span>MENU</span></a>
			<div class="panel">   
				<ul>
					<li class="active"><a href="index.php"><strong>カード検索</strong></a></li>
					<li><a href="build.php"><strong>デッキ作成</strong></a></li>
					<li><a href="view.php"><strong>デッキ確認</strong></a></li>
					<li class="last"><a href="account.php"><strong>ログイン</strong></a></li>
				</ul>   
			</div>
		</div> 
	</nav>
	<!-- / メインナビゲーション -->
</header>
<!-- メインコンテンツ -->
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
    <div>
      デッキ名
      <br>
      ★デッキ名★
      <br>
    </div>
    <div>
      BGM
      <br>
      ★BGM★
      <br>
    </div>
    <form action="comp.php" method="get">
        <input type="hidden" name="van_id" value="{$_SESSION['card1']["card_id"]}">
        <input type="hidden" name="rear_id" value="{$_SESSION['card2']["card_id"]}">
        <input type="hidden" name="deck_name" value="{$deck_name}">
        <input type="hidden" name="bgm" value="{$_GET['bgm']}">
        <input type="submit" value="登録する">
        <input type="button" value="戻る" onclick="history.back()">
    </form>
    <!-- /メインコンテンツ -->
    <footer id="footer">
      <div class="inner">
        <a href="https://dcd-ultraman.com/"><img src="material/img_ogp.jpg" width="20%"></a>
        <a href="https://play.google.com/store/apps/details?id=com.bandai.ultramanbinder&hl=en_US"><img src="material/img_apri.png" width="20%"></a>
        <a href="https://imagination.m-78.jp/"><img src="material/img_ti.jpg" width="20%"></a>
      </div>
    </footer>
</body>
</html>
_aaa_;

// 文字列置き換え
$tmpl = str_replace("★1枚目★", $card1, $tmpl);
$tmpl = str_replace("★2枚目★", $card2, $tmpl);
$tmpl = str_replace("★デッキ名★", $deck_name, $tmpl);
$tmpl = str_replace("★BGM★", $bgmValue, $tmpl);
$tmpl = str_replace("●" , "/" , $tmpl);

// セッションにユーザー名が保存されているか確認
if (isset($_SESSION['user_name'])) {
  $user_name = $_SESSION['user_name'];
  $tmpl = str_replace("★ユーザー名★", $user_name, $tmpl);
} else {
  $tmpl = str_replace("★ユーザー名★", "ゲスト", $tmpl);
}

// 画面に出力
echo $tmpl;

exit();
?>