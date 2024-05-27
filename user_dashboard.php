<?php
session_start();
require_once 'db_config.php';
global $conn;
if(!isset($_SESSION['userId'])) {
    header("Location: index.php");
    exit();
}


if(isset($_POST['party_id'])) {
    $partyId = $_POST['party_id'];
    $userId = $_SESSION['userId'];

    $sql = "SELECT registered_users FROM pidu WHERE Id=$partyId";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $registeredUsers = json_decode($row['registered_users'], true);
        if ($registeredUsers === null) {
            $registeredUsers = array();
        }
        if (!in_array($userId, $registeredUsers)) {
            $registeredUsers[] = $userId;
            $registeredUsersJson = json_encode($registeredUsers);
            $updateSql = "UPDATE pidu SET registered_users='$registeredUsersJson' WHERE Id=$partyId";
            if ($conn->query($updateSql) === TRUE) {
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


$sql = "SELECT * FROM pidu";
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
