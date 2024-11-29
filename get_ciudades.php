<?php
$host = "localhost"; 
$user = "root"; 
$password = ""; 
$dbname = "aptitud_vocacional";

// Crear conexión
$conn = new mysqli($host, $user, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Realizar la consulta
$sql = "SELECT * FROM ciudades";
$result = $conn->query($sql);

$ciudades = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $ciudades[] = array("nombre" => $row["nombre"]);
    }
}

// Devolver los resultados en formato JSON
echo json_encode($ciudades);

$conn->close();
?>
