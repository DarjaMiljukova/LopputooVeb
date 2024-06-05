<?php
session_start();
require_once 'db_config.php';

global $conn;
if (!isset($_SESSION['userId']) || !$_SESSION['isAdmin']) {
    header("HTTP/1.1 401 Unauthorized");
    exit();
}

if (isset($_POST['party_id'])) {
    $partyId = $_POST['party_id'];
    $deletePartySql = "DELETE FROM pidu WHERE Id=$partyId";
    if ($conn->query($deletePartySql) === TRUE) {
        echo "Pidu on edukalt kustutatud.";
    } else {
        echo "Viga: " . $conn->error;
    }
} else {
    header("HTTP/1.1 400 Bad Request");
}
?>
