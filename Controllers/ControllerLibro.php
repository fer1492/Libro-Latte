<?php

require_once '../Models/RepositorioLibro.php';
require_once '../Models/Libro.php';

class ControllerLibro {
    private RepositorioLibro $repo;

  public function __construct($conexion) {
    $this->repo = new RepositorioLibro($conexion);
}

    public function listar($mensaje = '') {
        // Obtenemos los libros desde el repositorio de libros
        $libros = $this->repo->buscarlibro(); 
        require_once '../Views/inicio.php';
    }


    public function buscarPorIsbn() {
        $isbn = trim($_GET['isbn'] ?? '');
        $resultado = null;

        if (!empty($isbn)) {
            $resultado = $this->repo->buscarStockPorIsbn($isbn);
        }

    }

    public function crear() {
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            // 1. Leemos los 5 datos del formulario
            $isbn   = $_POST['isbn'] ?? '';
            $titulo = $_POST['titulo'] ?? '';
            $autor  = $_POST['autor'] ?? '';
            $precio = $_POST['precio'] ?? 0;
            $stock  = $_POST['stock'] ?? 0;

            // 2. Pasamos los 5 argumentos exactos que requiere la clase Libro
            $libro = new Libro($isbn, $titulo, $autor, $precio, $stock);
            
            // 3. Guardamos en BD mediante el repositorio
            $this->repo->agregarLibro($libro);

            $this->listar();
            return;
        } catch (Exception $e) {
            $mensaje = 'Error: ' . $e->getMessage();
        }
    }

    require_once '../Views/inicio.php';
}
}
