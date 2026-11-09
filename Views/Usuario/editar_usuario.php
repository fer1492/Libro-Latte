<?php
// Views/Usuario/editar_usuario.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario - Libro&Latte</title>
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

    <main class="panel-container" style="max-width: 600px;">
        <div class="nav-links">
            <a href="Index.php?action=listar_usuarios">&larr; Volver a la Lista de Usuarios</a>
        </div>

        <h2 class="panel-title">Editar Usuario</h2>
        <p class="panel-subtitle">Modifica los datos del usuario seleccionado en el sistema.</p>
        
        <form action="Index.php?action=actualizar_usuario" method="POST" class="form-editar-usuario">
            
            <!-- Campo oculto para enviar la cédula que actúa como identificador -->
            <input type="hidden" name="cedula" value="<?php echo htmlspecialchars($usuario['cedula'] ?? ''); ?>">

            <div class="form-group-custom">
                <label class="form-label-custom">Cédula (No modificable):</label>
                <input type="text" class="form-input-custom" value="<?php echo htmlspecialchars($usuario['cedula'] ?? ''); ?>" disabled style="background-color: #f5f5f5;">
            </div>

            <div class="form-group-custom">
                <label class="form-label-custom">Nombre:</label>
                <input type="text" name="nombre" class="form-input-custom" value="<?php echo htmlspecialchars($usuario['nombre'] ?? ''); ?>" required>
            </div>

            <div class="form-group-custom">
                <label class="form-label-custom">Apellido:</label>
                <input type="text" name="apellido" class="form-input-custom" value="<?php echo htmlspecialchars($usuario['apellido'] ?? ''); ?>" required>
            </div>

            <div class="form-group-custom">
                <label class="form-label-custom">Correo Electrónico:</label>
                <input type="email" name="email" class="form-input-custom" value="<?php echo htmlspecialchars($usuario['email'] ?? ''); ?>" required>
            </div>

            <div class="form-group-custom">
                <label class="form-label-custom">Rol del Usuario:</label>
                <select name="rol" class="form-select-custom" required>
                    <option value="Socio" <?php echo (strcasecmp($usuario['rol'] ?? '', 'Socio') === 0) ? 'selected' : ''; ?>>Socio</option>
                    <option value="Bibliotecario" <?php echo (strcasecmp($usuario['rol'] ?? '', 'Bibliotecario') === 0) ? 'selected' : ''; ?>>Bibliotecario</option>
                    <option value="Admin" <?php echo (strcasecmp($usuario['rol'] ?? '', 'Admin') === 0) ? 'selected' : ''; ?>>Admin</option>
                </select>
            </div>

            <div style="display: flex; gap: 15px; margin-top: 20px;">
                <a href="Index.php?action=listar_usuarios" class="btn-cancelar-sm" style="text-decoration: none; padding: 10px 20px; font-size: 0.95rem; border-radius: 6px; display: inline-flex; align-items: center;">Cancelar</a>
                <button type="submit" class="btn-finalizar" style="padding: 10px 25px; font-size: 0.95rem; border-radius: 6px;">Guardar Cambios</button>
            </div>
        </form>
    </main>

    <footer>LIBRO&LATTE</footer>
</body>
</html>
