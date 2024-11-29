<?php
// Conectar a la base de datos
include 'db_connection.php';

// Obtener la carrera seleccionada desde la solicitud GET
$carrera = $_GET['carrera'];

// Consulta para obtener las universidades relacionadas con la carrera seleccionada
$query = "SELECT u.id, u.nombre 
          FROM universidades u
          JOIN universidades_carreras uc ON u.id = uc.universidad_id
          JOIN carreras c ON c.id = uc.carrera_id
          WHERE c.nombre = '$carrera'";

$result = mysqli_query($conn, $query);

$universidades = array();
while ($row = mysqli_fetch_assoc($result)) {
    $universidades[] = array(
        "id" => $row['id'], // Agregar el ID de la universidad
        "nombre" => $row['nombre']
    );
}

// Devolver los resultados en formato JSON
header('Content-Type: application/json'); // Asegurarse de que el tipo de contenido es JSON
echo json_encode($universidades);
?>

