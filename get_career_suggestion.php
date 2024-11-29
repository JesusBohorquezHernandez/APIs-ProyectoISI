<?php
header('Content-Type: application/json');

// Conectar a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aptitud_vocacional";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtener las áreas seleccionadas
$selectedAreas = $_GET['area']; // Esperamos algo como 'Ingeniería y Tecnología,Salud y Medicina'

// Convertir la cadena en un array
$areasArray = explode(',', $selectedAreas);

// Escapar cada área para evitar inyección SQL
$areasArray = array_map(function($area) use ($conn) {
    return "'" . $conn->real_escape_string(trim($area)) . "'";
}, $areasArray);

// Convertir el array en una cadena para la consulta SQL
$areasString = implode(',', $areasArray);

// Preparar la consulta
$sql = "SELECT nombre FROM carreras WHERE area IN ($areasString)";
$result = $conn->query($sql);

// Recoger las sugerencias
$suggestions = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $suggestions[] = $row['nombre'];
    }
}

// Cerrar la conexión
$conn->close();

// Devolver las sugerencias como JSON
echo json_encode($suggestions);
?>
