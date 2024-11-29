<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aptitud_vocacional";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consultar universidades, carreras y su relación
$sql = "SELECT u.nombre AS universidad, c.nombre AS carrera, ci.nombre AS ciudad
        FROM universidades u
        JOIN universidades_carreras uc ON u.id = uc.universidad_id
        JOIN carreras c ON c.id = uc.carrera_id
        JOIN ciudades ci ON ci.id = u.ciudad_id";
$result = $conn->query($sql);

$universidades = [];
while($row = $result->fetch_assoc()) {
    $universidades[] = $row;
}
?>