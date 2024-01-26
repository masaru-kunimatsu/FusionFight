
<?php

session_start();

include 'functions.php';

// 入れ替え

$data1 = $_SESSION['card1'];
$data2 = $_SESSION['card2'];
$_SESSION['card1'] = $data2;
$_SESSION['card2'] = $data1;

// build.php にリダイレクト
header('Location: build.php');
exit();

?>