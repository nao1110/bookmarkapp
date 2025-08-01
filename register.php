<?php
require_once 'db_connect.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($username && $password) {
        // パスワードをハッシュ化
        $hash = password_hash($password, PASSWORD_DEFAULT);
        try {
            $stmt = $pdo->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
            $stmt->execute([$username, $hash]);
            $message = '登録が完了しました。ログインしてください。';
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $message = 'このユーザー名は既に使われています。';
            } else {
                $message = '登録に失敗しました: ' . $e->getMessage();
            }
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
  <title>新規登録 | 旅のしおり</title>
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
    .login-link {
      text-align: center;
      margin-top: 18px;
      font-size: 14px;
    }
    .login-link a {
      color: #b97fa0;
      text-decoration: none;
    }
    .login-link a:hover {
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
    <h2>新規登録</h2>
    <?php if ($message): ?>
      <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <form action="register.php" method="post">
      <label for="username">ユーザー名</label>
      <input type="text" id="username" name="username" required>
      <label for="password">パスワード</label>
      <input type="password" id="password" name="password" required>
      <button type="submit">登録</button>
    </form>
    <div class="login-link">
      <span>登録済みの方は <a href="login.php">ログイン</a></span>
    </div>
  </div>
</body>
</html>
