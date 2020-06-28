<?php

require_once('config.php');
require_once('functions.php');

session_start();

if (!empty($_SESSION['id'])) {
  header('Location: index.php');
  exit;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];
  $errors = [];

  if ($email == '') {
    $errors[] = 'メールアドレスが未入力です';
  }
  if ($password == '') {
    $errors[] = 'パスワードが未入力です';
  }

  // バリデーション突破後
  if (empty($errors)) {
    $dbh = connectDb();

    $sql = 'SELECT * FROM users WHERE email = :email';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (password_verify($password, $user['password'])) {
      $_SESSION['id'] = $user['id'];
      header('Location: reviews.php');
      exit;
    } else {
      $errors[] = 'メールアドレスかパスワードが間違っています';
    }
  }
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="style.css">
  <title>ログイン画面</title>
</head>

<body class="login-main">
  <header class="login-header">
    <a href="signup.php">初めましてはコチラ</a>
  </header>

  <h1 class="in">LOGIN</h1>

  <?php if ($errors) : ?>
    <ul class="error-list">
      <?php foreach ($errors as $error) : ?>
        <li><?php echo $error; ?></li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>


  <form action="" method="post">
    <label for="email"> email :
      <input type="email" name="email" value="<?php echo h($email); ?>">
    </label>
    <br>
    <label for="password"> pass :
      <input type="password" name="password">
    </label>
    <br>
    <input type="submit" value="login">
  </form>

  <footer class="login-footer">
    
  </footer>
</body>

</html>