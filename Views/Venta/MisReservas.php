<?php
// Views/Venta/MisReservas.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Reservas - Libro&Latte</title>
    <link rel="stylesheet" href="css/Style.css">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700&family=Cormorant+Garamond:wght@400;600&display=swap" rel="stylesheet">
    <style>
        .reservas-container {
            max-width: 900px;
            margin: 40px auto;
            padding: 25px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            font-family: 'Cormorant Garamond', serif;
        }
        .reservas-title {
            font-family: 'Cinzel', serif;
            color: #4a2e18;
            font-size: 2rem;
            text-align: center;
            margin-bottom: 20px;
        }
        .tabla-mis-reservas {
            width: 100%;
            border-collapse: collapse;
            font-size: 1.15rem;
        }
        .tabla-mis-reservas th, .tabla-mis-reservas td {
            padding: 12px 14px;
            border-bottom: 1px solid #e0d5c8;
            text-align: left;
        }
        .tabla-mis-reservas th {
            background-color: #6f4e37;
            color: #fff;
            font-family: 'Cinzel', serif;
        }
        .estado-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: capitalize;
        }
        .estado-reserva { background: #fff3cd; color: #856404; }
        .estado-vendido { background: #d4edda; color: #155724; }
        .estado-cancelado { background: #f8d7da; color: #721c24; }
        .btn-cancelar-sm {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.85rem;
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

    <main class="reservas-container">
        <div style="margin-bottom: 20px;">
            <a href="Index.php?action=inicio" style="color: #6f4e37; text-decoration: none; font-weight: 600;">&larr; Volver al Inicio</a>
            &nbsp;|&nbsp;
            <a href="Index.php?action=catalogo" style="color: #6f4e37; text-decoration: none; font-weight: 600;">Ver Catálogo</a>
        </div>

        <h2 class="reservas-title">Mis Reservas y Compras</h2>

        <?php if (empty($historial)): ?>
            <p style="text-align: center; color: #777; padding: 30px; font-size: 1.2rem;">
                Aún no has realizado ninguna reserva. ¡Visita nuestro <a href="Index.php?action=catalogo">Catálogo</a> para elegir tus libros favoritos!
            </p>
        <?php else: ?>
            <table class="tabla-mis-reservas">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Libro</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($historial as $item): ?>
                        <tr>
                            <td><?= date('d/m/Y', strtotime($item['fecha'])) ?></td>
                            <td><strong><?= htmlspecialchars($item['libro_titulo'], ENT_QUOTES, 'UTF-8') ?></strong></td>
                            <td><?= (int)$item['cantidad'] ?></td>
                            <td>$<?= number_format((float)$item['total'], 2, ',', '.') ?></td>
                            <td>
                                <span class="estado-badge estado-<?= htmlspecialchars($item['estado'], ENT_QUOTES, 'UTF-8') ?>">
                                    <?= htmlspecialchars($item['estado'], ENT_QUOTES, 'UTF-8') ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($item['estado'] === 'reserva'): ?>
                                    <form method="POST" action="Index.php?action=cancelar_reserva" onsubmit="return confirm('¿Deseas cancelar tu reserva?');">
                                        <input type="hidden" name="id_venta" value="<?= (int)$item['id'] ?>">
                                        <button type="submit" class="btn-cancelar-sm">Cancelar</button>
                                    </form>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </main>

    <footer>LIBRO&LATTE</footer>
</body>
</html>
