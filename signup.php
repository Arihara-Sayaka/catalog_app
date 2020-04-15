<?php

require_once('config.php');
require_once('functions.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = $_POST['email'];
  $name = $_POST['name'];
  $password = $_POST['password'];
  $errors = [];
  // バリデーション
  if ($email == '') {
    $errors[] = 'メールアドレスが未入力です';
  }
  if ($name == '') {
    $errors[] = 'ユーザー名が未入力です';
  }
  if ($password == '') {
    $errors[] = 'パスワードが未入力です';
  }
}

if (empty($eroors)) {
  $dbh = connectDb();

  $sql = 'insert into users' . 
          '(email, name, password) values' . 
          '(:email, :name, :password)';
  $stmt = $dbh->prepare($sql);

  $stmt->bindParam(':email', $email, PDO::PARAM_STR);
  $stmt->bindParam(':name', $name, PDO::PARAM_STR);

  $pw_hash = password_hash($password, PASSWORD_DEFAULT);
  $stmt->bindParam(':password', $pw_hash);

  $stmt->execute();

  // header('Location: login.php');
  // exit;
}


?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="style.css">
  <title>新規登録画面</title>
</head>

<body>
  <h1>SignUP</h1>

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
    <label for="name"> name :
      <input type="text" name="name" value="<?php echo h($name); ?>">
    </label>
    <br>
    <label for="password"> pass :
      <input type="text" name="password">
    </label>
    <br>
    <input type="submit" value=" Sing Up ">
  </form>
  <a href="login.php">login</a>
</body>

</html>