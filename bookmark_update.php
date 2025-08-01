<?php
require_once 'db_connect.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$user_id = $_SESSION['user_id'];
$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: bookmark_list.php');
    exit;
}
// 既存データ取得
$stmt = $pdo->prepare('SELECT * FROM bookmarks WHERE id = ? AND user_id = ?');
$stmt->execute([$id, $user_id]);
$bm = $stmt->fetch();
if (!$bm) {
    header('Location: bookmark_list.php');
    exit;
}
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $url = trim($_POST['url'] ?? '');
    $comment = trim($_POST['comment'] ?? '');
    if ($title && $url) {
        $stmt = $pdo->prepare('UPDATE bookmarks SET title = ?, url = ?, comment = ? WHERE id = ? AND user_id = ?');
        $stmt->execute([$title, $url, $comment, $id, $user_id]);
        header('Location: bookmark_list.php');
        exit;
    } else {
        $message = 'タイトルとURLは必須です。';
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ブックマーク編集 | 旅のしおり</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body { background: #f8f6f9; font-family: 'Yu Gothic', 'Hiragino Sans', Arial, sans-serif; color: #444; margin: 0; padding: 0; }
    .container { max-width: 350px; margin: 60px auto; background: #fff; border-radius: 16px; box-shadow: 0 2px 12px rgba(200,170,200,0.12); padding: 32px 24px; }
    h2 { text-align: center; color: #b97fa0; margin-bottom: 24px; font-weight: 500; }
    label { display: block; margin-bottom: 8px; color: #b97fa0; font-size: 15px; }
    input[type="text"], textarea { width: 100%; padding: 10px; margin-bottom: 18px; border: 1px solid #e5d7e5; border-radius: 8px; background: #f6f2f7; font-size: 16px; }
    button { width: 100%; padding: 10px; background: #b97fa0; color: #fff; border: none; border-radius: 8px; font-size: 16px; cursor: pointer; margin-top: 8px; transition: background 0.2s; }
    button:hover { background: #a06c8a; }
    .back-link { text-align: center; margin-top: 18px; font-size: 14px; }
    .back-link a { color: #b97fa0; text-decoration: none; }
    .back-link a:hover { text-decoration: underline; }
    .message { text-align: center; color: #b97fa0; margin-bottom: 16px; font-size: 15px; }
  </style>
</head>
<body>
  <div class="container">
    <h2>ブックマーク編集</h2>
    <?php if ($message): ?>
      <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <form action="bookmark_update.php?id=<?= $id ?>" method="post">
      <label for="title">タイトル</label>
      <input type="text" id="title" name="title" value="<?= htmlspecialchars($bm['title']) ?>" required>
      <label for="url">URL</label>
      <input type="text" id="url" name="url" value="<?= htmlspecialchars($bm['url']) ?>" required>
      <label for="comment">コメント</label>
      <textarea id="comment" name="comment" rows="3"><?= htmlspecialchars($bm['comment']) ?></textarea>
      <button type="submit">更新</button>
    </form>
    <div class="back-link"><a href="bookmark_list.php">一覧に戻る</a></div>
  </div>
</body>
</html>
