<?php
$kasutaja='darja';
$serverinimi='localhost';
$parool='';
$andmebaas='projekt';
$yhendus=new mysqli($serverinimi,$kasutaja,$parool,$andmebaas);
$yhendus->set_charset('UTF8');