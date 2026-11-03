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

    // Buscar usuario por Cédula (para evitar duplicados antes de registrar o editar)
    public function buscarPorCedula($cedula) {
        $sql = "SELECT * FROM usuarios WHERE cedula = :cedula";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([':cedula' => $cedula]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ==========================================
    // NUEVOS MÉTODOS PARA GESTIÓN DE USUARIOS
    // ==========================================

    // Obtener todos los usuarios registrados en el sistema
    public function obtenerTodos(): array {
        $sql = "SELECT * FROM usuarios";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Actualizar los datos de un usuario (usando la cédula como clave)
    public function actualizar($cedula, $nombre, $apellido, $email, $rol): bool {
        $sql = "UPDATE usuarios 
                SET nombre = :nombre, apellido = :apellido, email = :email, rol = :rol 
                WHERE cedula = :cedula";
        
        $stmt = $this->conexion->prepare($sql);
        
        return $stmt->execute([
            ':cedula'   => $cedula,
            ':nombre'   => $nombre,
            ':apellido' => $apellido,
            ':email'    => $email,
            ':rol'      => $rol
        ]);
    }

    // Eliminar un usuario por su cédula
    public function eliminar($cedula): bool {
        $sql = "DELETE FROM usuarios WHERE cedula = :cedula";
        $stmt = $this->conexion->prepare($sql);
        
        return $stmt->execute([':cedula' => $cedula]);
    }
}
?>