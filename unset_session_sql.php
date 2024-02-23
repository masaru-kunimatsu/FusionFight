<?php
// セッションの開始
session_start();

// セッション変数の破棄
unset($_SESSION['sql']);
$_SESSION['condition'] = array();

// リダイレクト
header('Location: search.php');
exit;
?>