
<?php

$host = "localhost";
$puerto = 3306;
$dbname = "libreria";
$user = "root";
$pass = "5095627xd";

try {
    $conexion = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $user,
        $pass
    );

    $conexion->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

    $conexion->setAttribute(
        PDO::ATTR_DEFAULT_FETCH_MODE,
        PDO::FETCH_ASSOC
    );

} catch (PDOException $e) {
    error_log($e->getMessage());
    http_response_code(500);
    exit("Error: No se pudo conectar con la base de datos.<br><strong>Detalle:</strong> " . $e->getMessage());
}
