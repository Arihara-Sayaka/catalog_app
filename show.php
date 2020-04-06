<?php

require_once('config.php');
require_once('functions.php');

$id = $_GET['id'];

$dbh = connectDb();

$sql = 'SELECT * FROM trimmings WHERE id = :id ';

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
  <ul class="trimmings-list">
    <li>
      <img src="../dog_picture/<?php echo h($trimming['picture']); ?>" alt="犬の写真"><br>
      <?php echo h($trimming['body']); ?><br>
      投稿日時: <?php echo h($trimming['created_at']); ?><br>
      <a href="index.php">戻る</a>
      <hr>
    </li>
  </ul>

</body>

</html>