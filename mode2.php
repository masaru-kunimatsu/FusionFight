
<?php
// セッションの開始
session_start();

// 削除
$_SESSION['card2'] = array();
// build.php にリダイレクト
header('Location: build.php');
exit();

?>