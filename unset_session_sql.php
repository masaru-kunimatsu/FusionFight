<?php
// セッションの開始
session_start();

// セッション変数の破棄
unset($_SESSION['sql']);
unset($_SESSION['total_count']);
$_SESSION['condition'] = array();
$_SESSION['condition2'] = array();
$_SESSION['condition3'] = array();

// リダイレクト
header('Location: search.php');
exit;
?>