<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start;
}

if (
    !isset($_SESSION['usuario_rol']) ||
    strtolower(trim((string) $_SESSION['usuario_rol'])) !== 'bibliotecario'
) {
    http_response_code(403);
    exit('No tenes permiso para acceder a esta seccion.');
}

$mensaje = $mensaje ?? '';

if (isset($_GET['registro_libro']) && $_GET['registro_libro'] === 'ok') {
    $mensaje = 'Libro registrado correctamente y con exito!!!';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Libro | Libro&Latte</title>
    <link rel="stylesheet" href="../Public/css/Style.css">
    <link rel="stylesheet" href="../Public/css/Media-Querry.css">
</head>
<body>
    <header>
        <h1>Libro&Latte</h1>
    </header>

    <main>
        <section class="formulario-libro">
            <h1>Agregar Libro</h1>

            <?php if ($mensaje !== ''): ?>
                <p class="mensaje-libro">
                    <?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?>
                </p>
            <?php endif; ?>

            <form action="Index.php?action=agregar_libro" method="POST">
                <label for="isbn"> ISBN *</label>
                <input type="text" id="isbn" name="isbn" require>

                <label for="titulo"> Titulo *</label>
                <input type="text" id="titulo" name="titulo" require>

                <label for="autor"> Autor *</label>
                <input type="text" id="autor" name="autor" require>

                <label for="descripcion"> Descripcion </label>
                <textarea id="descripcion" name="descripcion"></textarea>

                <label for="imagen"> Ruta o URL de imagen </label>
                <input type="text"
                        id="imagen" 
                        name="imagen" 
                        placeholder="../Public/Assets/portada.png" > 
                
                <label for="precio"> Precio</label>
                <input type="number"
                        id="precio"
                        name="precio"
                        min= "0"
                        step="0.01"
                        require >
                
                
                <label for="stock"> Stock *</label>
                <input type="number"
                        id="stock"
                        name="stock"
                        min= "0"
                        step="1"
                        require >
                
                <button type="submit">Guardar Libro</button>
            </form> 

            <a class="volver" href="Index.php">Volver al inicio</a>
        </section>
    </main>
</body>
</html>