<?php

require_once('config.php');
require_once('functions.php');

$id = $_GET['id'];

$dbh = connectDb();

$sql1 = <<<SQL
SELECT
  t.*,
  d.name
FROM
  trimmings t
LEFT JOIN
  dogbreed d
ON
  t.dogbreed_id = d.id
WHERE
  t.id = :id
SQL;

$stmt1 = $dbh->prepare($sql1);
$stmt1->bindParam(':id', $id, PDO::PARAM_INT);
$stmt1->execute();
$trimming = $stmt1->fetch(PDO::FETCH_ASSOC);

$sql2 = <<<SQL
SELECT
  r.*,
FROM
  reviews r
ORDER BY
  updated_at
DESC
SQL;

$stmt2 = $dbh->prepare($sql2);
$reviews = $stmt2->fetchAll(PDO::FETCH_ASSOC);
$stmt2->execute();


?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="style.css">
  <title>catalog</title>
</head>

<body>
  <h1><?php echo h($trimming['title']); ?></h1>
  <p>
    <h2><?php echo h($trimming['name']); ?></h2>
  </p>

  <ul class="trimmings-list">
    <li>
      <img src="../dog_picture/<?php echo h($trimming['picture']); ?>" alt="犬の写真"><br>
      <?php echo h($trimming['body']); ?><br>
      投稿日時 : <?php echo h($trimming['created_at']); ?><br>
      <a href="index.php">戻る</a>
      <p><a href="reviews.php?trimming_id=<?php echo h($trimming['id']); ?>">口コミ投稿</a></p>
      <hr>
    </li>
  </ul>
  <h3>口コミ</h3>
  <?php if (count($reviews)) : ?>
    <ul>
      <?php foreach ($reviews as $r) : ?>
        <li>
          <?php echo h($r['name']); ?><br>
          <?php echo h($r['comment']); ?><br>
          投稿日時: <?php echo h($r['created_at']); ?>
          <hr>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php else : ?>
    <p>投稿された記事はありません</p>
  <?php endif; ?>
</body>

</html>