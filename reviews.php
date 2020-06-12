<?php

require_once('config.php');
require_once('functions.php');

session_start();

$id = $_SESSION['id'];
if (!is_numeric($id)) {
  exit;
}

$dbh = connectDb();

$sql = <<<SQL
SELECT
  r.*,
  u.name
FROM
  reviews r
LEFT JOIN
  users u
ON
  r.user_id = u.id
WHERE
  r.id = :id
SQL;

$stmt = $dbh->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);


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

  <nav>
    <ul>
      <a href="http://localhost/index.php">HOME</a>
    </ul>
    <div>
      <ul>
        <?php if ($_SESSION['id']) : ?>
          <li class="nav-item">
            <a href="logout.php">LOG_OUT</a>
          </li>
          <li class="nav-item">
            <a href="reviews.php">COMMENT</a>
          </li>
        <?php else : ?>
          <li class="nav-item">
            <a href="login.php">LOG_IN</a>
          </li>
          <li class="nav-item">
            <a href="signup.php">SIGN_UP</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </nav>

  <h1>会員様限定口コミ投稿用ページです</h1>

  <h2>Welcome <?php echo h($user['name']); ?> !!</h2>

  <div class="container">
    <div class="row">
      <div class="col-sm-11 col-md-9 col-lg-7 mx-auto">
        <div class="card my-5 bg-light">
          <div class="card-body">
            <h5 class="card-title text-center">新規記事</h5>

            <form action="show.php?trimming_id=<?php echo h($trimming['id']); ?>" method="post">
              <div class="form-group">
                <label for="name"> Name </label>
                <input type="name" class="form-control" required autofocus name="name">
              </div>

              <div class="form-group">
                <label for="body"> 口コミ </label>
                <textarea name="body" id="" cols="30" rows="10" class="form-control" required></textarea>
              </div>
              <div class="form-group">
                <input type="hidden" name="trimming_id" value="<?php echo $trimming_id; ?>">
                <input type="submit" value="comment" class="btn btn-success btn-primary btn-block">
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