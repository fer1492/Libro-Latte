<?php

session_start();
require_once "conexion.php"; 

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: Front/index.html");
    exit;
}

$email = trim($_POST["email"] ?? "");
$contrasena = $_POST["contrasena"] ?? "";

$sql = "SELECT cedula, nombre, apellido, email, contrasena
        FROM usuario
        WHERE email = :email
        LIMIT 1";

$stmt = $conexion->prepare($sql);
$stmt->execute([":email" => $email]);

$usuario = $stmt->fetch();

if(
    $usuario &&
    password_verify($contrasena, $usuario["contrasena"])
) {
    session_regenerate_id(true);

    $_SESSION["cedula"] = $usuario["cedula"];
    $_SESSION["nombre"] = $usuario["nombre"];
    $_SESSION["apellido"] = $usuario["apellido"];
    $_SESSION["email"] = $usuario["email"];

    header("Location: inicio.php");
    exit;
}

http_response_code(401);
exit("El email o contraseña son incorrecto :( ");