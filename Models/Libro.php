<?php

class Libro {
    private $isbn;
    private $titulo;
    private $autor;
    private $precio;
    private $stock;

    public function __construct($isbn, $titulo, $autor, $precio, $stock) {
        $this->isbn = $isbn;
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->precio = $precio;
        $this->stock = $stock;
    }

    // Getters
    public function getIsbn() { return $this->isbn; }
    public function getTitulo() { return $this->titulo; }
    public function getAutor() { return $this->autor; }
    public function getPrecio() { return $this->precio; }
    public function getStock() { return $this->stock; }
}
?>