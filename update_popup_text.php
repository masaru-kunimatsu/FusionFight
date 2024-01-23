<?php
session_start();

if (!empty($_SESSION['card1']) && !empty($_SESSION['card2'])) {
    echo "Both card1 and card2 are not empty.";
} else {
    echo "Content for the popup.";
}
?>