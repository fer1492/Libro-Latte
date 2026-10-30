<?php

class Libro {
    private $isbn;
    private $titulo;
    private $autor;
    private $precio;
    private $stock;
    private $descripcion;
    private $imagen;
    private $categoria;

    public function __construct(
        $isbn,
        $titulo,
        $autor,
        $precio,
        $stock,
        $descripcion = '',
        $imagen = '',
        $categoria = 'ficcion'
    ) {
        $this->isbn = $isbn;
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->precio = $precio;
        $this->stock = $stock;
        $this->descripcion = $descripcion;
        $this->imagen = $imagen;
        $this->categoria = $categoria;
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

    public function getCategoria() {
        return $this->categoria;
    }
}
?>