<?php
include 'db_connection.php';

if (isset($_GET['ciudad'])) {
    $ciudad = $_GET['ciudad'];

    // Consulta SQL para obtener universidades por ciudad
    $sql = "SELECT nombre FROM universidades WHERE ciudad_id = (SELECT id FROM ciudades WHERE nombre = ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $ciudad);
    $stmt->execute();
    $result = $stmt->get_result();

    $universidades = array();
    while ($row = $result->fetch_assoc()) {
        $universidades[] = $row;
    }

    // Devolver resultado en formato JSON
    echo json_encode($universidades);
} else {
    echo json_encode(["error" => "No se ha especificado una ciudad"]);
}

$stmt->close();
$conn->close();
?>
