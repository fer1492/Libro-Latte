<?php
// Models/RepositorioVenta.php

require_once __DIR__ . '/Venta.php';

class RepositorioVenta {
    private PDO $conexion;

    public function __construct(PDO $conexion) {
        $this->conexion = $conexion;
    }

    // 1. Crear una nueva reserva de libro solicitada por un cliente
    public function crearReserva(Venta $venta): bool {
        $sql = "INSERT INTO ventas (usuario_cedula, libro_isbn, cantidad, total, estado) 
                VALUES (:cedula, :isbn, :cantidad, :total, :estado)";
        
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([
            ':cedula'   => $venta->getUsuarioCedula(),
            ':isbn'     => $venta->getLibroIsbn(),
            ':cantidad' => $venta->getCantidad(),
            ':total'    => $venta->getTotal(),
            ':estado'   => $venta->getEstado()
        ]);
    }

    // 2. Obtener todas las reservas pendientes para el panel del bibliotecario
    public function obtenerReservasPendientes(): array {
        $sql = "SELECT v.*, 
                       u.nombre AS usuario_nombre, 
                       u.apellido AS usuario_apellido,
                       u.email AS usuario_email, 
                       l.titulo AS libro_titulo, 
                       l.stock AS libro_stock,
                       l.precio AS libro_precio
                FROM ventas v
                INNER JOIN usuarios u ON v.usuario_cedula = u.cedula
                INNER JOIN libros l ON v.libro_isbn = l.isbn
                WHERE v.estado = 'reserva'
                ORDER BY v.fecha ASC";

        $stmt = $this->conexion->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 3. Confirmar la venta (solo bibliotecario/root): descuenta stock y cambia estado a 'vendido'
    public function confirmarVenta(int $idVenta, string $cedulaBibliotecario): bool {
        try {
            $this->conexion->beginTransaction();

            // Consultar datos de la reserva y bloquear la fila
            $sqlConsulta = "SELECT libro_isbn, cantidad, estado FROM ventas WHERE id = :id FOR UPDATE";
            $stmtConsulta = $this->conexion->prepare($sqlConsulta);
            $stmtConsulta->execute([':id' => $idVenta]);
            $reserva = $stmtConsulta->fetch(PDO::FETCH_ASSOC);

            if (!$reserva || $reserva['estado'] !== 'reserva') {
                $this->conexion->rollBack();
                return false;
            }

            // Descontar stock del libro asegurando que haya existencia
            $sqlStock = "UPDATE libros 
                         SET stock = stock - :cantidad 
                         WHERE isbn = :isbn AND stock >= :cantidad";
            $stmtStock = $this->conexion->prepare($sqlStock);
            $stmtStock->execute([
                ':cantidad' => $reserva['cantidad'],
                ':isbn'     => $reserva['libro_isbn']
            ]);

            if ($stmtStock->rowCount() === 0) {
                // Stock insuficiente
                $this->conexion->rollBack();
                return false;
            }

            // Cambiar estado a 'vendido' y registrar quién atendió
            $sqlVenta = "UPDATE ventas 
                         SET estado = 'vendido', atendido_por = :atendido_por 
                         WHERE id = :id";
            $stmtVenta = $this->conexion->prepare($sqlVenta);
            $stmtVenta->execute([
                ':atendido_por' => $cedulaBibliotecario,
                ':id'           => $idVenta
            ]);

            $this->conexion->commit();
            return true;
        } catch (Exception $e) {
            $this->conexion->rollBack();
            error_log("Error al confirmar venta: " . $e->getMessage());
            return false;
        }
    }

    // 4. Cancelar una reserva
    public function cancelarReserva(int $idVenta): bool {
        $sql = "UPDATE ventas SET estado = 'cancelado' WHERE id = :id AND estado = 'reserva'";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([':id' => $idVenta]);
    }

    // 5. Historial de compras/reservas de un usuario específico
    public function obtenerHistorialPorUsuario(string $cedula): array {
        $sql = "SELECT v.*, l.titulo AS libro_titulo 
                FROM ventas v
                INNER JOIN libros l ON v.libro_isbn = l.isbn
                WHERE v.usuario_cedula = :cedula
                ORDER BY v.fecha DESC";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([':cedula' => $cedula]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 6. Historial de todas las ventas concretadas (para reporte o auditoría del bibliotecario)
    public function obtenerVentasConcretadas(): array {
        $sql = "SELECT v.*, 
                       u.nombre AS cliente_nombre, 
                       u.apellido AS cliente_apellido,
                       l.titulo AS libro_titulo,
                       b.nombre AS atendido_por_nombre
                FROM ventas v
                INNER JOIN usuarios u ON v.usuario_cedula = u.cedula
                INNER JOIN libros l ON v.libro_isbn = l.isbn
                LEFT JOIN usuarios b ON v.atendido_por = b.cedula
                WHERE v.estado = 'vendido'
                ORDER BY v.fecha DESC";

        $stmt = $this->conexion->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
