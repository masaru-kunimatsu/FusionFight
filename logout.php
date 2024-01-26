<?php
  session_start();

  include 'functions.php';

  unset($_SESSION['user_id']);
  unset($_SESSION['user_name']);
  unset($_SESSION['user_mail']);
  header('Location: index.php');
  exit;   
?>