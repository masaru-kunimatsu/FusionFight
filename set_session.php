<?php
session_start(); // セッションを開始

include 'functions.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // POSTリクエストがある場合

    // textbox_valueが送信された場合、セッションに保存
    if (isset($_POST['textbox_value'])) {
        $_SESSION['textbox'] = $_POST['textbox_value'];
    }

    // bgm_valueが送信された場合、セッションに保存
    if (isset($_POST['bgm_value'])) {
        $_SESSION['bgm_value'] = $_POST['bgm_value'];
    }
    
} else {

}
?>