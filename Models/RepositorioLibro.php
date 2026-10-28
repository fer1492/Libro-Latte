<?php

require_once __DIR__ . '/Libro.php';

class RepositorioLibro {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // Guardar un nuevo libro en la base de datos
    public function agregarLibro(Libro $libro) {
        $sql = "INSERT INTO libros
                (isbn, titulo, autor, precio, stock, descripcion, imagen)
                VALUES
                (:isbn, :titulo, :autor, :precio, :stock, :descripcion, :imagen)";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            ':isbn'        => $libro->getIsbn(),
            ':titulo'      => $libro->getTitulo(),
            ':autor'       => $libro->getAutor(),
            ':precio'      => $libro->getPrecio(),
            ':stock'       => $libro->getStock(),
            ':descripcion' => $libro->getDescripcion(),
            ':imagen'      => $libro->getImagen()
        ]);
    }

    // Obtener todos los libros
    public function buscarlibro() {
        $sql = "SELECT * FROM libros";

        $stmt = $this->conexion->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar título y stock por ISBN
    public function buscarStockPorIsbn($isbn) {
    $sql = "SELECT isbn, titulo, autor, precio, stock
            FROM libros
            WHERE isbn = :isbn";

    $stmt = $this->conexion->prepare($sql);
    $stmt->execute([':isbn' => $isbn]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

    // Obtener libros que tienen stock disponible
    public function buscarDisponible() {
        $sql = "SELECT isbn, titulo, autor, precio, stock, descripcion, imagen
                FROM libros
                WHERE stock > 0
                ORDER BY titulo ASC";

        $stmt = $this->conexion->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>