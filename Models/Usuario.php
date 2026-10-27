<?php
// Models/Usuario.php

class Usuario {
    private $cedula;
    private $nombre;
    private $email;
    private $password;
    private $rol;

    public function __construct($cedula, $nombre, $email, $password, $rol = 'cliente') {
        $this->cedula   = $cedula;
        $this->nombre   = $nombre;
        $this->email    = $email;
        $this->password = $password;
        $this->rol      = $rol;
    }

    // --- GETTERS ---
    public function getCedula() {
        return $this->cedula;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getRol() {
        return $this->rol;
    }

    // --- SETTERS ---
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setRol($rol) {
        $this->rol = $rol;
    }
}
?>