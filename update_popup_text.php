<?php
session_start();

include 'functions.php';

if(isset($_SESSION['user_name'])){
    if (!empty($_SESSION['card1']) && !empty($_SESSION['card2'])) {
        echo "これ以上保存できません";
    } else {
        echo "作成中のデッキにカードを保存しました";
    }
}else{
    echo "デッキ作成にはログインが必要です";
}


?>