<?php include 'tmpl/head.tmpl'; ?>
<?php include 'tmpl/header.tmpl'; ?>

<!-- / メインナビゲーション -->
<div class='view_bg'>
  <div class='view_conf_bg'>
    <div class='deckindex_bgm'>
      <div class = 'deckindex'><i class='fa-solid fa-square-caret-right'></i> ★デッキ名★</div>
      <div class = 'deckbgm'><i class="fa-solid fa-music"></i> ★BGM名★</div>
    </div>
    <div class = 'card_area' style='display: flex; justify-content;'>
      <div class='cardsheet'>
        <div class='decksheet'>
          <div class='deckleftsheet'><img src='★画像1★'></div>
          <div class='deckrightsheet'>
            <div class='deckrightsheet_name'>★キャラ1★</div>
            <div class='deckrightsheet_tit'>タイプ</div>
            <div class='deckrightsheet_form'>★形態1★</div>
            <div class='deckrightsheet_tit'>ワザ</div>
            <div class='deckrightsheet_form'>★ワザ1★</div>
            <div class='deckrightsheet_bottom'>
              <img src='rare/★レア1★.png'>
              <img src='★コード1★.png'>
            </div>
          </div>
        </div>
      </div>
      <div class='cardsheet'>
        <div class='decksheet'>
          <div class='deckleftsheet'><img src='★画像2'></div>
          <div class='deckrightsheet'>
            <div class='deckrightsheet_name'>★キャラ2★</div>
            <div class='deckrightsheet_tit'>タイプ</div>
            <div class='deckrightsheet_form'>★形態2★</div>
            <div class='deckrightsheet_tit'>ワザ</div>
            <div class='deckrightsheet_form'>★ワザ2★</div>
            <div class='deckrightsheet_bottom'>
              <img src='rare/★レア2★.png'>
              <img src='★コード2★.png'>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class = 'command_bar'>
      <form action='deck_edit.php' method='get'>
        <button class='view_edit_button' type='submit' name='sub'>
        編集する
        <i class="fa-solid fa-pen-to-square"></i>
        </button>
      </form>
      <form action='deck_delete.php' method='get'>
        <button class='view_delete_button' type='submit' name='sub'>
          削除する
          <i class="fa-solid fa-trash-can"></i>
        </button>
      </form>
    </div>
  </div>
</div>
<!-- / メインナビゲーション -->

<?php include 'tmpl/footer.tmpl'; ?>

