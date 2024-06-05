<?php if (isset($_GET['code'])) {die(highlight_file(__File__, 1)); }?>
<?php
require_once 'conf.php';
global $conn;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['pass'];

    $stmt = $conn->prepare("SELECT * FROM kasutajad WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Selle e-postiga kasutaja on juba olemas.";
    } else {

        $stmt = $conn->prepare("INSERT INTO kasutajad (Eesnimi, Perenimi, Email, Parool) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $firstName, $lastName, $email, $password);

        if ($stmt->execute()) {
            header("Location: login.php");
            exit();
        } else {
            echo "Viga: " . $stmt->error;
        }
    }

    $stmt->close();
    $conn->close();
}
?>