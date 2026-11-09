<?php
// Public/Index.php - Enrutador Front Controller (MVC)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Definir la URL base global de forma dinamica y portable
if (!defined('BASE_URL')) {
    $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
    $basePath = rtrim($scriptDir, '/') . '/';
    define('BASE_URL', $basePath);
}

// 1. Cargar la conexion a la base de datos
require_once __DIR__ . '/../config/conexion.php';

// 2. Cargar los controladores
require_once __DIR__ . '/../Controllers/ControllerUsuario.php';
require_once __DIR__ . '/../Controllers/ControllerLibro.php';
require_once __DIR__ . '/../Controllers/ControllerVenta.php';

// 3. Capturar la accion enviada por URL (por defecto 'inicio')
$action = $_GET['action'] ?? 'inicio';

// 4. Instanciar los controladores pasando la conexion PDO
$controllerUsuario = new ControllerUsuario($conexion);
$controllerLibro   = new ControllerLibro($conexion);
$controllerVenta   = new ControllerVenta($conexion);

// 5. Enrutador: Evaluar la accion requerida
switch ($action) {

    // --- ACCIONES DE USUARIO ---
    case 'login':
        $controllerUsuario->login();
        break;

    case 'registro':
        $controllerUsuario->registrar();
        break;

    case 'listar_usuarios':
        $controllerUsuario->listar();
        break;

    case 'editar_usuario':
        $controllerUsuario->editar();
        break;

    case 'actualizar_usuario':
        $controllerUsuario->actualizar();
        break;

    case 'eliminar_usuario':
        $controllerUsuario->eliminar();
        break;

    case 'logout':
        $controllerUsuario->logout();
        break;

    // --- ACCIONES DE LIBRO ---
    case 'buscar_isbn':
        $controllerLibro->buscarPorIsbn();
        break;

    case 'catalogo':
        $controllerLibro->catalogo();
        break;

    case 'listar_libros':
        $controllerLibro->listar();
        break;

    case 'guardar_resena':
        $controllerLibro->guardarResena();
        break;

    case 'formulario_libro':
        $controllerLibro->mostrarFormulario();
        break;

    case 'agregar_libro':
        $controllerLibro->crear();
        break;

    case 'editar_libro':
        $controllerLibro->editar();
        break;

    case 'actualizar_libro':
        $controllerLibro->actualizar();
        break;

    case 'eliminar_libro':
        $controllerLibro->eliminar();
        break;

    // --- ACCIONES DE RESERVA Y VENTA ---
    case 'reservar':
        $controllerVenta->reservar();
        break;

    case 'panel_reservas':
        $controllerVenta->panelReservas();
        break;

    case 'confirmar_venta':
        $controllerVenta->confirmarVenta();
        break;

    case 'cancelar_reserva':
        $controllerVenta->cancelarReserva();
        break;

    case 'mis_reservas':
        $controllerVenta->misReservas();
        break;

    // --- VISTA PRINCIPAL POR DEFECTO ---
    case 'inicio':
    default:
        $controllerLibro->listar();
        break;
}
