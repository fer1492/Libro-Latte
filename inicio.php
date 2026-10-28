<?php
session_start();

if(!isset($_SESSION["cedula"])) {
    header("Location: Front/index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mi Cuenta</title>
    <link rel="stylesheet" href="/Pagina Biblioteca/Style.css">
    <link rel="stylesheet" href="/Pagina Biblioteca/Media Querry.css">
</head>
<body>
    <h1>
        Hola y bienvenido,
        <?= htmlspecialchars($_SESSION["nombre"], ENT_QUOTES, "UTF-8") ?>
        <?= htmlspecialchars($_SESSION["apellido"], ENT_QUOTES, "UTF-8") ?>
    </h1>
    <p>Iniciaste sesion correctamente :D</p>

    <a href="logout.php">Cerrar Sesión</a>
</body>
</html>