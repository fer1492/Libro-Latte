<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (
    !isset($_SESSION['usuario_rol']) ||
    strtolower(trim((string) $_SESSION['usuario_rol'])) !== 'bibliotecario'
) {
    http_response_code(403);
    exit('No tenes permiso para acceder a esta seccion.');
}

$mensaje = $mensaje ?? '';

$categoria = [
    'ficcion' => 'Ficcion',
    'no-ficcion' => 'No Ficcion',
    'infantil-y-juvenil' => 'Infantil y Juvenil',
    'textos' => 'Textos',
    'manga' => 'Manga',
    'comic' => 'Comic'
];

$valor = function ($campo) use ($libro) {
    return htmlspecialchars(
        (string) ($libro[$campo] ?? ''),
        ENT_QUOTES,
        'UTF-8'
    );
};
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Libro | Libro&Latte</title>

    <link rel="stylesheet" href="css/Style.css">
    <link rel="stylesheet" href="css/Media-Querry.css">
</head>
<body>

<header>
    <div id="logo">
            <img src="Assets/Logo transparente.png" alt="logo-libro&latte">
    </div>

    <h1>Libro&Latte - Gestion de Catalogo</h1>
</header>

<main>
    <section class="formulario-libro">

        <h1>Editar Libro</h1>

        <?php if ($mensaje !== ''): ?>
                <p class="mensaje-libro">
                    <?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?>
                </p>
        <?php endif; ?>

        <form action="Index.php?action=actualizar_libro" method="POST">

        <label for="isbn">ISBN</label>
        <input
            type="text"
            id="isbn"
            name="isbn"
            value="<?= $valor('isbn') ?>"
            readonly
        >

        <label for="titulo">Titulo *</label>
        <input
            type="text"
            id="titulo"
            name="titulo"
            value="<?= $valor('titulo') ?>"
            require
        >

        <label for="autor">Autor *</label>
        <input
            type="text"
            id="autor"
            name="autor"
            value="<?= $valor('autor') ?>"
            require
        >

        <label for="categoria">Categoría *</label>

            <input
                type="text"
                id="categoria"
                name="categoria"
                list="lista-categorias"
                value="<?= $valor('categoria') ?>"
                placeholder="Escribí una categoría nueva o elegí una existente"
                required
            >

            <datalist id="lista-categorias">
                <?php foreach ($categorias as $categoriaExistente): ?>
                    <option value="<?= htmlspecialchars($categoriaExistente, ENT_QUOTES, 'UTF-8') ?>">
                <?php endforeach; ?>
            </datalist>

        <label for="descripcion">Descripción</label>
                <textarea
                    id="descripcion"
                    name="descripcion"
                    placeholder="Breve reseña o sinopsis del libro..."
                ><?= $valor('descripcion') ?></textarea>

                <label for="imagen">Ruta o URL de portada</label>
                <input
                    type="text"
                    id="imagen"
                    name="imagen"
                    value="<?= $valor('imagen') ?>"
                    placeholder="Assets/elcaballero.png o URL"
                >

                <label for="precio">Precio ($) *</label>
                <input
                    type="number"
                    id="precio"
                    name="precio"
                    min="0"
                    step="0.01"
                    value="<?= $valor('precio') ?>"
                    required
                >

                <label for="stock">Stock *</label>
                <input
                    type="number"
                    id="stock"
                    name="stock"
                    min="0"
                    step="1"
                    value="<?= $valor('stock') ?>"
                    required
                >

                <button type="submit">Guardar Cambios</button>

            </form>

            <a class="volver" href="Index.php?action=catalogo">
                Volver al catálogo
            </a>

        </section>
    </main>



    
</body>
</html>