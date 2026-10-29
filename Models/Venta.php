<?php
// Models/Venta.php

class Venta {
    private $id;
    private $usuarioCedula;
    private $libroIsbn;
    private $cantidad;
    private $total;
    private $fecha;
    private $estado;       // 'reserva', 'vendido', 'cancelado'
    private $atendidoPor;  // Cédula del bibliotecario/root que atiende la venta

    public function __construct(
        $usuarioCedula,
        $libroIsbn,
        $cantidad,
        $total,
        $estado = 'reserva',
        $atendidoPor = null,
        $id = null,
        $fecha = null
    ) {
        $this->usuarioCedula = $usuarioCedula;
        $this->libroIsbn     = $libroIsbn;
        $this->cantidad      = $cantidad;
        $this->total         = $total;
        $this->estado        = $estado;
        $this->atendidoPor   = $atendidoPor;
        $this->id            = $id;
        $this->fecha         = $fecha;
    }

    // --- GETTERS ---
    public function getId() { return $this->id; }
    public function getUsuarioCedula() { return $this->usuarioCedula; }
    public function getLibroIsbn() { return $this->libroIsbn; }
    public function getCantidad() { return $this->cantidad; }
    public function getTotal() { return $this->total; }
    public function getFecha() { return $this->fecha; }
    public function getEstado() { return $this->estado; }
    public function getAtendidoPor() { return $this->atendidoPor; }

    // --- SETTERS ---
    public function setEstado($estado) { $this->estado = $estado; }
    public function setAtendidoPor($atendidoPor) { $this->atendidoPor = $atendidoPor; }
}
