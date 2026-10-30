<?php

require_once __DIR__ . '/../Models/RepositorioLibro.php';
require_once __DIR__ . '/../Models/Libro.php';

class ControllerLibro
{
    private RepositorioLibro $repo;

    public function __construct($conexion)
    {
        $this->repo = new RepositorioLibro($conexion);
    }

    // Se inicia la sesión en caso de que no esté iniciada
    private function iniciarSesion() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Comprueba que el usuario sea bibliotecario o admin
    private function esBibliotecario() {
        $this->iniciarSesion();

        return isset($_SESSION['usuario_rol']) &&
            in_array(strtolower(trim((string) $_SESSION['usuario_rol'])), ['bibliotecario', 'admin', 'root']);
    }

    // Mostrar la página de inicio con los libros cargados
    public function listar($mensaje = '')
    {
        $libros = $this->repo->buscarlibro();

        require __DIR__ . '/../Views/inicio.php';
    }

    // Buscar un libro por su ISBN
    public function buscarPorIsbn()
    {
        $isbn = trim($_GET['isbn'] ?? '');

        $resultado = null;
        $mensajeBusqueda = '';

        if ($isbn === '') {
            $mensajeBusqueda = 'Ingresá un ISBN para realizar la búsqueda.';
        } else {
            $resultado = $this->repo->buscarStockPorIsbn($isbn);

            if (!$resultado) {
                $mensajeBusqueda = 'No se encontró ningún libro con ese ISBN.';
            }
        }

        // Cargamos también los libros de categorías para que la sección de inicio no quede vacía
        $libros = $this->repo->buscarlibro();

        require __DIR__ . '/../Views/inicio.php';
    }

    // Muestra formulario solo a bibliotecario
    public function mostrarFormulario() {
        if (!$this->esBibliotecario()) {
            http_response_code(403);
            exit('No tenes permiso para acceder a esta seccion.');
        }

        $mensaje = '';
        require __DIR__ . '/../Views/agregar_Libro.php';
    }

    // Registrar un libro SOLO BIBLIOTECARIO
    public function crear()
    {
        if (!$this->esBibliotecario()) {
            http_response_code(403);
            exit('No tienes permiso para registrar libros.');
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: Index.php?action=formulario_libro');
            exit;
        }

        $mensaje = '';

        try {
            $isbn        = trim($_POST['isbn'] ?? '');
            $titulo      = trim($_POST['titulo'] ?? '');
            $autor       = trim($_POST['autor'] ?? '');
            $categoria   = trim($_POST['categoria'] ?? 'ficcion');
            $precio      = $_POST['precio'] ?? '';
            $stock       = $_POST['stock'] ?? '';
            $descripcion = trim($_POST['descripcion'] ?? '');
            $imagen      = trim($_POST['imagen'] ?? '');

            if (
                $isbn === '' ||
                $titulo === '' ||
                $autor === '' ||
                $precio === '' ||
                $stock === ''
            ) {
                throw new Exception('Completá todos los campos obligatorios.');
            }

            if (!is_numeric($precio) || (float) $precio < 0) {
                throw new Exception('El precio debe ser un número igual o mayor que cero.');
            }

            if (
                filter_var($stock, FILTER_VALIDATE_INT) === false ||
                (int) $stock < 0
            ) {
                throw new Exception('El stock debe ser un número entero igual o mayor que cero.');
            }

            $libro = new Libro(
                $isbn,
                $titulo,
                $autor,
                (float) $precio,
                (int) $stock,
                $descripcion,
                $imagen,
                $categoria
            );

            $this->repo->agregarLibro($libro);

            header('Location: Index.php?action=formulario_libro&registro_libro=ok');
            exit;

        } catch (PDOException $e) {
            error_log($e->getMessage());

            $mensaje = 'No se pudo registrar el libro. Verificá que el ISBN no esté repetido y que los datos sean correctos.';

        } catch (Exception $e) {
            $mensaje = $e->getMessage();
        }

        require __DIR__ . '/../Views/agregar_Libro.php';
    }

    // Mostrar catálogo
    public function catalogo()
    {
        $libros = $this->repo->buscarDisponible();

        require __DIR__ . '/../Views/catalogo.php';
    }
}
