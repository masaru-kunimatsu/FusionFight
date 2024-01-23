<?php

session_start();


if (empty($_SESSION['card1'])||empty($_SESSION['card2'])){

  # データベースに接続
  $dsn = 'mysql:host=localhost; dbname=fusionfight; charset=utf8';
  $user = 'testuser';
  $pass = 'testpass';

  $post_card_id = isset($_POST['post_card_id']) ? $_POST['post_card_id'] : null;

  try{
    $dbh = new PDO($dsn, $user, $pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if ($dbh == null){
      echo "接続に失敗しました。";
    }else{
      #INSERT文の定義
      $sql = "SELECT m_card.card_id, m_card.image, m_card.barcode, m_name.name, m_card.form, m_card.skill, m_card.climax, m_type.type, m_prog.prog, m_rare.rare FROM m_card
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

      if (empty($_SESSION['card1'])){
        $_SESSION['card1'] = array(
          'image' => $result["image"],
          'barcode' => $result["barcode"],
          'card_id' => $result["card_id"],
          'name' => $result["name"],
          'form' => $result["form"],
          'skill' => $result["skill"],
          'climax' => $result["climax"],
          'type' => $result["type"],
          'prog' => $result["prog"],
          'rare' => $result["rare"]);
      }elseif(empty($_SESSION['card2']) && ($_SESSION['card1']["card_id"] != $result["card_id"])){
        $_SESSION['card2'] = array(
          'image' => $result["image"],
          'barcode' => $result["barcode"],
          'card_id' => $result["card_id"],
          'name' => $result["name"],
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

?>