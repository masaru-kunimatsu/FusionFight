
<?php
// セッションの開始
session_start();

include 'functions.php';

// 削除
$_SESSION['card2'] = array();
// build.php にリダイレクト
header('Location: build.php');
exit();

?>