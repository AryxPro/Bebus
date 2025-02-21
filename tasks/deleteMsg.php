<?php
session_start();

if($_SESSION['isLogged'] != true){
    header('Location: ../index.php');
}

require_once('../conf/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Location: ../index.php');
}

$id = $_GET['id'] ?? null;

if ($id === null) {
    header('Location: ../index.php');
}

$stmt = $db->prepare("SELECT user_id FROM message WHERE id = :id;");
$stmt->execute([
    ':id' => $id
]);
$user_id = $stmt->fetch();


if($user_id != $_SESSION['user_id'] && $_SESSION['admin'] != 1){
    if($_SESSION['admin'] != 1){
        header('Location: ../index.php');
    }
    header('Location: ../admin/admin.php');
}

$stmt = $db->prepare("DELETE FROM message WHERE id = :id;");
$stmt->execute([
    ':id' => $id,
]);
header('Location: ../index.php');