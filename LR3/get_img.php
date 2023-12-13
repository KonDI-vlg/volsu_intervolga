<?php
session_start();
require_once "db.php";
global $db;

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$sql = "SELECT * FROM bikes WHERE id = :id";
$stmt = $db->prepare($sql);
$stmt->execute(['id' => $_GET['img']]);
$data = $stmt->fetch();
if (!$data) {
    header("Location: login.php");
    exit();
}
header('Content-Type: image/jpg');
readfile($data['img_path']);