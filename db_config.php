<?php
$kasutaja='darja';
$serverinimi='localhost';
$parool='';
$andmebaas='projekt';
$conn=new mysqli($serverinimi, $kasutaja, $parool, $andmebaas);
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}
?>