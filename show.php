<?php

require_once('config.php');
require_once('functions.php');

$id = $_REQUEST['id'];

session_start();
$dbh = connectDb();

if ($_SESSION['id']) {
  $sql1 = <<<SQL
  SELECT
    t.*,
    d.name,
    l.id as likescount_id
  FROM
    trimmings t
  LEFT JOIN
    dogbreed d
  ON
    t.dogbreed_id = d.id
  left join
    likescount l
  on
    t.id = l.trimmings_id
  and
  l.user_id = :user_id
  WHERE
    t.id = :id
  SQL;
  $stmt1 = $dbh->prepare($sql1);
  $stmt1->bindParam(':id', $id, PDO::PARAM_INT);
  $stmt1->bindParam(':user_id', $_SESSION['id'], PDO::PARAM_INT);
} else {
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
}

$stmt1->execute();
$trimming = $stmt1->fetch(PDO::FETCH_ASSOC);


$sql2 = <<<SQL
SELECT
  t.*,
  r.*
FROM
  trimmings t
LEFT JOIN
  reviews r
ON
  r.trimmings_id = t.id
WHERE
  t.id = :id
SQL;


$stmt2 = $dbh->prepare($sql2);
$stmt2->bindParam(':id', $id, PDO::PARAM_INT);
$stmt2->execute();

$reviews = $stmt2->fetchAll(PDO::FETCH_ASSOC);

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

<body class="show-main">

  <h1><?php echo h($trimming['title']); ?></h1>

  <ul>
    <li>
      <img src="../dog_picture/<?php echo h($trimming['picture']); ?>" alt="犬の写真" class="show"><br>
      <p>
        <h2><?php echo h($trimming['name']); ?></h2>
      </p>
      <p>
        <?php echo h($trimming['body']); ?>
      </p>
      投稿日時 : <?php echo h($trimming['created_at']); ?>


      <?php if ($_SESSION['id']) : ?>
        <?php if ($trimming['likescount_id']) : ?>
          <a href="likes.php?id=<?php echo h($trimming['likescount_id']) . "&trimmings_id=" . h($trimming['id']); ?>" class="like-link"><?php echo '♥'; ?></a>
        <?php else : ?>
          <a href="likes.php?trimmings_id=<?php echo h($trimming['id']) . "&user_id=" . $_SESSION['id']; ?>" class="bad-link"><?php echo '♡'; ?></a>
        <?php endif; ?><br>
      <?php endif; ?>

      <a href="index.php">戻る</a>
      <?php if ($_SESSION['id']) : ?>or
        <a href="reviews.php?trimmings_id=<?php echo h($trimming['id']); ?>">コメント</a>
      <?php endif; ?>
      <hr>
      <hr>
    </li>
  </ul>
  <h3>COMMENT</h3>
  <?php if (count($reviews)) : ?>
    <ul class="comment">
      <?php foreach ($reviews as $r) : ?>
        <li>
          <p>➢ Nickname：<?php echo nl2br(h($r['name'])); ?>さん</p>
          ✍ Comment <br>
          <?php echo nl2br(h($r['comment'])); ?>
          <p>
            投稿日時: <?php echo h($r['created_at']); ?>
          </p><br>

        </li>
      <?php endforeach; ?>
    </ul>
  <?php else : ?>
    <p>投稿された記事はありません</p>
  <?php endif; ?>
</body>

</html>