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
            strtolower(trim((string) $_SESSION['usuario_rol'])) === 'bibliotecario';
    }

    // Mostrar la página de inicio con los libros cargados
    public function listar($mensaje = '')
    {
        $libros = $this->repo->buscarlibro();

        require __DIR__ . '/../Views/inicio.php';
    }

    // Buscar un libro por su ISBN
   public function buscarPorIsbn() {

    $busqueda = trim($_GET['busqueda'] ?? '');

    $resultados = [];
    $mensajeBusqueda = '';

    if ($busqueda === '') {

        $mensajeBusqueda = 'Ingresá un ISBN, título o autor para realizar la búsqueda.';

    } else {

        $resultados = $this->repo->buscarPorTexto($busqueda);

        if (empty($resultados)) {
            $mensajeBusqueda = 'No se encontraron libros con ese criterio de búsqueda.';
        }
    }

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
    // Cargar categorías existentes desde MySQL
    $categorias = $this->repo->obtenerNombresCategorias();
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
                $categoria === '' ||
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
        // Volver a cargar las categorías para mostrar el formulario
        $categorias = $this->repo->obtenerNombresCategorias();

        require __DIR__ . '/../Views/agregar_Libro.php';
    }

    // Mostrar catálogo
    public function catalogo() {
    // Obtener categorías y cantidades
    $categoriasConCantidad = $this->repo->obtenerCategorias();
    // Obtener solamente los nombres de las categorías
    $categorias = array_column($categoriasConCantidad, 'categoria');
    // Recuperar categorías seleccionadas
    $categoriasSeleccionadas = $_GET['categorias'] ?? [];
    if (!is_array($categoriasSeleccionadas)) {
        $categoriasSeleccionadas = [];
    }
    // Validar las categorías recibidas
    $categoriasSeleccionadas = array_values(
        array_intersect($categoriasSeleccionadas, $categorias)
    );
    // Aplicar filtros
    if (!empty($categoriasSeleccionadas)) {
        $libros = $this->repo->buscarDisponiblesPorCategorias(
            $categoriasSeleccionadas
        );
    } else {
        $libros = $this->repo->buscarDisponible();
    }
    require __DIR__ . '/../Views/catalogo.php';
}


        // Formulario para editar libro
    public function editar() {

    if (!$this->esBibliotecario()) {
        http_response_code(403);
        exit('No tienes permiso para editar libros.');
    }

    $isbn = trim($_GET['isbn'] ?? '');

    if ($isbn === '') {
        header('Location: Index.php?action=catalogo');
        exit;
    }

    $libro = $this->repo->obtenerLibroPorIsbn($isbn);

    if (!$libro) {
        header('Location: Index.php?action=catalogo&error=libro_no_encontrado');
        exit;
    }

    // Obtener categorías existentes desde MySQL
    $categorias = $this->repo->obtenerNombresCategorias();

    $mensaje = '';

    require __DIR__ . '/../Views/editar_Libro.php';
    
    }

    //Actualizar datos del libro
    public function actualizar() {
        if (!$this->esBibliotecario()) {
            http_response_code (403);
            exit('No tenes permiso para modificar libros');
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: Index.php?action=catalogo');
            exit;
        }

        $isbn = trim($_POST['isbn'] ?? '');

        try {
            $titulo = trim($_POST['titulo'] ?? '');
            $autor = trim($_POST['autor'] ?? '');
            $categoria = trim($_POST['categoria'] ?? 'ficcion');
            $precio = $_POST['precio'] ?? '';
            $stock = $_POST['stock'] ?? '';
            $descripcion = trim($_POST['descripcion'] ?? '');
            $imagen = trim($_POST['imagen'] ?? '');

       if (
    $isbn === '' ||
    $titulo === '' ||
    $autor === '' ||
    $precio === '' ||
    $stock === ''
) {
    throw new Exception('Completá todos los campos obligatorios.');
}

        if (!is_numeric($precio) || (float)$precio < 0) {
            throw new Exception('El precio debe ser igual o mayor a 0');
        }

        if (
            filter_var($stock, FILTER_VALIDATE_INT) === false ||
            (int)$stock < 0
        ) {
            throw new exception('El stock debe ser un numero entero igual o mayor a cero');
        }

        $datos = [
            'titulo' => $titulo,
            'autor' => $autor,
            'precio' => (float) $precio,
            'stock' => (int) $stock,
            'descripcion' => $descripcion,
            'imagen' => $imagen,
            'categoria' => $categoria
        ];

        if (!$this->repo->actualizarLibro($isbn, $datos)) {
            throw new Exception('No se pudo actualizar el libro.');
        }

        header('Location: Index.php?action=catalogo&gestion=actualizado');
        exit;
    } 
        catch (Exception $e) {
            $mensaje = $e->getMessage();

            $libro = $this->repo->obtenerLibroPorIsbn($isbn);

            if (!$libro) {
            header('Location: Index.php?action=catalogo&error=libro_no_encontrado');
            exit;
        }

        //Mantiene los datos ingresados en el formulario
        $libro = array_merge($libro, $_POST);

        $categorias = $this->repo->obtenerNombresCategorias();

        require __DIR__ . '/../Views/editar_Libro.php';
        }
    }

    //Eliminar un libro
    public function eliminar() {
        if (!$this->esBibliotecario()) {
            http_response_code(403);
            exit('No tenes permiso para eliminar libros');
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: Index.php?action=catalogo');
            exit;
        }

        $isbn = trim($_POST['isbn'] ?? '');

        if ($isbn === '') {
            header('Location: Index.php?action=catalogo&error=isbn_invalido');
            exit;
        }

        if ($this->repo->tieneReservasPendientes($isbn)) {
        header('Location: Index.php?action=catalogo&error=reservas_pendientes');
        exit;
    }

        if ($this->repo->eliminarLibro($isbn)) {
        header('Location: Index.php?action=catalogo&gestion=eliminado');
        exit;
    }

        header('Location: Index.php?action=catalogo&error=eliminacion_fallida');
        exit;


    }
public function guardarResena() {
        $this->iniciarSesion();

        if (!isset($_SESSION['usuario_cedula'])) {
            header('Location: Index.php?action=login&error=debe_iniciar_sesion');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: Index.php?action=catalogo');
            exit;
        }

        $isbn = trim($_POST['isbn'] ?? '');
        $calificacion = $_POST['calificacion'] ?? '';
        $comentario = trim($_POST['comentario'] ?? '');
        $usuario_cedula = $_SESSION['usuario_cedula'];

        try {
            if ($isbn === '' || $calificacion === '' || $comentario === '') {
                throw new Exception('Todos los campos de la reseña son obligatorios.');
            }

            if (!is_numeric($calificacion) || (int)$calificacion < 1 || (int)$calificacion > 5) {
                throw new Exception('La calificación debe ser un número entre 1 y 5.');
            }

            $this->repo->guardarResena(
                $isbn, $usuario_cedula, (int)$calificacion, $comentario);

            header('Location: Index.php?action=catalogo&resena=ok');
            exit;

        } catch (Exception $e) {
            header('Location: Index.php?action=catalogo&error=' . urlencode($e->getMessage()));
            exit;
        }
    }

    public function obtenerResenas($isbn) {
        return $this->repo->obtenerResenasPorIsbn($isbn);
    }
}
    
