
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

    // Mostrar la página de inicio con los libros
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

        require __DIR__ . '/../Views/inicio.php';
    }

    // Registrar un libro
    public function crear()
    {
        $mensaje = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $isbn        = trim($_POST['isbn'] ?? '');
                $titulo      = trim($_POST['titulo'] ?? '');
                $autor       = trim($_POST['autor'] ?? '');
                $precio      = $_POST['precio'] ?? 0;
                $stock       = $_POST['stock'] ?? 0;
                $descripcion = trim($_POST['descripcion'] ?? '');
                $imagen      = trim($_POST['imagen'] ?? '');

                $libro = new Libro(
                    $isbn,
                    $titulo,
                    $autor,
                    $precio,
                    $stock,
                    $descripcion,
                    $imagen
                );

                $this->repo->agregarLibro($libro);

                $mensaje = 'Libro registrado correctamente.';
            } catch (Exception $e) {
                $mensaje = 'Error al registrar el libro: '
                         . $e->getMessage();
            }
        }

        $libros = $this->repo->buscarlibro();

        require __DIR__ . '/../Views/inicio.php';
    }

    // Mostrar los libros disponibles en el catálogo
    public function catalogo()
    {
        $libros = $this->repo->buscarDisponible();

        require __DIR__ . '/../Views/catalogo.php';
    }
}
