<?php

require_once __DIR__ . '/Libro.php';

class RepositorioLibro {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // Guardar un nuevo libro en la base de datos con su categoría
    public function agregarLibro(Libro $libro) {
        $sql = "INSERT INTO libros
                (isbn, titulo, autor, precio, stock, descripcion, imagen, categoria)
                VALUES
                (:isbn, :titulo, :autor, :precio, :stock, :descripcion, :imagen, :categoria)";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            ':isbn'        => $libro->getIsbn(),
            ':titulo'      => $libro->getTitulo(),
            ':autor'       => $libro->getAutor(),
            ':precio'      => $libro->getPrecio(),
            ':stock'       => $libro->getStock(),
            ':descripcion' => $libro->getDescripcion(),
            ':imagen'      => $libro->getImagen(),
            ':categoria'   => $libro->getCategoria()
        ]);
    }

    // Obtener todos los libros
    public function buscarlibro() {
        $sql = "SELECT isbn, titulo, autor, precio, stock, descripcion, imagen, categoria FROM libros";
        $stmt = $this->conexion->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar título, stock y demás datos por ISBN
    public function buscarStockPorIsbn($isbn) {
        $sql = "SELECT isbn, titulo, autor, precio, stock, descripcion, imagen, categoria
                FROM libros
                WHERE isbn = :isbn";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([':isbn' => $isbn]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtener libros que tienen stock disponible
    public function buscarDisponible() {
        $sql = "SELECT isbn, titulo, autor, precio, stock, descripcion, imagen, categoria
                FROM libros
                WHERE stock > 0
                ORDER BY titulo ASC";

        $stmt = $this->conexion->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener libros filtrados por categoría
    public function buscarPorCategoria($categoria) {
        $sql = "SELECT isbn, titulo, autor, precio, stock, descripcion, imagen, categoria
                FROM libros
                WHERE categoria = :categoria
                ORDER BY titulo ASC";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([':categoria' => $categoria]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
