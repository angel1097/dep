<?php
$servername = "monorail.proxy.rlwy.net";
$username = "root";
$password = "RsDWqdhoFigsqrwkxCgRVeBVnsjIPWyV";
$dbname = "depitzel";
$port = 59940;  // Agrega el puerto aquí

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
