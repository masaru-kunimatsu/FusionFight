<?php include 'head.tmpl'; ?>
<?php include 'header.tmpl'; ?>

<!-- メインコンテンツ -->
<div class='build'>
  <div class='deckalert'>
  ★注意★
  </div>
  <div class = 'card_area' style='display: flex; justify-content;'>
    <div class='cardsheet'>
      <div class = 'index_bar'>
        <div class = 'deckindex'><i class='fa-solid fa-square-caret-right'></i> 1枚目
        </div>
        <form action='mode1.php' method='get'>
          <button class='index_delete_button' type='submit' name='sub'>
            削除
            <i class="fa-solid fa-trash-can"></i>
          </button>
        </form>
      </div>

      <div class='decksheet_none'>
        <div class='decksheet_none_text'>カードを登録しよう！
          <form action='index.php' method='get'>
            <button type='submit' class='decknone_button'><i class='fa-solid fa-angles-left'></i> カードを選択する
            </button>
          </form>
        </div>
      </div>
    </div>
    <div class='cardsheet'>
      <div class = 'index_bar'>
        <div class = 'deckindex'><i class='fa-solid fa-square-caret-right'></i> 2枚目
        </div>
        <form action='mode1.php' method='get'>
          <button class='index_delete_button' type='submit' name='sub'>
            削除
            <i class="fa-solid fa-trash-can"></i>
          </button>
        </form>
      </div>

      <div class='decksheet_none'>
        <div class='decksheet_none_text'>カードを登録しよう！
          <form action='index.php' method='get'>
            <button type='submit' class='decknone_button'><i class='fa-solid fa-angles-left'></i> カードを選択する
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class = 'exchange'>
    <form action='change.php' method='get'>
      <button class='exchange_button' type='submit' name='sub'>
        順番を入れかえる
        <i class="fa-solid fa-rotate"></i>
      </button>
    </form>
  </div>
  <div class='form_area'>
    <form action='confirm.php' method='get'>
      <div>デッキ名:<input type="text" name="deck_name" placeholder="入力してください" size="30"></div>
      <div class = 'bgm_area' style='display: flex; justify-content;'>
        <div>BGM:</div>
          <select name="bgm" >
            <option value="">選択してください</option>
            ★bgmリスト★
          </select>
        </div>
      <p><a href="bgm.php">BGM登録ページはこちら<i class="fa-solid fa-angles-right"></i></a></p>
      <button class='decksave_button' type='submit' name='sub'>
        デッキを保存する
        <i class="fa-solid fa-circle-arrow-right"></i>
      </button>
    </form>
  </div>
</div>

  <!-- /メインコンテンツ -->

<?php include 'footer.tmpl'; ?>

