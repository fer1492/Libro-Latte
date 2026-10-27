

<!-- Views/registro.php -->
<div id="modal-register" class="modal">
    <button class="close-button">x</button>

    <h3>Registrate</h3>

    <form id="form-modal-register" action="index.php?action=registro" method="POST">

        <label for="reg-nombre">Nombre</label>
        <input type="text" id="reg-nombre" name="nombre" required>

        <label for="reg-apellido">Apellido</label>
        <input type="text" id="reg-apellido" name="apellido" required>

        <label for="reg-cedula">Cédula (sin puntos ni guiones)</label>
        <input type="text" id="reg-cedula" name="cedula" required>

        <label for="reg-email">Email</label>
        <input type="email" id="reg-email" name="email" required>

        <label for="reg-contrasena">Contraseña</label>
        <input type="password" id="reg-contrasena" name="contrasena" minlength="8" required>
            
        <button type="submit">Registrar</button>

    </form>
</div>

<?php
require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: Front/index.html");
    exit;
}

$nombre = trim($_POST["nombre"] ?? "");
$apellido = trim($_POST["apellido"] ?? "");
$cedula = trim($_POST["cedula"] ?? "");
$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";

if (
    $nombre === "" ||
    $apellido === "" ||
    $cedula === "" ||
    $email === "" ||
    $password === ""
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

if (strlen($password) < 8) {
    exit("La contraseña debe tener al menos 8 caracteres, verifica");
}

$hash = password_hash($password, PASSWORD_DEFAULT);

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

    header("Location: Front/index.html?registro=ok");
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