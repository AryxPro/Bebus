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

$stmt = $db->prepare("SELECT COUNT(*) FROM user WHERE login = :login");
$stmt->execute([':login' => $login]);
$userExists = $stmt->fetchColumn();



if ($userExists) {
    $_SESSION['error'] = 'Użytkownik o podanym loginie już istnieje';
    header('Location: index.php');
    exit;
}

$stmt = $db->prepare("INSERT INTO user (login, password) VALUES (:login, :password)");
$stmt->execute([
    ':login' => $login,
    ':password' => password_hash($password, PASSWORD_DEFAULT) // Hash the password before storing it
]);

header('Location: index.php');
exit;