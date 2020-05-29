<?php

require_once('config.php');
require_once('functions.php');

session_start();

if (empty($_SESSION['id'])) {
  header('Location: login.php');
  exit;
}

$dbh = connectDb();

$sql = <<<SQL
SELECT
  r.*,
  c.name
FROM
  reviews r
LEFT JOIN
  trimmings t
ON
  r.trimming_id = t.id
WHERE
  r.id = :id
SQL;

$stmt = $dbh->prepare($sql);
$stmt->bindParam(':id', $_POST['trimming_id'], PDO::PARAM_INT);
$stmt->execute();

$users = $stmt->fetch(PDO::FETCH_ASSOC);
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="style.css">
  <title>会員限定画面</title>
</head>

<body>
  <h1>会員様限定口コミ投稿用ページです</h1>

  <h2>Welcome <?php echo h($user['name']); ?> !!</h2>

  <div class="container">
    <div class="row">
      <div class="col-sm-11 col-md-9 col-lg-7 mx-auto">
        <div class="card my-5 bg-light">
          <div class="card-body">
            <h5 class="card-title text-center">新規記事</h5>
            <form action="new.php" method="post">
              <div class="form-group">
                <label for="title"> Name </label>
                <input type="text" class="form-control" required autofocus name="name">
              </div>

              <div class="form-group">
                <label for="body"> 口コミ </label>
                <textarea name="body" id="" cols="30" rows="10" class="form-control" required></textarea>
              </div>
              <div class="form-group">
                <input type="hidden" name="trimming_id" value="<?php echo $trimming_id;?>">
                <!-- <input type="submit" value="登録" class="btn btn-success btn-primary btn-block "> -->
                <a href="<?php h($trimming['id']) ?>" class="btn btn-success btn-primary btn-block ">登録</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <p><a href="logout.php">ログアウト</a></p>
</body>

</html>