<?php

require_once 'Libro.php';

class RepositorioLibro {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // Guardar un nuevo libro en la base de datos
    public function agregarLibro(Libro $libro) {
        $sql = "INSERT INTO libros (isbn, titulo, autor, precio, stock) 
                VALUES (:isbn, :titulo, :autor, :precio, :stock)";
        
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([
            ':isbn'   => $libro->getIsbn(),
            ':titulo' => $libro->getTitulo(),
            ':autor'  => $libro->getAutor(),
            ':precio' => $libro->getPrecio(),
            ':stock'  => $libro->getStock()
        ]);
    }

    // Obtener todos los libros para el catálogo general
    public function buscarlibro() {
        $sql = "SELECT * FROM libros";
        $stmt = $this->conexion->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar únicamente el título y stock filtrando por ISBN
    public function buscarStockPorIsbn($isbn) {
        $sql = "SELECT titulo, stock FROM libros WHERE isbn = :isbn";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([':isbn' => $isbn]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
