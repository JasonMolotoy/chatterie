<?php
header('Content-Type: application/json');
include('../config/constants.php');

$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if (!$conn) {
    echo json_encode(['error' => 'Erreur de connexion']);
    exit();
}

$sql = "SELECT * FROM grL_Chat WHERE active=1";
$res = mysqli_query($conn, $sql);

$chats = [];
while ($row = mysqli_fetch_assoc($res)) {
    $chats[] = $row;
}

echo json_encode($chats);
