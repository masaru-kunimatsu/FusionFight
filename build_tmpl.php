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
<div>
  ★注意★
</div>
<div>
  １枚目のカード
  <br>
  ★1枚目★
  <br>
</div>
<div>
  <form action='change.php' method='get'>
    <button type='submit'>入れ替える</button>
  </form>
</div>
<div>
  ２枚目のカード
  <br>
  ★2枚目★
  <br>
</div>
<div>
  <form action='confirm.php' method='get'>
    <p><input type="text" name="deck_name" placeholder="デッキ名を入力してください" size="30"></p>
    <select name="bgm">
		  <option value="">BGMを選んでください</option>
      ★bgmリスト★
		</select>
    <p><a href="bgm.php">BGM登録ページへ</a></p>
    <br>
    <button type='submit'>デッキを保存する</button>
  </form>
</div>
<!-- /メインコンテンツ -->

<footer id="footer">
	<div class="inner">
  	<a href="https://dcd-ultraman.com/"><img src="img_ogp.jpg" width="20%"></a>
		<a href="https://play.google.com/store/apps/details?id=com.bandai.ultramanbinder&hl=en_US"><img src="img_apri.png" width="20%"></a>
		<a href="https://imagination.m-78.jp/"><img src="img_ti.jpg" width="20%"></a>
	</div>
</footer>

</body>
</html>

