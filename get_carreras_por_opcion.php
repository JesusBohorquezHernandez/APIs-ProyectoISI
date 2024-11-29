<?php
include 'db_connection.php';

if (isset($_GET['opcion'])) {
    $opcion = $_GET['opcion'];

    // Relacionar las opciones con las carreras sugeridas
    switch ($opcion) {
        case 'A':
            $sql = "SELECT nombre FROM carreras WHERE nombre IN (
                        'Psicología', 'Derecho', 'Literatura', 'Historia')";
            break;
        case 'B':
            $sql = "SELECT nombre FROM carreras WHERE nombre IN (
                        'Ingeniería Civil', 'Ingeniería Industrial', 'Medicina', 'Ciencias de la Computación')";
            break;
        case 'C':
            $sql = "SELECT nombre FROM carreras WHERE nombre IN (
                        'Diseño Gráfico', 'Bellas Artes', 'Música')";
            break;
        case 'D':
            $sql = "SELECT nombre FROM carreras WHERE nombre IN (
                        'Trabajo Social', 'Medicina', 'Psicología')";
            break;
        default:
            echo json_encode(["error" => "Opción no válida"]);
            exit();
    }

    $result = $conn->query($sql);

    $carreras = array();
    while ($row = $result->fetch_assoc()) {
        $carreras[] = $row;
    }

    // Devolver resultado en formato JSON
    echo json_encode($carreras);
} else {
    echo json_encode(["error" => "No se ha especificado una opción"]);
}

$conn->close();
?>
