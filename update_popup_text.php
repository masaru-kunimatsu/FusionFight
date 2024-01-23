<?php
session_start();

if (!empty($_SESSION['card1']) && !empty($_SESSION['card2'])) {
    echo "これ以上保存できません";
} else {
    echo "作成中のデッキにカードを保存しました";
}
?>