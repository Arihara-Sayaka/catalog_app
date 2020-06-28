<?php

use LanguageServerProtocol\InsertTextFormat;

require_once('config.php');
require_once('functions.php');

$dbh = connectDb();

$id = $_GET['id'];
$trimmings_id = $_GET['trimmings_id'];
$user_id = $_GET['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

  if ($id) {
    $sql = "DELETE FROM likescount WHERE id = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(":id", $id);
  } else {
    $sql = "insert into likescount (user_id, trimmings_id) values (:user_id, :trimmings_id)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
    $stmt->bindParam(":trimmings_id", $trimmings_id, PDO::PARAM_INT);
  }

  //sql文で該当のデータを更新する

$stmt->execute();

  header("Location: show.php?id=${trimmings_id}");
  exit;

  }
