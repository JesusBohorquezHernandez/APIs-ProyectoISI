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

// Asegúrate de que los parámetros están presentes
if (!isset($_GET['universidad']) || !isset($_GET['ciudad'])) {
    echo json_encode(array("error" => "No se han especificado todos los parámetros"));
    exit; // Terminar la ejecución del script si faltan parámetros
}

$universidad = $_GET['universidad'];
$ciudad = $_GET['ciudad'];

// Prepara la consulta SQL
$sql = "SELECT c.nombre FROM carreras c
        JOIN universidades_carreras uc ON c.id = uc.carrera_id
        JOIN universidades u ON uc.universidad_id = u.id
        JOIN ciudades ci ON u.ciudad_id = ci.id
        WHERE u.nombre = ? AND ci.nombre = ?"; // Cambia 'ciudad_id' por el nombre correcto de tu columna de relación

// Prepara la sentencia
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error en la preparación de la consulta: " . $conn->error);
}
$stmt->bind_param("ss", $universidad, $ciudad);
$stmt->execute();
$result = $stmt->get_result();

$programas = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $programas[] = array("nombre" => $row["nombre"]);
    }
}

echo json_encode($programas);

// Cierra la sentencia y la conexión
$stmt->close();
$conn->close();
?>
