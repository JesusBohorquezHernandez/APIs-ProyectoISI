<?php
$host = "localhost"; // O dirección del servidor MySQL
$user = "root"; // Usuario de la base de datos
$password = ""; // Contraseña de la base de datos
$database = "aptitud_vocacional"; // Nombre de la base de datos

// Crear la conexión
$conn = new mysqli($host, $user, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
