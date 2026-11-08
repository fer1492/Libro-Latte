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
    <link rel="stylesheet" href="../Style.css">
    <link rel="stylesheet" href="../Media Querry.css">
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
                        <td><?php echo htmlspecialchars($u['cedula'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($u['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($u['apellido'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($u['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td>
                            <span class="badge-stock">
                                <?php echo htmlspecialchars($u['rol'], ENT_QUOTES, 'UTF-8'); ?>
                            </span>
                        </td>
                        <td>
                            <div class="acciones-container">
                                <a href="<?php echo BASE_URL; ?>index.php?action=editar_usuario&id=<?php echo $u['cedula']; ?>" class="btn-confirmar" style="text-decoration: none; padding: 6px 12px; font-size: 0.9rem;">Editar</a>
                                <form method="POST" action="<?php echo BASE_URL; ?>index.php?action=eliminar_usuario" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este usuario?');" style="display:inline;">
                                    <input type="hidden" name="cedula" value="<?php echo $u['cedula']; ?>">
                                    <button type="submit" class="btn-cancelar" style="padding: 6px 12px; font-size: 0.9rem;">Eliminar</button>
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