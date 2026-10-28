<?php
// Views/catalogo.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogo - Libro&Latte</title>
    <link rel="stylesheet" href="/LibreriaPaginaClon/Libro-Latte/Public/css/Style.css?v=2">
</head>
<body>
    <header>
        <div id="logo">
            <img src="../Public/Assets/Logo transparente.png" alt="logo-libro&latte">
        </div>

        <h1>Biblioteca Libro&Latte</h1>
               
    </header>


    <main class="catalogo">
    <h2>Nuestro Catálogo de Libros</h2>

        <div class="libros-grid">

            <?php if (empty($libros)): ?>

                <p class="sin-libros">
                    Actualmente no disponemos de libros disponibles.
                </p>

            <?php else: ?>
                <?php foreach ($libros as $libro): ?>
                    <article class= "libro">

                    <?php if (!empty($libro['imagen'])): ?>
                        <img 
                            src="<?= htmlspecialchars($libro['imagen'], ENT_QUOTES, 'UTF-8') ?>"
                            >
                        <?php endif; ?>

                        <h3>
                            <?= htmlspecialchars(
                                $libro['titulo'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </h3>

                        <p>
                            Autor:
                            <?= htmlspecialchars(
                                $libro['autor'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </p>

                        <p>
                            Precio: $ 
                            <?= number_format(
                                (float) $libro['precio'],
                                2,
                                ',',
                                "."
                            ) ?>
                        </p>

                        <p class="disponible">
                            Disponible - En Stock:
                            <?= (int) $libro['stock'] ?>
                        </p>

                        <?php if (!empty($libro['descripcion'])): ?>
                            <p class="descripcion">
                                <?= htmlspecialchars(
                                    $libro['descripcion'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </p>
                        <?php endif; ?>
                        
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
   </main>
         
   
<footer>LIBRO&LATTE</footer> 

</body>
</html>