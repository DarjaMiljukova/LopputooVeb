<?php if (isset($_GET['code'])) {die(highlight_file(__File__, 1)); }?>
<?php
session_start();

$_SESSION = array();

session_destroy();

header("Location: index.php");
exit();
?>