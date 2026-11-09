<?php
require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: Front/index.php");
    exit;
}

$nombre = trim($_POST["nombre"] ?? "");
$apellido = trim($_POST["apellido"] ?? "");
$cedula = trim($_POST["cedula"] ?? "");
$email = trim($_POST["email"] ?? "");
$contrasena = $_POST["contrasena"] ?? "";

if (
    $nombre === "" ||
    $apellido === "" ||
    $cedula === "" ||
    $email === "" ||
    $contrasena === ""
) {
    exit("Por favor, completa todos los campos para continuar :) ");
}

if (
    strlen($nombre) > 70 ||
    strlen($apellido) > 70 ||
    strlen($cedula) > 20 ||
    strlen($email) > 254
) {
    exit("Uno de los campos ingresados supera el maximo permitido :( ");
}

if (!preg_match('/^[0-9]{1,20}$/', $cedula)) {
    exit("La cédula debe contener solo números o.O ");
}

if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit("El email no tiene el formato valido, verifica.");
}

if (strlen($contrasena) < 8) {
    exit("La contraseña debe tener al menos 8 caracteres, verifica");
}

$hash = password_hash($contrasena, PASSWORD_DEFAULT);

try {
    $sql = "INSERT INTO usuarios
            (nombre, apellido, cedula, email, password)
            VALUES
            (:nombre, :apellido, :cedula, :email, :password)";
    
    $stmt = $conexion->prepare($sql);

    $stmt->execute([
        ":nombre" => $nombre,
        ":apellido" => $apellido,
        ":cedula" => $cedula,
        ":email" => $email,
        ":password" => $hash
    ]);

    header("Location: Front/index.php?registro=ok");
    exit;

} catch (PDOException $e) {
    if ($e->getcode() === "23000") {
        http_response_code(409);
        exit("Cedula o email ya estan registrados O.o ");
    }

    error_log($e->getmessage());
    http_response_code(500);
    exit("Ocurrio un error, no se puso completar el registro");
}
?>