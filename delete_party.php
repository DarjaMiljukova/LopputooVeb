<?php
if (isset($_GET['code'])) {die(highlight_file(__FILE__, 1)); }
?>
<?php
// Sessiooni alustamine
session_start();
// Konfiguratsioonifaili kaasamine
require_once 'conf.php';

global $conn;

// Kontrollitakse, kas kasutaja on sisse logitud ja kas ta on administraator
if (!isset($_SESSION['userId']) || !$_SESSION['isAdmin']) {
    // Kui tingimus pole täidetud, saadetakse 401 Unathorized vastus ja skript lõpetatakse
    header("HTTP/1.1 401 Unauthorized");
    exit();
}

// Kontrollitakse, kas POST-päringus on määratud party_id
if (isset($_POST['party_id'])) {
    $partyId = $_POST['party_id'];
    $deletePartySql = "DELETE FROM pidu WHERE Id=$partyId";
    // Kui päring on edukas, kuvatakse vastav teade
    if ($conn->query($deletePartySql) === TRUE) {
        echo "Pidu on edukalt kustutatud.";
    } else {
        // Kui päring ebaõnnestub, kuvatakse veateade
        echo "Viga: " . $conn->error;
    }
} else {
    // Kui party_id pole määratud, saadetakse 400 Bad Request vastus
    header("HTTP/1.1 400 Bad Request");
}
?>
