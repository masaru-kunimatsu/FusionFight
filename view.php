<?php

session_start();

include 'functions.php';

// セッションにユーザー名が保存されているか確認
if (!isset($_SESSION['user_name'])) {
  $_SESSION['path'] = 'view.php';
  header('Location: account.php');
}

$tmpl = "<div class='view_bg'>";

$tmpl_view = GetTmpl('view');

#データベースに接続
try{
  $dbh = SetDBH();
  if ($dbh == null){
    echo "接続に失敗しました。";
  }else{
      # プレースホルダーの利用
      $SQL = "SELECT 
      deck.deck_id AS deck_id, 
      deck.user_id AS user_id, 
      deck.deck_name AS deck_name, 
      bgm.bgm_id AS bgm_id, 
      bgm.bgm AS bgm, 
      van_card.card_id AS van_card_id, 
      van_card.image AS van_image, 
      van_card.barcode AS van_barcode, 
      van_name.name AS van_name, 
      van_card.form AS van_form, 
      van_card.skill AS van_skill, 
      van_card.climax AS van_climax, 
      van_type.type AS van_type, 
      van_prog.prog AS van_prog, 
      van_rare.rare AS van_rare, 
      rear_card.card_id AS rear_card_id, 
      rear_card.image AS rear_image, 
      rear_card.barcode AS rear_barcode, 
      rear_name.name AS rear_name, 
      rear_card.form AS rear_form, 
      rear_card.skill AS rear_skill, 
      rear_card.climax AS rear_climax, 
      rear_type.type AS rear_type, 
      rear_prog.prog AS rear_prog, 
      rear_rare.rare AS rear_rare  
      FROM deck
      LEFT JOIN user on deck.user_id = user.user_id
      LEFT JOIN m_card AS van_card ON deck.van_id = van_card.card_id
      LEFT JOIN m_name AS van_name ON van_card.name_id = van_name.name_id
      LEFT JOIN m_prog AS van_prog ON van_card.prog_id = van_prog.prog_id
      LEFT JOIN m_rare AS van_rare ON van_card.rare_id = van_rare.rare_id
      LEFT JOIN m_type AS van_type ON van_card.type_id = van_type.type_id
      LEFT JOIN m_card AS rear_card ON deck.rear_id = rear_card.card_id
      LEFT JOIN m_name AS rear_name ON rear_card.name_id = rear_name.name_id
      LEFT JOIN m_prog AS rear_prog ON rear_card.prog_id = rear_prog.prog_id
      LEFT JOIN m_rare AS rear_rare ON rear_card.rare_id = rear_rare.rare_id
      LEFT JOIN m_type AS rear_type ON rear_card.type_id = rear_type.type_id
      LEFT JOIN bgm on deck.bgm_id = bgm.bgm_id
      WHERE deck.user_id = :user
      ORDER BY deck.sort;";

      $stmt = $dbh->prepare($SQL);

      $stmt -> bindParam(':user',$_SESSION['user_id']);
    }

    
    # SQL文の実行
    if($stmt->execute()){

      $record_found = false;

      while($row = $stmt->fetch()){

        $tmpl_each = $tmpl_view;
        $tmpl_each = str_replace("★デッキid★", $row["deck_id"], $tmpl_each);
        $tmpl_each = str_replace("★デッキ名★", $row["deck_name"], $tmpl_each);
        $tmpl_each = str_replace("★BGM名★", $row["bgm"], $tmpl_each);
        $tmpl_each = str_replace("★BGMid★", $row["bgm_id"], $tmpl_each);
        

        $tmpl_each = str_replace("★id1★", $row["van_card_id"], $tmpl_each);
        $tmpl_each = str_replace("★画像1★", $row["van_image"], $tmpl_each);
        $tmpl_each = str_replace("★キャラ1★", $row["van_name"], $tmpl_each);
        $tmpl_each = str_replace("★形態1★", $row["van_form"], $tmpl_each);
        $tmpl_each = str_replace("★必殺1★", $row["van_skill"], $tmpl_each);
        $tmpl_each = str_replace("★CM1★", $row["van_climax"], $tmpl_each);

        $skillValue1 = $row["van_skill"];
          if ($row["van_climax"] == 1) {
            $skillValue1 .= "<img src='material/CMlogo.webp'>";
          }
        $tmpl_each = str_replace("★ワザ1★", $skillValue1, $tmpl_each);
        $tmpl_each = str_replace("★レア1★", $row["van_rare"], $tmpl_each);
        $tmpl_each = str_replace("★コード1★", $row["van_barcode"], $tmpl_each);
        
        $tmpl_each = str_replace("★id2★", $row["rear_card_id"], $tmpl_each);
        $tmpl_each = str_replace("★画像2★", $row["rear_image"], $tmpl_each);
        $tmpl_each = str_replace("★キャラ2★", $row["rear_name"], $tmpl_each);
        $tmpl_each = str_replace("★形態2★", $row["rear_form"], $tmpl_each);
        $tmpl_each = str_replace("★必殺2★", $row["rear_skill"], $tmpl_each);
        $tmpl_each = str_replace("★CM2★", $row["rear_climax"], $tmpl_each);

        $skillValue2 = $row["rear_skill"];
          if ($row["rear_climax"] == 1) {
            $skillValue2 .= "<img src='material/CMlogo.webp'>";
          }
        $tmpl_each = str_replace("★ワザ2★", $skillValue2, $tmpl_each);
        $tmpl_each = str_replace("★レア2★", $row["rear_rare"], $tmpl_each);
        $tmpl_each = str_replace("★コード2★", $row["rear_barcode"], $tmpl_each);

        $tmpl .= $tmpl_each;
        $record_found = true;
      }

      if (!$record_found) {
        // 該当するレコードがない場合のメッセージを表示
        $tmpl_none = GetTmpl('none');
        $tmpl_none = str_replace("★該当なしのテキスト★", "デッキが登録されていません<p class = 'white_text'><i class='fa-solid fa-angles-left'></i><a href='build.php'  class = 'none_link'> デッキの作成はこちらから</a></p>", $tmpl_none);
        $tmpl .= $tmpl_none;
      }
    }
}catch (PDOException $e){
  echo('エラー内容：'.$e->getMessage());
  die();
}
$dbh = null;

$tmpl .="</div>";

$html = HTML($tmpl);
echo $html;

?>

