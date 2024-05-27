<?php
session_start();
require_once 'db_config.php';
global $conn;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['pass']) ? $_POST['pass'] : '';

    if (!empty($email) && !empty($password)) {
        $sql = "SELECT Id, Eesnimi, onAdmin FROM kasutajad WHERE Email='$email' AND Parool='$password'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $_SESSION['userId'] = $row['Id'];
            $_SESSION['username'] = $row['Eesnimi'];
            $_SESSION['isAdmin'] = $row['onAdmin'];

            if ($_SESSION['isAdmin']) {
                header("Location: admin_dashboard.php");
                exit();
            } else {
                header("Location: user_dashboard.php");
                exit();
            }
        } else {
            $error = "Vale e-post või salasõna.";
        }
    } else {
        $error = "Palun sisesta e-post ja salasõna.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Konto sisselogimine</title>
    <link rel="stylesheet" type="text/css" href="stiilid/style.css">
</head>
<body>
<div class="login-form">
    <div class="ring">
        <i style="--clr:#00ff0a;"></i>
        <i style="--clr:#ff0057;"></i>
        <i style="--clr:#fffd44;"></i>
        <i style="--clr:#581b98;"></i>
        <i style="--clr:#22d1ee;"></i>
        <div class="login-form">
            <h2>Logi sisse</h2>
            <?php if (isset($error)): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="inputBx">
                    <input type="text" name="email" placeholder="Email" required>
                </div>
                <div class="inputBx">
                    <input type="password" id="pass" name="pass" placeholder="Salasõna" required>
                </div>
                <div class="inputBx">
                    <input type="checkbox" id="showPass" onchange="togglePasswordVisibility()"> Näita salasõna
                </div>
                <div class="inputBx">
                    <input type="submit" value="Logi sisse">
                </div>
            </form>
            <form action="register.php" method="post">
                <div class="inputBx">
                    <input type="submit" value="Registreerimine">
                </div>
            </form>
            <form action="logout.php" method="post">
                <div class="inputBx">
                    <input type="submit" value="Tagasi">
                </div>
            </form>

        </div>
    </div>
</div>
<script>
    function togglePasswordVisibility() {
        var passInput = document.getElementById('pass');
        var showPassCheckbox = document.getElementById('showPass');

        passInput.type = showPassCheckbox.checked ? 'text' : 'password';
    }
</script>
</body>
</html>
