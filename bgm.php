<?php include 'tmpl/head.tmpl'; ?>
<?php include 'tmpl/header.tmpl'; ?>

<!-- / メインナビゲーション -->
<div class="account">
  <div class="account_box">
    <form action="bgm_comp.php" method="get" class="login-form">
      <h1 class='form_tittle' >BGM登録</h1>

      <p class="form-label">BGM入力</p>
      <input id="signin-id" name="text" type="text" placeholder="登録するBGMを入力してください" size = 30>
      <br>

      <button name="login" type="submit" class="login_button">登録する</button>
    </form>
  </div>
</div>
<!-- / メインナビゲーション -->

<?php include 'tmpl/footer.tmpl'; ?>