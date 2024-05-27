<?php
session_start();
require_once 'db_config.php';

global $conn;
if (!isset($_SESSION['userId']) || !$_SESSION['isAdmin']) {
    header("Location: index.php");
    exit();
}

function deleteParty($conn, $partyId) {
    $deletePartySql = "DELETE FROM pidu WHERE Id=?";
    $stmt = $conn->prepare($deletePartySql);
    $stmt->bind_param("i", $partyId);
    return $stmt->execute();
}

function updateParty($conn, $partyId, $newName, $newType, $newDate) {
    $updatePartySql = "UPDATE pidu SET PiduNimi=?, Tuup=?, Aeg=? WHERE Id=?";
    $stmt = $conn->prepare($updatePartySql);
    $stmt->bind_param("sssi", $newName, $newType, $newDate, $partyId);
    return $stmt->execute();
}

function addParty($conn, $tuup, $pidunimi, $aeg) {
    $insertPartySql = "INSERT INTO pidu (Tuup, PiduNimi, Aeg) VALUES(?, ?, ?)";
    $stmt = $conn->prepare($insertPartySql);
    $stmt->bind_param("sss", $tuup, $pidunimi, $aeg);
    return $stmt->execute();
}

if (isset($_POST['delete_party'])) {
    $partyId = $_POST['delete_party'];
    header("Location: admin_dashboard.php");
}

if (isset($_POST['edit_party'])) {
    $partyId = $_POST['party_id'];
    $newName = $_POST['new_name'];
    $newType = $_POST['new_type'];
    $newDate = $_POST['new_date'];
    header("Location: admin_dashboard.php");
}

if (isset($_POST['add_party'])) {
    $tuup = $_POST['tuup'];
    $pidunimi = $_POST['pidunimi'];
    $aeg = $_POST['aeg'];
    header("Location: admin_dashboard.php");
}


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
                    <form method="post" style="display:inline-block;">
                        <input type="hidden" name="delete_party" value="<?= $row['Id']; ?>">
                        <button type="submit">Kustutamine pidu</button>
                    </form>
                    <button type="button" onclick="openEditModal('<?= $row['Id']; ?>', '<?= htmlspecialchars($row['PiduNimi']); ?>', '<?= htmlspecialchars($row['Tuup']); ?>', '<?= htmlspecialchars($row['Aeg']); ?>')">Muudamine pidu</button>
                </td>
            </tr>
        <?php endwhile; ?>
        <button type="button" onclick="openAddModal()">Lisamine pidu</button>
    </table>

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
    function openEditModal(partyId, name, type, date) {
        document.getElementById('editPartyId').value = partyId;
        document.getElementById('editNewName').value = name;
        document.getElementById('editNewType').value = type;
        document.getElementById('editNewDate').value = date;
        document.getElementById('editModal').style.display = "block";
    }

    function openAddModal() {
        document.getElementById('addModal').style.display = "block";
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target.className === 'modal') {
            event.target.style.display = "none";
        }
    }

</script>
</body>
</html>
