<?php include 'head.tmpl'; ?>
<?php include 'header.tmpl'; ?>

<!-- メインコンテンツ -->
<div class='build'>
  <div class = 'card_area' style='display: flex; justify-content;'>
    <div class='cardsheet'>
      <div class = 'deckindex'><i class="fa-solid fa-square-caret-right"></i> 1枚目
      </div>
      <div class='decksheet'>
        <div class='deckleftsheet'><img src='img/AD-002.png'>
        </div>
        <div class='deckrightsheet'>
          <div class='deckrightsheet_name'>ウルトラマンオーブ with ジャグラスジャグラー</div>
          <div class='deckrightsheet_tit'>タイプ</div>
          <div class='deckrightsheet_form'>ウルティメイトシャイニングウルトラマンゼロ</div>
          <div class='deckrightsheet_tit'>ワザ</div>
          <div class='deckrightsheet_form'>オーブスプリームカリバーオリジウムギャラクシス<img src='CMlogo.png'></div>
          <div class='deckrightsheet_bottom'>
            <img src='rare/SEC.png' >
            <img src='bcode/80.png'>
          </div>
        </div>
      </div>
    </div>
    <div class='cardsheet'>
      <div class = 'deckindex'><i class="fa-solid fa-square-caret-right"></i> 2枚目
      </div>
      <div class='decksheet'>
        <div class='deckleftsheet'><img src='img/AD-002.png'>
        </div>
        <div class='deckrightsheet'>
          <div class='deckrightsheet_name'>ウルトラマンオーブ with ジャグラスジャグラー</div>
          <div class='deckrightsheet_tit'>タイプ</div>
          <div class='deckrightsheet_form'>ウルティメイトシャイニングウルトラマンゼロ</div>
          <div class='deckrightsheet_tit'>ワザ</div>
          <div class='deckrightsheet_form'>オーブスプリームカリバーオリジウムギャラクシス<img src='CMlogo.png'></div>
          <div class='deckrightsheet_bottom'>
            <img src='rare/SEC.png' >
            <img src='bcode/80.png'>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class = 'exchange'>
    <form action='change.php' method='get'>
      <button class='exchange_button' type='submit' name='sub'>
        順番を入れかえる
        <i class="fa-solid fa-arrow-right-arrow-left"></i>
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
            <option value=5>blackstar</option>
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

