<?php
// Models/RepositorioUsuario.php

require_once __DIR__ . '/Usuario.php';

class RepositorioUsuario {
    private PDO $conexion;

    public function __construct(PDO $conexion) {
        $this->conexion = $conexion;
    }

    // Insertar un nuevo usuario en la base de datos
    public function registrar(Usuario $usuario): bool {
        $sql = "INSERT INTO usuarios (cedula, nombre, apellido, email, password, rol) 
                VALUES (:cedula, :nombre, :apellido, :email, :password, :rol)";
        
        $stmt = $this->conexion->prepare($sql);
        
        return $stmt->execute([
            ':cedula'   => $usuario->getCedula(),
            ':nombre'   => $usuario->getNombre(),
            ':apellido' => $usuario->getApellido(),
            ':email'    => $usuario->getEmail(),
            ':password' => $usuario->getPassword(),
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