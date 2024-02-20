
<?php
// セッションの開始
session_start();

include 'functions.php';

// 削除
$_SESSION['card1'] = array();
$_SESSION['over_alert'] = "deck_leisure";
// build.php にリダイレクト
header('Location: build.php');
exit();

?>