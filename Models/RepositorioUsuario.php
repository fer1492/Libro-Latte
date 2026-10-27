<?php
// Models/RepositorioUsuario.php

require_once 'Usuario.php';

class RepositorioUsuario {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // Insertar un nuevo usuario en la base de datos
    public function registrar(Usuario $usuario) {
        $sql = "INSERT INTO usuarios (cedula, nombre, email, password, rol) 
                VALUES (:cedula, :nombre, :email, :password, :rol)";
        
        $stmt = $this->conexion->prepare($sql);
        
        return $stmt->execute([
            ':cedula'   => $usuario->getCedula(),
            ':nombre'   => $usuario->getNombre(),
            ':email'    => $usuario->getEmail(),
            ':password' => $usuario->getPassword(), // Ya debe venir hasheada desde el Controller
            ':rol'      => $usuario->getRol()
        ]);
    }

    // Buscar usuario por Email (para la validación de Login)
    public function buscarPorEmail($email) {
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([':email' => $email]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Buscar usuario por Cédula (para evitar duplicados antes de registrar)
    public function buscarPorCedula($cedula) {
        $sql = "SELECT * FROM usuarios WHERE cedula = :cedula";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([':cedula' => $cedula]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>