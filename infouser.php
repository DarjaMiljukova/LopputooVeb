<?php
session_start();
require_once 'db_config.php';

global $conn;
if (!isset($_SESSION['userId']) || !$_SESSION['isAdmin']) {
    header("Location: index.php");
    exit();
}

function deleteUser($conn, $userId) {
    $deleteUserSql = "DELETE FROM kasutajad WHERE Id=?";
    $stmt = $conn->prepare($deleteUserSql);
    $stmt->bind_param("i", $userId);
    return $stmt->execute();
}

function updateUser($conn, $userId, $newFirstName, $newLastName, $newEmail, $newPassword) {
    $updateUserSql = "UPDATE kasutajad SET Eesnimi=?, Perenimi=?, Email=?, Parool=? WHERE Id=?";
    $stmt = $conn->prepare($updateUserSql);
    $stmt->bind_param("ssssi", $newFirstName, $newLastName, $newEmail, $newPassword, $userId);
    return $stmt->execute();
}


if (isset($_POST['delete_user'])) {
    $userId = $_POST['delete_user'];
    header("Location: infouser.php");
}

if (isset($_POST['edit_user'])) {
    $userId = $_POST['user_id'];
    $newFirstName = $_POST['new_first_name'];
    $newLastName = $_POST['new_last_name'];
    $newEmail = $_POST['new_email'];
    $newPassword = $_POST['new_password'];
    header("Location: infouser.php");
}

$sql = "SELECT * FROM kasutajad";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kasutaja info</title>
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

    <h2>Kasutajad informatsioonid</h2>
    <table>
        <tr>
            <th>Eesnimi</th>
            <th>Perenimi</th>
            <th>Email</th>
            <th>Parool</th>
            <th>Tegevused</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['Eesnimi']); ?></td>
                <td><?= htmlspecialchars($row['Perenimi']); ?></td>
                <td><?= htmlspecialchars($row['Email']); ?></td>
                <td><?= htmlspecialchars($row['Parool']); ?></td>
                <td>
                    <form method="post" style="display:inline-block;">
                        <input type="hidden" name="delete_user" value="<?= $row['Id']; ?>">
                        <button type="submit">Kustutamine kasutaja</button>
                    </form>
                    <button type="button" onclick="openEditModal('<?= $row['Id']; ?>', '<?= htmlspecialchars($row['Eesnimi']); ?>', '<?= htmlspecialchars($row['Perenimi']); ?>', '<?= htmlspecialchars($row['Email']); ?>', '<?= htmlspecialchars($row['Parool']); ?>')">Muudamine kasutajad info</button>
                </td>
            </tr>

        <?php endwhile; ?>
    </table>



    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('editModal')">&times;</span>
            <h2>Muudamine kasutaja</h2>
            <form id="editForm" method="post">
                <input type="hidden" id="editUserId" name="user_id">
                Uus eesnimi: <input type="text" id="editNewFirstName" name="new_first_name" required><br>
                Uus perenimi: <input type="text" id="editNewLastName" name="new_last_name" required><br>
                Uus email: <input type="email" id="editNewEmail" name="new_email" required><br>
                Uus parool: <input type="password" id="editNewPassword" name="new_password" required><br>
                <button type="submit" name="edit_user">Salvestamine muudamised</button>
            </form>
        </div>
    </div>

    <div id="addModal" class="modal">
        <div id="lisam" class="modal-content">
            <span class="close" onclick="closeModal('addModal')">&times;</span>
            <h2>Lisamine kasutaja</h2>
            <form id="addForm" method="post">
                Eesnimi: <input type="text" name="first_name" required><br>
                Perenimi: <input type="text" name="last_name" required><br>
                Email: <input type="email" name="email" required><br>
                Parool: <input type="password" name="password" required><br>
                <button type="submit" name="add_user">Lisamine kasutaja</button>
            </form>
        </div>
    </div>
</div>
<script>
    function openEditModal(userId, firstName, lastName, email, password) {
        document.getElementById('editUserId').value = userId;
        document.getElementById('editNewFirstName').value = firstName;
        document.getElementById('editNewLastName').value = lastName;
        document.getElementById('editNewEmail').value = email;
        document.getElementById('editNewPassword').value = password;
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
