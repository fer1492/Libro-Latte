<?php


require_once '../Models/Usuario.php';
require_once '../Models/RepositorioUsuario.php';

class ControllerUsuario {
    private RepositorioUsuario $repo;

    public function __construct($conexion) {
        $this->repo = new RepositorioUsuario($conexion);
    }

    // --- 1. REGISTRO DE USUARIOS ---
    public function registrar() {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            header("Location: index.php");
            exit;
        }

        $nombre   = trim($_POST["nombre"] ?? "");
        $apellido = trim($_POST["apellido"] ?? ""); // Concatenamos si quieres guardar nombre completo
        $cedula   = trim($_POST["cedula"] ?? "");
        $email    = trim($_POST["email"] ?? "");
        $password = $_POST["contrasena"] ?? "";

        $nombreCompleto = trim("$nombre $apellido");

        // Validaciones básicas
        if (empty($cedula) || empty($nombreCompleto) || empty($email) || empty($password)) {
            exit("Por favor, completa todos los campos requeridos.");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            exit("El email no tiene un formato válido.");
        }

        if (strlen($password) < 8) {
            exit("La contraseña debe tener al menos 8 caracteres.");
        }

        // Hasheamos la contraseña antes de crear la Entidad Usuario
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);

        // Instanciamos el modelo Usuario con las variables exactas de tu imagen
        $usuario = new Usuario($cedula, $nombreCompleto, $email, $hashPassword, 'cliente');

        // Guardamos a través del repositorio
        $exito = $this->repo->registrar($usuario);

        if ($exito) {
            header("Location: index.php?registro=ok");
            exit;
        } else {
            exit("Ocurrió un error al registrar el usuario.");
        }
    }

    // --- 2. INICIO DE SESIÓN (LOGIN) ---
    public function login() {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            header("Location: index.php");
            exit;
        }

        $email    = trim($_POST["email"] ?? "");
        $password = $_POST["contrasena"] ?? "";

        if (empty($email) || empty($password)) {
            exit("Ingresa email y contraseña.");
        }

        // Buscamos si existe el usuario por email
        $usuarioBD = $this->repo->buscarPorEmail($email);

        if ($usuarioBD && password_verify($password, $usuarioBD['password'])) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // Guardamos los datos clave en la sesión
            $_SESSION['usuario_cedula'] = $usuarioBD['cedula'];
            $_SESSION['usuario_nombre']   = $usuarioBD['nombre'];
            $_SESSION['usuario_apellido'] = $usuarioBD['apellido'] ?? '';
            $_SESSION['usuario_rol']    = $usuarioBD['rol'];

            header("Location: index.php?login=ok");
            exit;
        } else {
            exit("Email o contraseña incorrectos.");
        }
    }

    // --- 3. CERRAR SESIÓN (LOGOUT) ---
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION = array();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(), 
                '', 
                time() - 42000,
                $params["path"], 
                $params["domain"],
                $params["secure"], 
                $params["httponly"]
            );
        }

        session_destroy();

        header("Location: index.php");
        exit;
    }
}
?>