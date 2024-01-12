<?php

$_GET["image"] = str_replace("●" , "/" , $_GET["image"]);
$_GET["barcode"] = str_replace("●" , "/" , $_GET["barcode"]);
echo $_GET["card_id"];
echo "<br>";
echo "<img src='{$_GET["image"]}' width='20%'>";
echo "<br>";
echo "<img src='{$_GET["barcode"]}' width='20%'>";
echo "<br>";
echo $_GET["name"];
echo "<br>";
echo $_GET["form"];
echo "<br>";
echo $_GET["skill"];
echo "<br>";
if ($_GET["climax"]==1)echo 'クライマックス';
echo "<br>";
echo $_GET["type"];
echo "<br>";
echo $_GET["prog"];
echo "<br>";
echo $_GET["rare"];



?>

