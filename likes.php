<?php

use LanguageServerProtocol\InsertTextFormat;

require_once('config.php');
require_once('functions.php');

$dbh = connectDb();

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

  $like = $_GET['like_count'];
  $trimmings_id = $_POST['trimmings_id'];
  $user_id = $_SESSION['id'];

  if ($like == "1") {
    $sql = "insert into likescount (user_id, trimmings_id) values (:user_id, :trimmings_id)"; 
  } else {
    $sql = "DELETE FROM likescount WHERE id = :id";
  }

  //sql文で該当のデータを更新する

$sql = <<<SQL
update
  likescount
set
  user_id = :user_id,
  trimmings_id = :trimmings_id
WHERE
  id = :id
SQL;

$stmt = $dbh->prepare($sql);
$stmt->bindParam(':trimmings_id', $trimmings_id, PDO::PARAM_INT);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->bindParam(":id", $id);
$stmt->execute();

  header("Location: show.php?id=${id}");
  exit;

  }
