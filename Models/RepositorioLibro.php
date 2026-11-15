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

    // Obtener todos los libros activos
    public function buscarlibro() {
        $sql = "SELECT isbn, titulo, autor, precio, stock, descripcion, imagen, categoria
                 FROM libros
                 WHERE activo = 1";
        $stmt = $this->conexion->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar datos por ISBN de forma exacta y segura
    public function buscarStockPorIsbn($isbn) {
        $sql = "SELECT isbn, titulo, autor, precio, stock, descripcion, imagen, categoria
                FROM libros
                WHERE isbn = :isbn AND activo = 1";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([':isbn' => $isbn]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtener libros que tienen stock disponible
    public function buscarDisponible() {
        $sql = "SELECT isbn, titulo, autor, precio, stock, descripcion, imagen, categoria
                FROM libros
                WHERE stock > 0 AND activo = 1
                ORDER BY titulo ASC";

        $stmt = $this->conexion->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener libros filtrados por categoría
    public function buscarPorCategoria($categoria) {
        $sql = "SELECT isbn, titulo, autor, precio, stock, descripcion, imagen, categoria
                FROM libros
                WHERE categoria = :categoria AND activo = 1
                ORDER BY titulo ASC";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([':categoria' => $categoria]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Busca un libro por isbn para editar
    public function obtenerLibroPorIsbn($isbn) {
        $sql = "SELECT *
                FROM libros
                WHERE isbn = :isbn AND activo = 1";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([':isbn' => $isbn]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualiza datos de un libro
    public function actualizarLibro ($isbn, $datos) {
        $sql = "UPDATE libros
                SET titulo = :titulo,
                    autor = :autor,
                    precio = :precio,
                    stock = :stock,
                    descripcion = :descripcion,
                    imagen = :imagen,
                    categoria = :categoria
                WHERE isbn = :isbn AND activo = 1";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute ([
            ':titulo' => $datos['titulo'],
            ':autor' => $datos['autor'],
            ':precio' => $datos['precio'],
            ':stock' => $datos['stock'],
            ':descripcion' => $datos['descripcion'],
            ':imagen' => $datos['imagen'],
            ':categoria' => $datos['categoria'],
            ':isbn' => $isbn
        ]);
    }

    // Comprueba si un libro tiene reservas pendientes
    public function tieneReservasPendientes($isbn) {
        $sql = "SELECT COUNT(*)
                FROM ventas
                WHERE libro_isbn = :isbn
                and estado = 'reserva'";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([':isbn' => $isbn]);

        return (int) $stmt->fetchColumn() > 0;
    }

    // Eliminacion lógica del libro
    public function EliminarLibro($isbn) {
        if ($this->tieneReservasPendientes($isbn)) {
            return false;
        }

        $sql = "UPDATE libros
                SET activo = 0
                WHERE isbn = :isbn AND activo = 1";
        
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([':isbn' => $isbn]);

        return $stmt->rowCount() > 0;
    }

    // Buscar libros por ISBN, título o autor (Búsqueda general flexible)
    public function buscarPorTexto($busqueda) {
        $sql = "SELECT isbn, titulo, autor, precio, stock,
                       descripcion, imagen, categoria
                FROM libros
                WHERE activo = 1
                AND (
                    isbn LIKE :isbn
                    OR titulo LIKE :titulo
                    OR autor LIKE :autor
                )
                ORDER BY titulo ASC";

        $stmt = $this->conexion->prepare($sql);
        $texto = '%' . $busqueda . '%';

        $stmt->execute([
            ':isbn'   => $texto,
            ':titulo' => $texto,
            ':autor'  => $texto
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Arroja todas las categorías disponibles con stock
    public function obtenerCategorias() {
        $sql = "SELECT categoria, COUNT(*) AS cantidad
                FROM libros
                WHERE activo = 1
                AND stock > 0
                AND categoria IS NOT NULL
                AND categoria <> ''
                GROUP BY categoria
                ORDER BY categoria ASC";

        $stmt = $this->conexion->query($sql);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Buscar libros disponibles según las categorías seleccionadas
    public function buscarDisponiblesPorCategorias($categorias) {
        $marcadores = [];

        foreach ($categorias as $i => $categoria) {
            $marcadores[] = ':categoria' . $i;
        }

        $sql = "SELECT isbn, titulo, autor, precio, stock,
                       descripcion, imagen, categoria
                FROM libros
                WHERE activo = 1
                AND stock > 0
                AND categoria IN (" . implode(',', $marcadores) . ")
                ORDER BY titulo ASC";

        $stmt = $this->conexion->prepare($sql);
        $parametros = [];

        foreach ($categorias as $i => $categoria) {
            $parametros[':categoria' . $i] = $categoria;
        }

        $stmt->execute($parametros);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener todas las categorías existentes para los formularios
    public function obtenerNombresCategorias() {
        $sql = "SELECT DISTINCT categoria
                FROM libros
                WHERE activo = 1
                AND categoria IS NOT NULL
                AND categoria <> ''
                ORDER BY categoria ASC";

        $stmt = $this->conexion->query($sql);

        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }
    public function guardarResena($isbn, $usuario_cedula, $calificacion, $comentario) {
    $sql = "INSERT INTO resenas
            (isbn, usuario_cedula, calificacion, comentario)
            VALUES
            (:isbn, :usuario_cedula, :calificacion, :comentario)";

    $stmt = $this->conexion->prepare($sql);

    return $stmt->execute([
        ':isbn' => $isbn,
        ':usuario_cedula' => $usuario_cedula,
        ':calificacion' => $calificacion,
        ':comentario' => $comentario
    ]);
}

    public function obtenerResenasPorIsbn($isbn) {
    $sql = "SELECT
                r.usuario_cedula,
                u.nombre,
                u.apellido,
                r.calificacion,
                r.comentario,
                r.fecha
            FROM resenas r
            INNER JOIN usuarios u
                ON r.usuario_cedula = u.cedula
            WHERE r.isbn = :isbn
            ORDER BY r.fecha DESC";

    $stmt = $this->conexion->prepare($sql);
    $stmt->execute([':isbn' => $isbn]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}
?>