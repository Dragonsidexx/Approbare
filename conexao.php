<?php
$mysqli = new mysqli("localhost", "root", "", "hells");

if ($mysqli->connect_error) {
    die("Falha na conexão: " . $mysqli->connect_error);
}
?>
