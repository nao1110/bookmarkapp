<?php
// MySQL接続設定
$host = 'localhost';
$db   = 'gsacademy_bookmark';
$user = 'gsacademy_bookmark';
$pass = 'naoko1110';
$charset = 'utf8mb4';

$dsn = "mysql:host=mysql80.gsacademy.sakura.ne.jp;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    exit('DB接続エラー: ' . $e->getMessage());
}
?>
