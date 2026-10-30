<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (
    !isset($_SESSION['usuario_rol']) ||
    !in_array(strtolower(trim((string) $_SESSION['usuario_rol'])), ['bibliotecario', 'admin', 'root'])
) {
    http_response_code(403);
    exit('No tenes permiso para acceder a esta seccion.');
}

$mensaje = $mensaje ?? '';

if (isset($_GET['registro_libro']) && $_GET['registro_libro'] === 'ok') {
    $mensaje = '¡Libro registrado correctamente con su categoría!';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Libro | Libro&Latte</title>
    <link rel="stylesheet" href="css/Style.css">
    <link rel="stylesheet" href="css/Media-Querry.css">
</head>
<body>
    <header>
        <div id="logo">
            <img src="Assets/Logo transparente.png" alt="logo-libro&latte">
        </div>
        <h1>Libro&Latte - Administración</h1>
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
                <input type="text" id="isbn" name="isbn" required>

                <label for="titulo"> Título *</label>
                <input type="text" id="titulo" name="titulo" required>

                <label for="autor"> Autor *</label>
                <input type="text" id="autor" name="autor" required>

                <label for="categoria"> Categoría *</label>
                <select id="categoria" name="categoria" required>
                    <option value="ficcion">Ficción</option>
                    <option value="no-ficcion">No Ficción</option>
                    <option value="infantil-y-juvenil">Infantil y Juvenil</option>
                    <option value="textos">Textos</option>
                    <option value="manga">Manga</option>
                    <option value="comic">Comic</option>
                </select>

                <label for="descripcion"> Descripción </label>
                <textarea id="descripcion" name="descripcion" placeholder="Breve reseña o sinopsis del libro..."></textarea>

                <label for="imagen"> Ruta o URL de portada </label>
                <input type="text"
                        id="imagen" 
                        name="imagen" 
                        placeholder="Assets/elcaballero.png o URL" > 
                
                <label for="precio"> Precio ($) *</label>
                <input type="number"
                        id="precio"
                        name="precio"
                        min="0"
                        step="0.01"
                        required >
                
                <label for="stock"> Stock *</label>
                <input type="number"
                        id="stock"
                        name="stock"
                        min="0"
                        step="1"
                        required >
                
                <button type="submit">Guardar Libro</button>
            </form> 

            <a class="volver" href="Index.php">Volver al inicio</a>
        </section>
    </main>

    <footer>LIBRO&LATTE</footer>
</body>
</html>
