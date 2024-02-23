<?php

session_start();

include 'functions.php';

$post_card_id = isset($_POST['post_card_id']) ? $_POST['post_card_id'] : null;

$session_array = array(
  'image' ,
  'barcode',
  'card_id',
  'name',
  'name_id',
  'form',
  'skill',
  'climax',
  'type',
  'prog',
  'rare'
);

$card1_get = false;
$card2_get = false;
$Duplication = false;

if (empty($_SESSION['card1']) || empty($_SESSION['card2'])) {

    # データベースに接続
    try{
      $dbh = SetDBH();
      if ($dbh == null){
        echo "接続に失敗しました。";
      }else{
        #INSERT文の定義
        $sql = "SELECT * FROM m_card
        LEFT JOIN m_name on m_card.name_id = m_name.name_id
        LEFT JOIN m_type on m_card.type_id = m_type.type_id
        LEFT JOIN m_prog on m_card.prog_id = m_prog.prog_id
        LEFT JOIN m_rare on m_card.rare_id = m_rare.rare_id
        WHERE m_card.card_id = :id;";

        # プリペアードステートメント
        $stmt = $dbh->prepare($sql);

        #bindParamによるパラメータ－と変数の紐付け
        $stmt -> bindParam(':id',$post_card_id);

        #INSERTの実行
        $stmt->execute();
        $result = $stmt->fetch();

        if(!isset($_SESSION['user_name'])){
          $card1_get = true;
        }elseif(empty($_SESSION['card1'])){
          if(empty($_SESSION['card2'])){
              $card1_get = true;
          }elseif($_SESSION['card2']["name_id"] != $result["name_id"]){
              $card1_get = true;
          }else{
              $Duplication = true;
          }
        }elseif(empty($_SESSION['card2'])){
          if(empty($_SESSION['card1'])){
              $card2_get = true;
          }elseif($_SESSION['card1']["name_id"] != $result["name_id"]){
              $card2_get = true;
          }else{
            $Duplication = true;
          }
        }
        if ($card1_get){
          $_SESSION['card1'] = array(
            'image' => $result["image"],
            'barcode' => $result["barcode"],
            'card_id' => $result["card_id"],
            'name' => $result["name"],
            'name_id' => $result["name_id"],
            'form' => $result["form"],
            'skill' => $result["skill"],
            'climax' => $result["climax"],
            'type' => $result["type"],
            'prog' => $result["prog"],
            'rare' => $result["rare"]);
        }
        if ($card2_get){
          $_SESSION['card2'] = array(
            'image' => $result["image"],
            'barcode' => $result["barcode"],
            'card_id' => $result["card_id"],
            'name' => $result["name"],
            'name_id' => $result["name_id"],
            'form' => $result["form"],
            'skill' => $result["skill"],
            'climax' => $result["climax"],
            'type' => $result["type"],
            'prog' => $result["prog"],
            'rare' => $result["rare"]);
        }
      }
    }catch (PDOException $e){
      echo('エラー内容：'.$e->getMessage());
      die();
    }
    $dbh = null;
}

if (isset($_SESSION['user_name'])) {
  $link = "デッキ作成画面に進む <i class='fa-solid fa-forward'></i>";
  if ($Duplication) {
    $state = "同じキャラクター同士ではデッキを作成できません";
  } elseif (empty($_SESSION['card1']) || empty($_SESSION['card2'])) {
    $_SESSION['over_alert'] = "deck_leisure";
    $state = "作成中のデッキにカードを保存しました";
  } elseif ($_SESSION['over_alert'] == "deck_leisure") {
    $_SESSION['over_alert'] = "deck_stress";
    $state = "作成中のデッキにカードを保存しました";
  } elseif ($_SESSION['over_alert'] == "deck_stress") {
    $state = "カードがすでに2枚登録されています";
  }
} else {
  $state = "デッキ作成にはログインが必要です";
  $link = "ログイン画面に進む <i class='fa-solid fa-forward'></i>";
}

echo json_encode(array("state" => $state, "link" => $link));
?>