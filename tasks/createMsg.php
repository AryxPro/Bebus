<?php
session_start();

if($_SESSION['isLogged'] != true){
    header('Location: ../index.php');
}

require_once('../conf/db.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../index.php');
}

$nowyWpis = $_POST['nowyWpis'] ?? null;

if ($nowyWpis === null) {
    header('Location: ../index.php');
}
$nowyWpisUserId = $_SESSION['user_id'];

$stmt = $db->prepare("INSERT INTO message (`id`, `content`, `user_id`, `date`) VALUES (NULL,:nowyWpis,:user_id,CURRENT_TIMESTAMP)");
$stmt->execute([
    ':nowyWpis' => $nowyWpis,
    ':user_id' => $nowyWpisUserId
]);

header('Location: ../index.php');

