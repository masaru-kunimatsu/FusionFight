

<!-- メインコンテンツ -->
<div>
  ★注意★
</div>
<div>
  １枚目のカード
  <br>
  ★1枚目★
  <br>
</div>
<div>
  <form action='change.php' method='get'>
    <button type='submit'>入れ替える</button>
  </form>
</div>
<div>
  ２枚目のカード
  <br>
  ★2枚目★
  <br>
</div>
<div>
  <form action='confirm.php' method='get'>
    <p><input type="text" name="deck_name" placeholder="デッキ名を入力してください" size="30"></p>
    <select name="bgm">
		  <option value="">BGMを選んでください</option>
      <option value=5>blackstar</option>
		</select>
    <p><a href="bgm.php">BGM登録ページへ</a></p>
    <br>
    <button type='submit'>デッキを保存する</button>
  </form>
</div>
<!-- /メインコンテンツ -->
