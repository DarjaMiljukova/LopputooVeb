<?php if (isset($_GET['code'])) {die(highlight_file(__File__, 1)); }?>
<?php
session_start();
require_once 'conf.php';
global $conn;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM kasutajad WHERE Email='$email' AND Parool='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['userId'] = $row['Id'];
        $_SESSION['isAdmin'] = $row['onAdmin'];
        header("Location: user_dashboard.php");
        exit();
    } else {
        echo "Неверный email или пароль.";
    }
}
?>
