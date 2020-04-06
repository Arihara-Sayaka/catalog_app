<?php

require_once('config.php');
require_once('functions.php');

$dbh = connectDb();
//sql文の実行 
$sql = 'SELECT * FROM trimmings';
//プリペアドステートメント
$stmt = $dbh->prepare($sql);
$stmt->execute();

//記事デーテの格納
$trimmings = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="style.css">
  <title>記事投稿フォーム</title>
</head>

<body>

  <h1>記事一覧ページ</h1>

  <?php if (count($trimmings)) : ?>
    <ul class="trimmings-list">
      <?php foreach ($trimmings as $trimming) : ?>
        <li>
          <a href="show.php?id=<?php echo h($trimming['id']) ?>"><?php echo h($trimming['title']); ?></a><br>
          <img src="../dog_picture/<?php echo h($trimming['picture']); ?>" alt="犬の写真"><br>
          <?php echo h($trimming['body']); ?><br>
          投稿日時: <?php echo h($trimming['created_at']); ?>
          <hr>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php else : ?>
    <p>投稿された記事はありません</p>
  <?php endif; ?>
</body>

</html>