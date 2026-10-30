<?php
// Views/catalogo.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$esBibliotecario = isset($_SESSION['usuario_rol']) && in_array(strtolower(trim((string)$_SESSION['usuario_rol'])), ['bibliotecario', 'admin', 'root']);
$estaLogueado = isset($_SESSION['usuario_cedula']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo - Libro&Latte</title>
    <link rel="stylesheet" href="css/Style.css">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700&family=Cormorant+Garamond:wght@400;600&display=swap" rel="stylesheet">
    <style>
        .catalogo-header-nav {
            display: flex;
            gap: 15px;
            align-items: center;
        }
        .catalogo-header-nav a {
            color: #f7ede2;
            text-decoration: none;
            font-size: 1.05rem;
            font-family: 'Cinzel', serif;
            padding: 6px 12px;
            border-radius: 4px;
            background: rgba(0,0,0,0.15);
            transition: background 0.2s;
        }
        .catalogo-header-nav a:hover {
            background: rgba(0,0,0,0.35);
        }
        .alerta-catalogo {
            max-width: 800px;
            margin: 20px auto;
            padding: 12px 20px;
            border-radius: 6px;
            text-align: center;
            font-size: 1.15rem;
            font-weight: 600;
        }
        .alerta-ok { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alerta-err { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .btn-reservar-card {
            background-color: #6f4e37;
            color: #fff;
            border: none;
            padding: 10px 16px;
            border-radius: 5px;
            cursor: pointer;
            font-family: 'Cinzel', serif;
            font-size: 0.95rem;
            margin-top: 12px;
            width: 100%;
            transition: background 0.2s;
        }
        .btn-reservar-card:hover {
            background-color: #4a2e18;
        }
        .btn-admin-badge {
            background-color: #8b7355;
            color: #fff;
            border: none;
            padding: 10px 16px;
            border-radius: 5px;
            font-family: 'Cinzel', serif;
            font-size: 0.9rem;
            margin-top: 12px;
            width: 100%;
            cursor: default;
            opacity: 0.85;
            text-align: center;
            display: block;
        }
    </style>
</head>
<body>
    <header>
        <div id="logo">
            <img src="Assets/Logo transparente.png" alt="logo-libro&latte">
        </div>

        <h1>Biblioteca Libro&Latte</h1>

        <nav class="catalogo-header-nav">
            <a href="Index.php?action=inicio">Inicio</a>
            <?php if ($estaLogueado && !$esBibliotecario): ?>
                <a href="Index.php?action=mis_reservas">Mis Reservas</a>
            <?php endif; ?>
            <?php if ($esBibliotecario): ?>
                <a href="Index.php?action=panel_reservas">Panel Reservas</a>
                <a href="Index.php?action=formulario_libro">Agregar Libro</a>
            <?php endif; ?>
            <?php if ($estaLogueado): ?>
                <span style="color: #ffd8a8; font-family: 'Cinzel', serif; font-size: 0.95rem; margin-left: 10px;">
                    ¡Hola, <?= htmlspecialchars($_SESSION['usuario_nombre'] ?? 'Socio', ENT_QUOTES, 'UTF-8') ?>!
                </span>
                <a href="Index.php?action=logout" style="background: #dc3545; color: white;">Cerrar Sesión</a>
            <?php endif; ?>
        </nav>
    </header>

    <main class="catalogo">
        <h2>Nuestro Catálogo de Libros</h2>

        <?php if (isset($_GET['reserva']) && $_GET['reserva'] === 'ok'): ?>
            <div class="alerta-catalogo alerta-ok">
                ¡Tu reserva ha sido registrada con éxito! Pasa por la biblioteca para que el personal bibliotecario te entregue el libro.
            </div>
        <?php elseif (isset($_GET['error'])): ?>
            <div class="alerta-catalogo alerta-err">
                <?php if ($_GET['error'] === 'sin_stock'): ?>
                    No hay stock disponible para reservar este libro.
                <?php elseif ($_GET['error'] === 'admin_no_puede_reservar'): ?>
                    Los administradores y bibliotecarios no pueden realizar reservas de libros.
                <?php else: ?>
                    Ocurrió un inconveniente al procesar tu solicitud.
                <?php endif; ?>
            </div>
        <?php elseif (isset($_GET['action']) && $_GET['action'] === 'login_requerido'): ?>
            <div class="alerta-catalogo alerta-err">
                Debes iniciar sesión como cliente para poder reservar un libro.
            </div>
        <?php endif; ?>

        <div class="libros-grid">
            <?php if (empty($libros)): ?>
                <p class="sin-libros">
                    Actualmente no disponemos de libros disponibles.
                </p>
            <?php else: ?>
                <?php foreach ($libros as $libro): ?>
                    <article class="libro">
                        <?php if (!empty($libro['imagen'])): ?>
                            <img src="<?= htmlspecialchars($libro['imagen'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($libro['titulo'], ENT_QUOTES, 'UTF-8') ?>">
                        <?php endif; ?>

                        <h3><?= htmlspecialchars($libro['titulo'], ENT_QUOTES, 'UTF-8') ?></h3>

                        <p><strong>Autor:</strong> <?= htmlspecialchars($libro['autor'], ENT_QUOTES, 'UTF-8') ?></p>

                        <p><strong>Precio:</strong> $<?= number_format((float)$libro['precio'], 2, ',', '.') ?></p>

                        <p class="disponible"><strong>Disponible en Stock:</strong> <?= (int)$libro['stock'] ?></p>

                        <?php if (!empty($libro['descripcion'])): ?>
                            <p class="descripcion"><?= htmlspecialchars($libro['descripcion'], ENT_QUOTES, 'UTF-8') ?></p>
                        <?php endif; ?>

                        <?php if ($esBibliotecario): ?>
                            <!-- Para el administrador o bibliotecario no se muestra la opción de reservar -->
                            <span class="btn-admin-badge">Modo Administrador</span>
                        <?php elseif ((int)$libro['stock'] > 0): ?>
                            <!-- Para los clientes normales -->
                            <form method="POST" action="Index.php?action=reservar">
                                <input type="hidden" name="isbn" value="<?= htmlspecialchars($libro['isbn'], ENT_QUOTES, 'UTF-8') ?>">
                                <input type="hidden" name="cantidad" value="1">
                                <button type="submit" class="btn-reservar-card">Reservar libro</button>
                            </form>
                        <?php else: ?>
                            <button type="button" class="btn-reservar-card" style="background: #999; cursor: not-allowed;" disabled>Sin Stock</button>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>

    <footer>LIBRO&LATTE</footer> 
</body>
</html>
