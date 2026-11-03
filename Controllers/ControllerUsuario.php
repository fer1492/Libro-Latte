<?php
// Controllers/ControllerUsuario.php

require_once __DIR__ . '/../Models/Usuario.php';
require_once __DIR__ . '/../Models/RepositorioUsuario.php';

class ControllerUsuario {
    private RepositorioUsuario $repo;

    public function __construct(PDO $conexion) {
        $this->repo = new RepositorioUsuario($conexion);
    }

    // --- 1. REGISTRO DE USUARIOS ---
    public function registrar() {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            header("Location: Index.php");
            exit;
        }

        $origen   = trim($_POST["origen"] ?? "inicio");
        $redirect = ($origen === 'catalogo') ? "Index.php?action=catalogo" : "Index.php";
        $sep      = (strpos($redirect, '?') !== false) ? '&' : '?';

        $nombre   = trim($_POST["nombre"] ?? "");
        $apellido = trim($_POST["apellido"] ?? "");
        $cedula   = preg_replace('/[^0-9]/', '', $_POST["cedula"] ?? "");
        $email    = trim(strtolower($_POST["email"] ?? ""));
        $password = $_POST["contrasena"] ?? "";

        // Validaciones básicas amigables (sin exit que rompa la pantalla)
        if (empty($cedula) || empty($nombre) || empty($email) || empty($password)) {
            header("Location: {$redirect}{$sep}error_registro=campos_vacios");
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: {$redirect}{$sep}error_registro=email_invalido");
            exit;
        }

        if (strlen($password) < 8) {
            header("Location: {$redirect}{$sep}error_registro=password_corta");
            exit;
        }

        try {
            // Verificar si la cédula ya existe para evitar errores fatales de SQL
            if ($this->repo->buscarPorCedula($cedula)) {
                header("Location: {$redirect}{$sep}error_registro=cedula_repetida");
                exit;
            }

            // Verificar si el email ya existe
            if ($this->repo->buscarPorEmail($email)) {
                header("Location: {$redirect}{$sep}error_registro=email_repetido");
                exit;
            }

            // Hashear contraseña de forma segura
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);

            // Crear entidad Usuario (con rol 'Socio')
            $usuario = new Usuario($cedula, $nombre, $email, $hashPassword, 'Socio', $apellido);

            // Guardar a través del repositorio
            $exito = $this->repo->registrar($usuario);

            if ($exito) {
                // Iniciar sesión automáticamente tras el registro
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }

                $_SESSION['usuario_cedula']   = $cedula;
                $_SESSION['usuario_nombre']   = $nombre;
                $_SESSION['usuario_apellido'] = $apellido;
                $_SESSION['usuario_rol']      = 'Socio';

                header("Location: {$redirect}{$sep}registro=ok");
                exit;
            } else {
                header("Location: {$redirect}{$sep}error_registro=fallo_bd");
                exit;
            }
        } catch (Exception $e) {
            error_log("Error en registro: " . $e->getMessage());
            header("Location: {$redirect}{$sep}error_registro=fallo_bd");
            exit;
        }
    }

    // --- 2. INICIO DE SESIÓN (LOGIN) ---
    public function login() {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            header("Location: Index.php");
            exit;
        }

        $origen   = trim($_POST["origen"] ?? "inicio");
        $redirect = ($origen === 'catalogo') ? "Index.php?action=catalogo" : "Index.php";
        $sep      = (strpos($redirect, '?') !== false) ? '&' : '?';

        $email    = trim(strtolower($_POST["email"] ?? ""));
        $password = $_POST["contrasena"] ?? "";

        if (empty($email) || empty($password)) {
            header("Location: {$redirect}{$sep}error_login=campos_vacios");
            exit;
        }

        // Buscamos si existe el usuario por email
        $usuarioBD = $this->repo->buscarPorEmail($email);

        if ($usuarioBD && password_verify($password, $usuarioBD['password'])) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // Guardamos los datos clave en la sesión
            $_SESSION['usuario_cedula']   = $usuarioBD['cedula'];
            $_SESSION['usuario_nombre']   = $usuarioBD['nombre'];
            $_SESSION['usuario_apellido'] = $usuarioBD['apellido'] ?? '';
            $_SESSION['usuario_rol']      = $usuarioBD['rol'];

            header("Location: {$redirect}{$sep}login=ok");
            exit;
        } else {
            header("Location: {$redirect}{$sep}error_login=credenciales_incorrectas");
            exit;
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

        header("Location: Index.php");
        exit;
    }

    // ==========================================
    // --- 4. GESTIÓN Y ADMINISTRACIÓN DE USUARIOS ---
    // ==========================================

    // Listar todos los usuarios para el panel de administración
    public function listar() {
        $usuarios = $this->repo->obtenerTodos();
        require_once __DIR__ . '/../Views/Usuario/listar_usuarios.php';
    }

    // Mostrar el formulario de edición para un usuario específico por su cédula
    public function editar() {
        $cedula = $_GET['id'] ?? null;
        if ($cedula) {
            $usuario = $this->repo->buscarPorCedula($cedula);
            if ($usuario) {
                require_once __DIR__ . '/../Views/Usuario/editar_usuario.php';
                return;
            }
        }
        header("Location: Index.php?action=listar_usuarios");
        exit;
    }

    // Procesar la actualización de datos del usuario desde el formulario
    public function actualizar() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $cedula   = $_POST['cedula'] ?? '';
            $nombre   = $_POST['nombre'] ?? '';
            $apellido = $_POST['apellido'] ?? '';
            $email    = $_POST['email'] ?? '';
            $rol      = $_POST['rol'] ?? '';

            if (!empty($cedula)) {
                $this->repo->actualizar($cedula, $nombre, $apellido, $email, $rol);
            }
        }
        header("Location: Index.php?action=listar_usuarios");
        exit;
    }

    // Eliminar un usuario del sistema por su cédula
    public function eliminar() {
        $cedula = $_GET['id'] ?? null;
        if ($cedula) {
            $this->repo->eliminar($cedula);
        }
        header("Location: Index.php?action=listar_usuarios");
        exit;
    }
}
?>