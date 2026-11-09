<?php
// Views/Usuario/listar_usuarios.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios - Libro&Latte</title>
    <link rel="stylesheet" href="css/Style.css">
    <link rel="stylesheet" href="css/Media-Querry.css">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700&family=Cormorant+Garamond:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div id="logo">
            <a href="Index.php?action=inicio">
                <img src="Assets/Logo transparente.png" alt="logo-libro&latte">
            </a>
        </div>
        <h1>Biblioteca Libro&Latte</h1>
    </header>

    <main class="panel-container">
        <div class="nav-links">
            <a href="Index.php?action=inicio">&larr; Volver al Inicio</a>
            <a href="Index.php?action=catalogo">Ver Catálogo</a>
            <a href="Index.php?action=panel_reservas">Panel Reservas</a>
            <a href="Index.php?action=formulario_libro">Agregar Libro</a>
        </div>

        <h2 class="panel-title">Lista de Usuarios Registrados</h2>
        <p class="panel-subtitle">Administra los usuarios registrados, sus roles y permisos en el sistema.</p>

        <table class="tabla-reservas">
            <thead>
                <tr>
                    <th>Cédula</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($usuarios)): ?>
                    <?php foreach ($usuarios as $u): ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($u['cedula'], ENT_QUOTES, 'UTF-8'); ?></strong></td>
                        <td><?php echo htmlspecialchars($u['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($u['apellido'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($u['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td>
                            <span class="badge-stock">
                                <?php echo htmlspecialchars($u['rol'] ?: 'Socio', ENT_QUOTES, 'UTF-8'); ?>
                            </span>
                        </td>
                        <td>
                            <div style="display: flex; gap: 6px; align-items: center;">
                                <a href="Index.php?action=editar_usuario&id=<?php echo urlencode($u['cedula']); ?>" class="btn-editar-sm">Editar</a>
                                <form method="POST" action="Index.php?action=eliminar_usuario" onsubmit="return confirm('¿Estás seguro de que deseas eliminar a <?php echo htmlspecialchars($u['nombre'], ENT_QUOTES, 'UTF-8'); ?>?');" style="display:inline; margin: 0;">
                                    <input type="hidden" name="cedula" value="<?php echo htmlspecialchars($u['cedula'], ENT_QUOTES, 'UTF-8'); ?>">
                                    <button type="submit" class="btn-eliminar-sm">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="panel-vacio">No hay usuarios registrados en el sistema.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>

    <footer>LIBRO&LATTE</footer>
</body>
</html>
