<?php
session_start();
require_once('../conf/db.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$login = $_POST['login'] ?? null;
$password = $_POST['password'] ?? null;

if ($login === null || $password === null) {
    header('Location: index.php');
    exit;
}

$password = password_hash($password, PASSWORD_BCRYPT);
$stmt = $db->prepare("INSERT INTO user (login, password, name) VALUES (:login, :password)");
$stmt->execute([':login' => $login, ':password' => $password]);
header('Location: index.php');
exit;
