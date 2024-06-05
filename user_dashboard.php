<?php if (isset($_GET['code'])) {die(highlight_file(__File__, 1)); }?>
<?php
session_start();
require_once 'conf.php'; // Laadib konfiguratsioonifaili
global $conn; // Globaalne ühendus andmebaasiga
if(!isset($_SESSION['userId'])) { // Kontrollib, kas kasutaja on sisse logitud
    header("Location: index.php"); // Kui ei, suunab kasutaja sisse logimise lehele
    exit();
}

if(isset($_POST['party_id'])) { // Kontrollib, kas on saadetud peo ID
    $partyId = $_POST['party_id'];
    $userId = $_SESSION['userId'];

    // Küsib registreeritud kasutajate nimekirja valitud peo jaoks
    $sql = "SELECT registered_users FROM pidu WHERE Id=$partyId";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) { // Kontrollib, kas pidu on olemas
        $row = $result->fetch_assoc();
        $registeredUsers = json_decode($row['registered_users'], true);
        if ($registeredUsers === null) { // Kui registreeritud kasutajaid pole, loob tühja massiivi
            $registeredUsers = array();
        }
        if (!in_array($userId, $registeredUsers)) { // Kontrollib, kas kasutaja pole juba registreerunud
            $registeredUsers[] = $userId;
            $registeredUsersJson = json_encode($registeredUsers);
            $updateSql = "UPDATE pidu SET registered_users='$registeredUsersJson' WHERE Id=$partyId";
            if ($conn->query($updateSql) === TRUE) { // Uuendab registreeritud kasutajate nimekirja
                echo "<script>alert('Olete edukalt peole registreerunud!');</script>";
            } else {
                echo "<script>alert('Viga: " . addslashes($conn->error) . "');</script>";
            }
        } else {
            echo "<script>alert('TE OLETE SELLELE PEOLE JUBA REGISTREERINUD');</script>";
        }
    } else {
        echo "<script>alert('Pidu ei leitud.');</script>";
    }
}

$sql = "SELECT * FROM pidu"; // Küsib kõik peod andmebaasist
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kasutaja tahvel</title>
    <link rel="stylesheet" type="text/css" href="stiilid/style.css">
</head>
<body>
<div class="bar-container"></div>
<div class="content"></div>
<script src="stiilid/script.js"></script>
<div class="user-dashboard">
    <h1>Kasutaja tahvel</h1>
    <h2>Siin saate sirvida ja liituda erakondadega.</h2>
    <br>
    <div class="parties">
        <?php while($row = $result->fetch_assoc()): ?>
            <div class="party">
                <h3><?= $row['PiduNimi']; ?></h3>
                <p>Tüüp: <?= $row['Tuup']; ?></p>
                <p>Kuupäev: <?= $row['Aeg']; ?></p>
                <form action="user_dashboard.php" method="post">
                    <input type="hidden" name="party_id" value="<?= $row['Id']; ?>">
                    <button type="submit">Registreerimine</button>
                </form>
            </div>
        <?php endwhile; ?>
    </div>
    <br>
    <a href="logout.php">Logi välja</a>
</div>
</body>
</html>
