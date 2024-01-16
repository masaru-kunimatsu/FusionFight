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
	<div id="wrapper">
  
  <!-- コンテンツ -->
	<section id="main">
		<h1>CHECK!!</h1>

		★検索結果★

	</section>
	<!-- / コンテンツ -->

	<aside id="sidebar">
       
		<h3 class="heading">検索条件を指定</h3>
    <form action="index.php" method="get">
			<p>キャラクター</p>
			<select name="name">
				<option value="">選択してください</option>
				★名前リスト★
			</select>
			<p>形態</p>
			<select name="form">
				<option value="">選択してください</option>
				★形態リスト★
			</select>
			<p>技</p>
			<select name="climax">
				<option value="">選択してください</option>
				<option value="1">クライマックス技</option>
			</select>
			<p>分類</p>
			<select name="type">
				<option value="">選択してください</option>
				★分類リスト★
			</select>
			<p>作品</p>
			<select name="prog">
				<option value="">選択してください</option>
				★作品リスト★
			</select>
			<p>レアリティ</p>
			<select name="rare">
				<option value="">選択してください</option>
				★レアリティリスト★
			</select>
			<p>フリーワード検索</p>
			<input type="text" name="text" placeholder="キーワードを入力してください" size="30">
			<br>
			<button type='submit'>検索する</button>
		</form>
	</aside>
 
</div>
 
<footer id="footer">
	<div class="inner">
  	<a href="https://dcd-ultraman.com/"><img src="img_ogp.jpg" width="20%"></a>
		<a href="https://play.google.com/store/apps/details?id=com.bandai.ultramanbinder&hl=en_US"><img src="img_apri.png" width="20%"></a>
		<a href="https://imagination.m-78.jp/"><img src="img_ti.jpg" width="20%"></a>
	</div>
</footer>

</body>
</html>