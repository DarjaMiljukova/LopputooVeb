<?php
$kasutaja='darja';
$serverinimi='localhost';
$parool='';
$andmebaas='projekt';
$conn=new mysqli($serverinimi, $kasutaja, $parool, $andmebaas);
if ($conn->connect_error) {
    die("Ühendus viga: " . $conn->connect_error);
}
?>
