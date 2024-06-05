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
    header("Location: index.php");
    exit();
}

// Funktsioon peo kustutamiseks
function deleteParty($conn, $partyId) {
    $deletePartySql = "DELETE FROM pidu WHERE Id=?";
    $stmt = $conn->prepare($deletePartySql);
    $stmt->bind_param("i", $partyId);
    return $stmt->execute();
}

// Funktsioon peo andmete muutmiseks
function updateParty($conn, $partyId, $newName, $newType, $newDate) {
    $updatePartySql = "UPDATE pidu SET PiduNimi=?, Tuup=?, Aeg=? WHERE Id=?";
    $stmt = $conn->prepare($updatePartySql);
    $stmt->bind_param("sssi", $newName, $newType, $newDate, $partyId);
    return $stmt->execute();
}

// Funktsioon uue peo lisamiseks
function addParty($conn, $tuup, $pidunimi, $aeg) {
    $insertPartySql = "INSERT INTO pidu (Tuup, PiduNimi, Aeg) VALUES(?, ?, ?)";
    $stmt = $conn->prepare($insertPartySql);
    $stmt->bind_param("sss", $tuup, $pidunimi, $aeg);
    return $stmt->execute();
}

// Kui on saadetud vormi andmed peo kustutamiseks
if (isset($_POST['delete_party'])) {
    $partyId = $_POST['delete_party'];
    header("Location: admin_dashboard.php");
}

// Kui on saadetud vormi andmed peo muutmiseks
if (isset($_POST['edit_party'])) {
    $partyId = $_POST['party_id'];
    $newName = $_POST['new_name'];
    $newType = $_POST['new_type'];
    $newDate = $_POST['new_date'];
    header("Location: admin_dashboard.php");
}

// Kui on saadetud vormi andmed uue peo lisamiseks
if (isset($_POST['add_party'])) {
    $tuup = $_POST['tuup'];
    $pidunimi = $_POST['pidunimi'];
    $aeg = $_POST['aeg'];
    header("Location: admin_dashboard.php");
}

// Pidude andmete pärimine andmebaasist
$sql = "SELECT * FROM pidu";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pidu info</title>
    <link rel="stylesheet" type="text/css" href="stiilid/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>
<body>
<div id="navid">
    <header>
        <h1>Admin Tahvel</h1>
        <nav>
            <ul>
                <li><a href="infouser.php">Kasutajad infod tahvel</a></li>
                <li><a href="admin_dashboard.php">Pidud infod tahvel</a></li>
                <li><a href="logout.php">Logi välja</a></li>
            </ul>
            <br>
        </nav>
    </header>
</div>
<div class="admin-dashboard">
    <h2>Pidud informatsioonid</h2>
    <header>
        <table>
            <tr>
                <th>Nimetus</th>
                <th>Tüüp</th>
                <th>Kuupäev</th>
                <th>Tegevused</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['PiduNimi']); ?></td>
                    <td><?= htmlspecialchars($row['Tuup']); ?></td>
                    <td><?= htmlspecialchars($row['Aeg']); ?></td>
                    <td>
                        <!-- Vorm peo kustutamiseks -->
                        <form method="post" style="display:inline-block;">
                            <input type="hidden" name="delete_party" value="<?= $row['Id']; ?>">
                            <button type="submit">Kustutamine pidu</button>
                        </form>
                        <!-- Nupu vajutamisel avaneb redigeerimisaken -->
                        <button type="button" onclick="openEditModal('<?= $row['Id']; ?>', '<?= htmlspecialchars($row['PiduNimi']); ?>', '<?= htmlspecialchars($row['Tuup']); ?>', '<?= htmlspecialchars($row['Aeg']); ?>')">Muudamine pidu</button>
                    </td>
                </tr>
            <?php endwhile; ?>
            <button type="button" onclick="openAddModal()">Lisamine pidu</button>
        </table>

        <!-- Muutmise aken -->
        <div id="editModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('editModal')">&times;</span>
                <h2>Muudamine pidu</h2>
                <form id="editForm" method="post">
                    <input type="hidden" id="editPartyId" name="party_id">
                    Uus nimetus: <input type="text" id="editNewName" name="new_name" required><br>
                    Uus tüüp: <input type="text" id="editNewType" name="new_type" required><br>
                    Uus kuupäev: <input type="date" id="editNewDate" name="new_date" required><br>
                    <button type="submit" name="edit_party" >Salvestamine muudamised</button>
                </form>
            </div>
        </div>

        <!-- Lisamise aken -->
        <div id="addModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('addModal')">&times;</span>
                <h2>Lisamine pidu</h2>
                <form id="addForm" method="post">
                    Nimetus: <input type="text" name="pidunimi" required><br>
                    Tüüp: <input type="text" name="tuup" required><br>
                    Kuupäev: <input type="date" name="aeg" required><br>
                    <button type="submit" name="add_party" >Lisamine pidu</button>
                </form>
            </div>
        </div>
</div>
<script>
    // Funktsioon redigeerimisakna avamiseks ja andmete täitmiseks
    function openEditModal(partyId, name, type, date) {
        document.getElementById('editPartyId').value = partyId;
        document.getElementById('editNewName').value = name;
        document.getElementById('editNewType').value = type;
        document.getElementById('editNewDate').value = date;
        document.getElementById('editModal').style.display = "block";
    }

    // Funktsioon lisamisakna avamiseks
    function openAddModal() {
        document.getElementById('addModal').style.display = "block";
    }

    // Funktsioon akna sulgemiseks
    function closeModal(modalId) {
        document.getElementById(modalId).style.display = "none";
    }

    // Akna sulgemine, kui klikitakse väljaspool modal akent
    window.onclick = function(event) {
        if (event.target.className === 'modal') {
            event.target.style.display = "none";
        }
    }
</script>
</body>
</html>
