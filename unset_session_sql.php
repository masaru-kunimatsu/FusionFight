<?php
// セッションの開始
session_start();

// セッション変数の破棄
unset($_SESSION['sql']);
$_SESSION['condition'] = array();

// セッションを破棄する場合は以下のようにします
// session_destroy();

// リダイレクト
header('Location: search.php');
exit;
?>