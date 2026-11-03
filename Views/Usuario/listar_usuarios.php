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
    <title>Gestión de Usuarios - Libro-Latte</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Lista de Usuarios Registrados</h2>
            <a href="<?php echo BASE_URL; ?>index.php" class="btn btn-secondary">Volver al Inicio</a>
        </div>
        
        <table class="table table-striped table-bordered shadow-sm">
            <thead class="table-dark">
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
                        <td><?php echo htmlspecialchars($u['cedula']); ?></td>
                        <td><?php echo htmlspecialchars($u['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($u['apellido'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($u['email']); ?></td>
                        <td>
                            <span class="badge bg-<?php echo ($u['rol'] === 'Bibliotecario' || $u['rol'] === 'Admin') ? 'primary' : 'secondary'; ?>">
                                <?php echo htmlspecialchars($u['rol']); ?>
                            </span>
                        </td>
                        <td>
                            <a href="<?php echo BASE_URL; ?>index.php?action=editar_usuario&id=<?php echo $u['cedula']; ?>" class="btn btn-sm btn-warning">Editar</a>
                            <a href="<?php echo BASE_URL; ?>index.php?action=eliminar_usuario&id=<?php echo $u['cedula']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted">No hay usuarios registrados en el sistema.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>