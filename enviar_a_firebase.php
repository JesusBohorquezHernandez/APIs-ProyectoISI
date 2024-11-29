<?php

// 1. Conexión a la base de datos MySQL
$host = "localhost"; // O dirección del servidor MySQL
$user = "root"; // Usuario de la base de datos
$password = ""; // Contraseña de la base de datos
$database = "aptitud_vocacional"; // Nombre de la base de datos

// Crear la conexión
$conn = new mysqli($host, $user, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// 2. Consultar las universidades, carreras y su relación
$sql = "SELECT u.id AS universidad_id, u.nombre AS universidad_nombre, u.direccion, u.tipo AS universidad_tipo, u.sitio_web, 
               c.id AS carrera_id, c.nombre AS carrera_nombre, c.tipo AS carrera_tipo, c.area AS carrera_area, 
               ci.id AS ciudad_id, ci.nombre AS ciudad_nombre
        FROM universidades u
        JOIN universidades_carreras uc ON u.id = uc.universidad_id
        JOIN carreras c ON c.id = uc.carrera_id
        JOIN ciudades ci ON u.ciudad_id = ci.id";

$result = $conn->query($sql);

// 3. Verificar si hay resultados
echo "Número de resultados: " . $result->num_rows; // Para depuración
if ($result->num_rows > 0) {
    // 4. Preparar los datos para Firebase
    $universidades = [];
    while($row = $result->fetch_assoc()) {
        // Asegurarse de que cada universidad sea única
        $universidad_id = $row['universidad_id'];
        
        if (!isset($universidades[$universidad_id])) {
            $universidades[$universidad_id] = [
                'nombre' => $row['universidad_nombre'],
                'direccion' => $row['direccion'],
                'tipo' => $row['universidad_tipo'],
                'sitio_web' => $row['sitio_web'],
                'ciudad' => [
                    'id' => $row['ciudad_id'],
                    'nombre' => $row['ciudad_nombre']
                ],
                'carreras' => []
            ];
        }

        // Añadir las carreras a la universidad correspondiente
        $universidades[$universidad_id]['carreras'][] = [
            'id' => $row['carrera_id'],
            'nombre' => $row['carrera_nombre'],
            'tipo' => $row['carrera_tipo'],
            'area' => $row['carrera_area']
        ];
    }

    // 5. Convertir los datos a formato JSON
    $json_data = json_encode($universidades, JSON_PRETTY_PRINT);

    // Depuración: Mostrar el JSON antes de enviarlo
    echo '<pre>';
    echo $json_data;
    echo '</pre>';

    // 6. Enviar los datos a Firebase
    $firebase_url = 'https://apptitudetest-1fbc8-default-rtdb.firebaseio.com/universidades.json';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $firebase_url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);

    $response = curl_exec($ch);
    curl_close($ch);

    // 7. Verificar si el envío fue exitoso
    echo '<pre>';
    print_r($response); // Depuración: Mostrar respuesta de Firebase
    echo '</pre>';

} else {
    echo "No se encontraron resultados.";
}

// 8. Cerrar la conexión a la base de datos
$conn->close();

?>
