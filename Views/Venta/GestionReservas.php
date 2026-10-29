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
    <title>Panel de Reservas y Ventas - Libro&Latte</title>
    <link rel="stylesheet" href="css/Style.css">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700&family=Cormorant+Garamond:wght@400;600&display=swap" rel="stylesheet">
    <style>
        .panel-container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 25px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            font-family: 'Cormorant Garamond', serif;
        }
        .panel-title {
            font-family: 'Cinzel', serif;
            color: #4a2e18;
            font-size: 2rem;
            margin-bottom: 10px;
            text-align: center;
        }
        .panel-subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 25px;
            font-size: 1.1rem;
        }
        .alert {
            padding: 12px 20px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-weight: 600;
            font-size: 1.1rem;
            text-align: center;
        }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

        .tabla-reservas {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 35px;
            font-size: 1.1rem;
        }
        .tabla-reservas th, .tabla-reservas td {
            padding: 12px 14px;
            border-bottom: 1px solid #e0d5c8;
            text-align: left;
        }
        .tabla-reservas th {
            background-color: #6f4e37;
            color: #fff;
            font-family: 'Cinzel', serif;
            font-size: 0.95rem;
            letter-spacing: 0.5px;
        }
        .tabla-reservas tr:hover {
            background-color: #fbf8f5;
        }
        .btn-confirmar {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 8px 14px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.95rem;
            font-weight: 600;
            transition: background 0.2s;
        }
        .btn-confirmar:hover { background-color: #218838; }
        .btn-cancelar {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 8px 14px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.95rem;
            font-weight: 600;
            transition: background 0.2s;
        }
        .btn-cancelar:hover { background-color: #c82333; }
        .badge-stock {
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 0.9rem;
            background: #e9ecef;
            color: #333;
        }
        .badge-stock.bajo {
            background: #fff3cd;
            color: #856404;
        }
        .nav-links {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .nav-links a {
            color: #6f4e37;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
        }
        .nav-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <div id="logo">
            <img src="Assets/Logo transparente.png" alt="logo-libro&latte">
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
        <p class="panel-subtitle">Solo el bibliotecario o administrador puede concretar la venta y descontar stock.</p>

        <?php if (isset($_GET['venta']) && $_GET['venta'] === 'ok'): ?>
            <div class="alert alert-success">¡Venta confirmada con éxito! El stock ha sido actualizado.</div>
        <?php elseif (isset($_GET['cancelada']) && $_GET['cancelada'] === 'ok'): ?>
            <div class="alert alert-success">La reserva ha sido cancelada correctamente.</div>
        <?php elseif (isset($_GET['error']) && $_GET['error'] === 'sin_stock'): ?>
            <div class="alert alert-error">Error: No hay suficiente stock para concretar la venta de este libro.</div>
        <?php endif; ?>

        <?php if (empty($reservas)): ?>
            <p style="text-align: center; font-size: 1.3rem; color: #888; padding: 30px;">
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
                                <div style="display: flex; gap: 6px;">
                                    <form method="POST" action="Index.php?action=confirmar_venta" onsubmit="return confirm('¿Confirmar cobro y venta de este libro?');">
                                        <input type="hidden" name="id_venta" value="<?= (int)$reserva['id'] ?>">
                                        <button type="submit" class="btn-confirmar">Vender</button>
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
            <h3 class="panel-title" style="font-size: 1.5rem; margin-top: 40px;">Últimas Ventas Concretadas</h3>
            <table class="tabla-reservas" style="margin-top: 15px;">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fecha Venta</th>
                        <th>Cliente</th>
                        <th>Libro</th>
                        <th>Cant.</th>
                        <th>Total</th>
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
