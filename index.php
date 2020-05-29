<?php

require_once('config.php');
require_once('functions.php');

$dbh = connectDb();

$dogbreed_id = $_GET['dogbreed_id'];
//sql文の実行 
$sql = <<<SQL
SELECT
  t.*,
  d.name
FROM
  trimmings t
LEFT JOIN
  dogbreed d
ON
  t.dogbreed_id = d.id
SQL;

if (($dogbreed_id) &&
    is_numeric($dogbreed_id)) {
  $sql_where = ' WHERE t.dogbreed_id = :dogbreed_id';
} else {
  $sql_where = "";  
}
$sql_order = ' ORDER BY t.created_at DESC';

$sql = $sql . $sql_where . $sql_order;
$stmt = $dbh->prepare($sql);

if (($dogbreed_id) &&
    is_numeric($dogbreed_id)) {
  $stmt->bindParam(':dogbreed_id', $dogbreed_id, PDO::PARAM_INT);
}

//プリペアドステートメント

$stmt->execute();

//記事デーテの格納
$trimmings = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = 'SELECT id, name FROM dogbreed ORDER BY id';
$stmt = $dbh->prepare($sql);
$stmt->execute();
$dogbreed = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
          <a href="show.php?id=<?php echo h($trimming['id']) ?>">
            <img src="../dog_picture/<?php echo h($trimming['picture']); ?>" alt="犬の写真"><br>
          </a><br>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php else : ?>
    <p>投稿された記事はありません</p>
  <?php endif; ?>

  <div>
    <h2>カテゴリー</h2>
    <ul>
      <?php foreach ($dogbreed as $d) : ?>
        <li class="dogbreed">
          <a href="index.php?dogbreed_id=<?php echo h($d['id']); ?>"><?php echo h($d['name']); ?></a></span>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
<p><a href="index.php">一覧へ戻る</a></p>
</body>

</html>