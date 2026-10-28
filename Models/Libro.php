<?php

class Libro {
    private $isbn;
    private $titulo;
    private $autor;
    private $precio;
    private $stock;
    private $descripcion;
    private $imagen;

    public function __construct($isbn, $titulo, $autor, $precio, $stock) {
        $this->isbn = $isbn;
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->precio = $precio;
        $this->stock = $stock;
        $this->descripcion = '';
        $this->imagen = '';
    }

    // Getters
   public function getIsbn() {
        return $this->isbn;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getAutor() {
        return $this->autor;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function getStock() {
        return $this->stock;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getImagen() {
        return $this->imagen;
    }
}
?>