<?php

require_once('config.php');
require_once('functions.php');

$id = $_GET['id'];

$dbh = connectDb();

$sql = <<<SQL
SELECT
  t.*,
  -- r.*,
  d.name
FROM
  trimmings t,
  -- reviews r
LEFT JOIN
  dogbreed d
ON
  t.dogbreed_id = d.id
WHERE
  t.id = :id
SQL;

$stmt = $dbh->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

$trimming = $stmt->fetch(PDO::FETCH_ASSOC);

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
      <p><a href="reviews.php?trimmings_id=<?php echo h($trimming['id']); ?>">口コミ投稿</a></p>
      <hr>
    </li>
  </ul>
  <!-- <h3>口コミ</h3>
  <?php if (count($reviews)) : ?>
    <ul>
      <?php foreach ($reviews as $review) : ?>
        <li>
          <?php echo h($review['name']); ?><br>
          <?php echo h($review['comment']); ?><br>
          投稿日時: <?php echo h($review['created_at']); ?>
          <hr>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php else : ?>
    <p>投稿された記事はありません</p>
  <?php endif; ?> -->
</body>

</html>