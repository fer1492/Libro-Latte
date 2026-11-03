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
    <title>Editar Usuario - Libro-Latte</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5" style="max-width: 600px;">
        <h2 class="mb-4">Editar Usuario</h2>
        
        <form action="<?php echo BASE_URL; ?>index.php?action=actualizar_usuario" method="POST" class="card p-4 shadow-sm">
            
            <!-- Campo oculto para enviar la cédula que actúa como identificador -->
            <input type="hidden" name="cedula" value="<?php echo htmlspecialchars($usuario['cedula'] ?? ''); ?>">

            <div class="mb-3">
                <label class="form-label">Cédula (No modificable):</label>
                <input type="text" class="form-control" value="<?php echo htmlspecialchars($usuario['cedula'] ?? ''); ?>" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">Nombre:</label>
                <input type="text" name="nombre" class="form-control" value="<?php echo htmlspecialchars($usuario['nombre'] ?? ''); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Apellido:</label>
                <input type="text" name="apellido" class="form-control" value="<?php echo htmlspecialchars($usuario['apellido'] ?? ''); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Correo Electrónico:</label>
                <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($usuario['email'] ?? ''); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Rol del Usuario:</label>
                <select name="rol" class="form-select" required>
                    <option value="Socio" <?php echo (($usuario['rol'] ?? '') === 'Socio') ? 'selected' : ''; ?>>Socio</option>
                    <option value="Bibliotecario" <?php echo (($usuario['rol'] ?? '') === 'Bibliotecario') ? 'selected' : ''; ?>>Bibliotecario</option>
                    <option value="Admin" <?php echo (($usuario['rol'] ?? '') === 'Admin') ? 'selected' : ''; ?>>Admin</option>
                </select>
            </div>

            <div class="d-flex justify-content-between">
                <a href="<?php echo BASE_URL; ?>index.php?action=listar_usuarios" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-success">Guardar Cambios</button>
            </div>
        </form>
    </div>
</body>
</html>