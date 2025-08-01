<?php
require_once 'db_connect.php';
session_start();
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit;
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($username && $password) {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: bookmark_list.php');
            exit;
        } else {
            $message = 'ユーザー名またはパスワードが違います。';
        }
    } else {
        $message = 'ユーザー名とパスワードを入力してください。';
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>備忘録アプリ ログイン</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body {
      background: #f8f6f9;
      font-family: 'Yu Gothic', 'Hiragino Sans', Arial, sans-serif;
      color: #444;
      margin: 0;
      padding: 0;
    }
    .container {
      max-width: 350px;
      margin: 60px auto;
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 2px 12px rgba(200,170,200,0.12);
      padding: 32px 24px;
    }
    h2 {
      text-align: center;
      color: #b97fa0;
      margin-bottom: 24px;
      font-weight: 500;
    }
    label {
      display: block;
      margin-bottom: 8px;
      color: #b97fa0;
      font-size: 15px;
    }
    input[type="text"], input[type="password"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 18px;
      border: 1px solid #e5d7e5;
      border-radius: 8px;
      background: #f6f2f7;
      font-size: 16px;
    }
    button {
      width: 100%;
      padding: 10px;
      background: #b97fa0;
      color: #fff;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      margin-top: 8px;
      transition: background 0.2s;
    }
    button:hover {
      background: #a06c8a;
    }
    .register-link {
      text-align: center;
      margin-top: 18px;
      font-size: 14px;
    }
    .register-link a {
      color: #b97fa0;
      text-decoration: none;
    }
    .register-link a:hover {
      text-decoration: underline;
    }
    .message {
      text-align: center;
      color: #b97fa0;
      margin-bottom: 16px;
      font-size: 15px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>備忘録アプリ ログイン</h2>
    <?php if ($message): ?>
      <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <form action="login.php" method="post">
      <label for="username">ユーザー名</label>
      <input type="text" id="username" name="username" required>
      <label for="password">パスワード</label>
      <input type="password" id="password" name="password" required>
      <button type="submit">ログイン</button>
    </form>
    <div class="register-link">
      <span>初めての方は <a href="register.php">新規登録</a></span>
    </div>
  </div>
</body>
</html>
