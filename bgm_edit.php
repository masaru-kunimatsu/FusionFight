<?php

session_start();

include 'functions.php';

$html_list_head = <<<_aaa_
<!-- / メインナビゲーション -->
<div class="bgm_table_area">
<h1 class='bgm_tittle' >BGM編集・削除</h1>
  <button class='login_button' type='submit' name='sub' onclick="history.back()">
  <i class="fa-solid fa-reply"></i>
  戻る
  </button>
  <table>
_aaa_;

$html_list_contents = <<<_aaa_
  <tr>
    <td>
      ★BGM名★
    </td>
    <td>
      <form action='bgm_form.php' method='get' class='bgm_edit_button'>
        <button name='login' type='submit' class='bgm_edit_button'>編集</button>
        <input type='hidden' name='mode' value='edit'>
        <input type='hidden' name='id' value='★BGM_id★'>
        <input type='hidden' name='bgm' value='★BGM名★'>
      </form>
    </td>
    <td>
      <form action='bgm_delete.php' method='get' class='bgm_edit_button'>
        <button name='login' type='submit' class='bgm_edit_button'>削除</button>
        <input type='hidden' name='id' value='★BGM_id★'>
      </form>
    </td>
  </tr>
_aaa_;

$html_list_foot = <<<_aaa_
  </table>
</div>
_aaa_;

$html_list_none = <<<_aaa_
<!-- / メインナビゲーション -->
<div class="account">
  <h1 class='bgm_tittle' >BGM編集・削除</h1>
</div>
<!-- / メインナビゲーション -->
_aaa_;

$tmpl = $html_list_head;

# データベースに接続
  try{
    $dbh = SetDBH();
    if ($dbh == null){
      echo "接続に失敗しました。";
    }else{
      #BGMテーブルの取得
      $user_id = $_SESSION['user_id'];
      $sql = "SELECT * FROM bgm WHERE user_id = $user_id ORDER BY sort";

      # プリペアードステートメント
      $stmt = $dbh->prepare($sql);

      #SQLの実行
      $bgm_list="";
      if($stmt->execute()){
        $record_found = false;
        while($row = $stmt->fetch()){
          
          $tmpl_each = $html_list_contents;
          $tmpl_each = str_replace("★BGM名★", $row["bgm"], $tmpl_each);
          $tmpl_each = str_replace("★BGM_id★", $row["bgm_id"], $tmpl_each);
          $tmpl .= $tmpl_each;
          $record_found = true;
        }
        if (!$record_found) {
          // 該当するレコードがない場合のメッセージを表示
          $tmpl .= $html_list_none;
        }
      }
    }
  }catch (PDOException $e){
      echo('エラー内容：'.$e->getMessage());
      die();
  }

$tmpl .= $html_list_foot;

$html = HTML($tmpl);
echo $html;

exit;