<?php

$tmpl1 = <<<_aaa_
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
_aaa_;

$tmpl2 = <<<_bbb_
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
_bbb_;

$tmpl3 = <<<_ccc_
<!-- メインコンテンツ -->
<div class="signin">
    <form action="login.php" method="POST">
        <label for="signin-id">メールアドレス</label>
        <input id="signin-id" name="email" type="text" placeholder="メールアドレスを入力">
        <br>
        <label for="signin-pass">パスワード</label>
        <input id="signin-pass" name="pass" type="text" placeholder="パスワードを入力">
        <br>
        <button name="login" type="submit">ログインする</button>
    </form>
</div>
<!-- /メインコンテンツ -->
_ccc_;

$tmpl4 = <<<_ddd_
<!-- メインコンテンツ -->
<div class="signout">
    <p><a href="logout.php">ログアウトする</a></p>
</div>
<!-- /メインコンテンツ -->
_ddd_;

$tmpl5 = <<<_eee_
<footer id="footer">
	<div class="inner">
  	<a href="https://dcd-ultraman.com/"><img src="img_ogp.jpg" width="20%"></a>
		<a href="https://play.google.com/store/apps/details?id=com.bandai.ultramanbinder&hl=en_US"><img src="img_apri.png" width="20%"></a>
		<a href="https://imagination.m-78.jp/"><img src="img_ti.jpg" width="20%"></a>
	</div>
</footer>
</body>
</html>
_eee_;

session_start();
echo $tmpl1;
// セッションにユーザー名が保存されているか確認
if (isset($_SESSION['user_name'])) {
  $user_name = $_SESSION['user_name'];
  $tmpl2 = str_replace("★ユーザー名★", "ようこそ、{$user_name}さん!", $tmpl2);
  echo $tmpl2;
  echo $tmpl4;
} else {
  $tmpl2 = str_replace("★ユーザー名★", "ようこそ、ゲストさん!", $tmpl2);
  echo $tmpl2;
  echo $tmpl3;
}
echo $tmpl5;
// 画面に出力

exit();

?>