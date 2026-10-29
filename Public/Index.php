<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Public/index.php

// 1. Cargar la conexión a la base de datos
require_once '../config/conexion.php';

// 2. Cargar los controladores
require_once '../Controllers/ControllerUsuario.php';
require_once '../Controllers/ControllerLibro.php';
require_once '../Controllers/ControllerVenta.php';

// 3. Capturar la acción enviada por URL (si no hay ninguna, la acción por defecto es 'inicio')
$action = $_GET['action'] ?? 'inicio';

// 4. Instanciar los controladores pasando la conexión PDO
$controllerUsuario = new ControllerUsuario($conexion);
$controllerLibro   = new ControllerLibro($conexion);
$controllerVenta   = new ControllerVenta($conexion);

// 5. Enrutador: Evaluar la acción requerida
switch ($action) {

    // --- ACCIONES DE USUARIO ---
    case 'login':
        $controllerUsuario->login();
        break;

    case 'registro':
        $controllerUsuario->registrar();
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

    // --- ACCIONES AGREGAR LIBRO (SOLO BIBLIOTECARIO) ---
    case 'formulario_libro':
        $controllerLibro->mostrarFormulario();
        break;

    case 'agregar_libro':
        $controllerLibro->crear();
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
        require_once '../Views/inicio.php';
        break;
}
?>
