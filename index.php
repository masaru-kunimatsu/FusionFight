<?php

#データベースに接続
$dsn = 'mysql:host=localhost; dbname=fusionfight; charset=utf8';
$user = 'testuser';
$pass = 'testpass';

try{
  $dbh = new PDO($dsn, $user, $pass);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  if ($dbh == null){
    echo "接続に失敗しました。";
  }else{
    # プレースホルダーの利用
    $SQL = "SELECT * FROM m_card ORDER BY RAND() LIMIT 15;";

    # プリペアードステートメント
    $stmt = $dbh->prepare($SQL);

    // 表の内容を入れる変数$contentsを用意
    $contents = "";
    
    # SQL文の実行
    if($stmt->execute()){
      while($row = $stmt->fetch()){
        // 表の内容を代入
        $contents .= "<img src='{$row["image"]}' width='18%' hspace='5' vspace='5'>";
      }
    }
  }
}catch (PDOException $e){
  echo('エラー内容：'.$e->getMessage());
  die();
}
$dbh = null;

// テンプレート読み込み
$file = fopen("index_tmpl.php", "r") or die("index_tmpl.php ファイルを開けませんでした。");
$size = filesize("index_tmpl.php");
$tmpl = fread($file, $size);
fclose($file);

// 文字列置き換え
$tmpl = str_replace("★検索結果★", $contents, $tmpl);
$tmpl = str_replace("●", "/", $tmpl);

// 画面に出力
echo $tmpl;

?>

