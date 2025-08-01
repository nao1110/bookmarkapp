<?php
require_once 'db_connect.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

// ブックマーク取得
$stmt = $pdo->prepare('SELECT * FROM bookmarks WHERE user_id = ? ORDER BY created_at DESC');
$stmt->execute([$user_id]);
$bookmarks = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ブックマーク一覧 | 旅のしおり</title>
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
      max-width: 500px;
      margin: 40px auto;
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
    .user {
      text-align: right;
      color: #b97fa0;
      font-size: 14px;
      margin-bottom: 10px;
    }
    .add-link {
      display: block;
      text-align: center;
      margin-bottom: 18px;
      font-size: 15px;
    }
    .add-link a {
      color: #b97fa0;
      text-decoration: none;
      font-weight: bold;
    }
    .add-link a:hover {
      text-decoration: underline;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 16px;
    }
    th, td {
      padding: 10px;
      border-bottom: 1px solid #e5d7e5;
      text-align: left;
    }
    th {
      background: #f6f2f7;
      color: #b97fa0;
      font-weight: 500;
    }
    .actions a {
      color: #b97fa0;
      text-decoration: none;
      margin-right: 8px;
      font-size: 14px;
    }
    .actions a:hover {
      text-decoration: underline;
    }
    .logout {
      text-align: right;
      margin-top: 10px;
    }
    .logout a {
      color: #b97fa0;
      text-decoration: none;
      font-size: 14px;
    }
    .logout a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>ブックマーク一覧</h2>
    <div class="user">こんにちは、<?= htmlspecialchars($username) ?> さん</div>
    <div class="add-link"><a href="bookmark_add.php">＋ 新しいブックマークを追加</a></div>
    <table>
      <tr>
        <th>タイトル</th>
        <th>URL</th>
        <th>コメント</th>
        <th>操作</th>
      </tr>
      <?php foreach ($bookmarks as $bm): ?>
      <tr>
        <td><?= htmlspecialchars($bm['title']) ?></td>
        <td><a href="<?= htmlspecialchars($bm['url']) ?>" target="_blank">リンク</a></td>
        <td><?= htmlspecialchars($bm['comment']) ?></td>
        <td class="actions">
          <a href="bookmark_update.php?id=<?= $bm['id'] ?>">編集</a>
          <a href="bookmark_delete.php?id=<?= $bm['id'] ?>" onclick="return confirm('削除しますか？');">削除</a>
        </td>
      </tr>
      <?php endforeach; ?>
    </table>
    <div class="logout"><a href="login.php?logout=1">ログアウト</a></div>
  </div>
</body>
</html>
