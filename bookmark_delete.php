<?php
// ブックマーク削除処理
require_once 'db_connect.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$user_id = $_SESSION['user_id'];
$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $pdo->prepare('DELETE FROM bookmarks WHERE id = ? AND user_id = ?');
    $stmt->execute([$id, $user_id]);
}
header('Location: bookmark_list.php');
exit;
?>
