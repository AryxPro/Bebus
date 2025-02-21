<?php
session_start();
require_once('../conf/db.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || $_SESSION['admin']==0) {
    header('Location: admin.php');
    exit;
}

$id = $_POST['id'] ?? null;

if ($id === null) {
    header('Location: admin.php');
    exit;
}

$stmt = $db->prepare("DELETE FROM user WHERE id = :id");
$stmt->execute([':id' => $id]);
header('Location: admin.php');
exit;
