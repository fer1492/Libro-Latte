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

    <main class="panel-container" style="max-width: 600px;">
        <h2 class="panel-title">Editar Usuario</h2>
        <p class="panel-subtitle">Modifica los datos del usuario seleccionado en el sistema.</p>
        
        <form action="<?php echo BASE_URL; ?>index.php?action=actualizar_usuario" method="POST" class="form-editar-usuario">
            
            <!-- Campo oculto para enviar la cédula que actúa como identificador -->
            <input type="hidden" name="cedula" value="<?php echo htmlspecialchars($usuario['cedula'] ?? ''); ?>">

            <div class="form-group-custom">
                <label class="form-label-custom">Cédula (No modificable):</label>
                <input type="text" class="form-input-custom" value="<?php echo htmlspecialchars($usuario['cedula'] ?? ''); ?>" disabled>
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
                <select name="rol" class="form-input-custom" required>
                    <option value="Socio" <?php echo (($usuario['rol'] ?? '') === 'Socio') ? 'selected' : ''; ?>>Socio</option>
                    <option value="Bibliotecario" <?php echo (($usuario['rol'] ?? '') === 'Bibliotecario') ? 'selected' : ''; ?>>Bibliotecario</option>
                    <option value="Admin" <?php echo (($usuario['rol'] ?? '') === 'Admin') ? 'selected' : ''; ?>>Admin</option>
                </select>
            </div>

            <div class="form-acciones-custom">
                <a href="<?php echo BASE_URL; ?>index.php?action=listar_usuarios" class="btn-cancelar" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">Cancelar</a>
                <button type="submit" class="btn-confirmar">Guardar Cambios</button>
            </div>
        </form>
    </main>

    <footer>LIBRO&LATTE</footer>
</body>
</html>