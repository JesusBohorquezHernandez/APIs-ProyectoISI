<?php
$host = "localhost"; // Cambia esto según tu configuración
$user = "root"; // Cambia esto según tu configuración
$password = ""; // Cambia esto según tu configuración
$dbname = "aptitud_vocacional";

// Crear conexión
$conn = new mysqli($host, $user, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$universidad = $_GET['universidad'];

// Prepara la consulta SQL
$sql = "SELECT c.nombre FROM carreras c
        JOIN universidades_carreras uc ON c.id = uc.carrera_id
        JOIN universidades u ON uc.universidad_id = u.id
        WHERE u.nombre = ?";

// Prepara la sentencia
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error en la preparación de la consulta: " . $conn->error);
}
$stmt->bind_param("s", $universidad);
$stmt->execute();
$result = $stmt->get_result();

$programas = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $programas[] = array("nombre" => $row["nombre"]);
    }
}

echo json_encode($programas);

$stmt->close();
$conn->close();
?>
