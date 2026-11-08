<?php
// Views/Venta/GestionReservas.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Reservas - Libro&Latte</title>
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
            <a href="Index.php?action=formulario_libro">Agregar Libro</a>
        </div>

        <h2 class="panel-title">Panel de Control: Reservas Pendientes</h2>
        <p class="panel-subtitle">El personal bibliotecario o administrador puede confirmar la entrega y cobro para finalizar la reserva y descontar stock.</p>

        <?php if (isset($_GET['venta']) && $_GET['venta'] === 'ok'): ?>
            <div class="alert alert-success">¡Reserva finalizada y entregada con éxito! El stock ha sido actualizado.</div>
        <?php elseif (isset($_GET['cancelada']) && $_GET['cancelada'] === 'ok'): ?>
            <div class="alert alert-success">La reserva ha sido cancelada correctamente.</div>
        <?php elseif (isset($_GET['error']) && $_GET['error'] === 'sin_stock'): ?>
            <div class="alert alert-error">Error: No hay suficiente stock para concretar la entrega de este libro.</div>
        <?php endif; ?>

        <?php if (empty($reservas)): ?>
            <p class="panel-vacio">
                No hay reservas pendientes en este momento.
            </p>
        <?php else: ?>
            <table class="tabla-reservas">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Cédula</th>
                        <th>Libro</th>
                        <th>Cant.</th>
                        <th>Stock Act.</th>
                        <th>Total</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservas as $reserva): ?>
                        <tr>
                            <td><?= (int)$reserva['id'] ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($reserva['fecha'])) ?></td>
                            <td><?= htmlspecialchars($reserva['usuario_nombre'] . ' ' . ($reserva['usuario_apellido'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($reserva['usuario_cedula'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><strong><?= htmlspecialchars($reserva['libro_titulo'], ENT_QUOTES, 'UTF-8') ?></strong></td>
                            <td><?= (int)$reserva['cantidad'] ?></td>
                            <td>
                                <span class="badge-stock <?= (int)$reserva['libro_stock'] <= 2 ? 'bajo' : '' ?>">
                                    <?= (int)$reserva['libro_stock'] ?> disp.
                                </span>
                            </td>
                            <td>$<?= number_format((float)$reserva['total'], 2, ',', '.') ?></td>
                            <td>
                                <div class="acciones-container">
                                    <form method="POST" action="Index.php?action=confirmar_venta" onsubmit="return confirm('¿Confirmar entrega y cobro de este libro?');">
                                        <input type="hidden" name="id_venta" value="<?= (int)$reserva['id'] ?>">
                                        <button type="submit" class="btn-confirmar">Finalizar</button>
                                    </form>

                                    <form method="POST" action="Index.php?action=cancelar_reserva" onsubmit="return confirm('¿Estás seguro de cancelar esta reserva?');">
                                        <input type="hidden" name="id_venta" value="<?= (int)$reserva['id'] ?>">
                                        <button type="submit" class="btn-cancelar">Cancelar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <?php if (!empty($ventasConcretadas)): ?>
            <h3 class="panel-title panel-historial-title">Historial de Reservas Finalizadas / Compradas</h3>
            <table class="tabla-reservas tabla-historial">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fecha Finalizada</th>
                        <th>Cliente</th>
                        <th>Libro</th>
                        <th>Cant.</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Atendido Por</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (array_slice($ventasConcretadas, 0, 10) as $venta): ?>
                        <tr>
                            <td><?= (int)$venta['id'] ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($venta['fecha'])) ?></td>
                            <td><?= htmlspecialchars($venta['cliente_nombre'] . ' ' . ($venta['cliente_apellido'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($venta['libro_titulo'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= (int)$venta['cantidad'] ?></td>
                            <td>$<?= number_format((float)$venta['total'], 2, ',', '.') ?></td>
                            <td><span class="badge-finalizado">Finalizado</span></td>
                            <td><?= htmlspecialchars($venta['atendido_por_nombre'] ?? $venta['atendido_por'] ?? 'Sistema', ENT_QUOTES, 'UTF-8') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </main>

    <footer>LIBRO&LATTE</footer>
</body>
</html>