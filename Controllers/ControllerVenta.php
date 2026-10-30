<?php
// Controllers/ControllerVenta.php

require_once __DIR__ . '/../Models/Venta.php';
require_once __DIR__ . '/../Models/RepositorioVenta.php';
require_once __DIR__ . '/../Models/RepositorioLibro.php';

class ControllerVenta {
    private RepositorioVenta $repoVenta;
    private RepositorioLibro $repoLibro;

    public function __construct(PDO $conexion) {
        $this->repoVenta = new RepositorioVenta($conexion);
        $this->repoLibro = new RepositorioLibro($conexion);
    }

    private function iniciarSesion() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    private function esBibliotecario(): bool {
        $this->iniciarSesion();
        $rol = strtolower(trim((string)($_SESSION['usuario_rol'] ?? '')));
        return in_array($rol, ['bibliotecario', 'admin', 'root']);
    }

    // --- 1. ACCIÓN DEL CLIENTE: Solicitar una reserva ---
    public function reservar() {
        $this->iniciarSesion();

        if (!isset($_SESSION['usuario_cedula'])) {
            header('Location: Index.php?action=catalogo&aviso=registro_requerido');
            exit;
        }

        // Regla de negocio: Administradores y bibliotecarios no pueden realizar reservas
        if ($this->esBibliotecario()) {
            header('Location: Index.php?action=catalogo&error=admin_no_puede_reservar');
            exit;
        }

        $isbn = trim($_POST['isbn'] ?? $_GET['isbn'] ?? '');
        $cantidad = (int)($_POST['cantidad'] ?? 1);
        if ($cantidad < 1) $cantidad = 1;

        if (empty($isbn)) {
            header('Location: Index.php?action=catalogo&error=isbn_invalido');
            exit;
        }

        // Consultar libro y existencia
        $libro = $this->repoLibro->buscarStockPorIsbn($isbn);
        if (!$libro) {
            header('Location: Index.php?action=catalogo&error=libro_no_encontrado');
            exit;
        }

        if ((int)$libro['stock'] < $cantidad) {
            header('Location: Index.php?action=catalogo&error=sin_stock');
            exit;
        }

        $precio = (float)$libro['precio'];
        $total = $precio * $cantidad;

        $venta = new Venta(
            $_SESSION['usuario_cedula'],
            $isbn,
            $cantidad,
            $total,
            'reserva'
        );

        $exito = $this->repoVenta->crearReserva($venta);

        if ($exito) {
            header('Location: Index.php?action=catalogo&reserva=ok');
        } else {
            header('Location: Index.php?action=catalogo&error=fallo_reserva');
        }
        exit;
    }

    // --- 2. ACCIÓN DEL CLIENTE: Ver sus propias reservas y compras ---
    public function misReservas() {
        $this->iniciarSesion();

        if (!isset($_SESSION['usuario_cedula'])) {
            header('Location: Index.php');
            exit;
        }

        $historial = $this->repoVenta->obtenerHistorialPorUsuario($_SESSION['usuario_cedula']);
        require __DIR__ . '/../Views/Venta/MisReservas.php';
    }

    // --- 3. ACCIÓN BIBLIOTECARIO/ROOT: Panel de gestión de reservas ---
    public function panelReservas() {
        if (!$this->esBibliotecario()) {
            http_response_code(403);
            exit('Acceso no autorizado. Esta sección es exclusiva para el personal bibliotecario.');
        }

        $reservas = $this->repoVenta->obtenerReservasPendientes();
        $ventasConcretadas = $this->repoVenta->obtenerVentasConcretadas();
        require __DIR__ . '/../Views/Venta/GestionReservas.php';
    }

    // --- 4. ACCIÓN BIBLIOTECARIO/ROOT: Confirmar y cobrar la venta ---
    public function confirmarVenta() {
        if (!$this->esBibliotecario()) {
            http_response_code(403);
            exit('Acceso denegado.');
        }

        $idVenta = (int)($_POST['id_venta'] ?? 0);
        if ($idVenta <= 0) {
            header('Location: Index.php?action=panel_reservas&error=id_invalido');
            exit;
        }

        $cedulaBibliotecario = $_SESSION['usuario_cedula'];
        $exito = $this->repoVenta->confirmarVenta($idVenta, $cedulaBibliotecario);

        if ($exito) {
            header('Location: Index.php?action=panel_reservas&venta=ok');
        } else {
            header('Location: Index.php?action=panel_reservas&error=sin_stock');
        }
        exit;
    }

    // --- 5. Cancelar reserva ---
    public function cancelarReserva() {
        $this->iniciarSesion();

        if (!isset($_SESSION['usuario_cedula'])) {
            header('Location: Index.php');
            exit;
        }

        $idVenta = (int)($_POST['id_venta'] ?? $_GET['id_venta'] ?? 0);
        if ($idVenta > 0) {
            $this->repoVenta->cancelarReserva($idVenta);
        }

        if ($this->esBibliotecario()) {
            header('Location: Index.php?action=panel_reservas&cancelada=ok');
        } else {
            header('Location: Index.php?action=mis_reservas&cancelada=ok');
        }
        exit;
    }
}
