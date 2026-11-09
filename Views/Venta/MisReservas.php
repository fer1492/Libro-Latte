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

    <main class="reservas-container">
        <div class="reservas-nav">
            <a href="Index.php?action=inicio">&larr; Volver al Inicio</a>
            &nbsp;|&nbsp;
            <a href="Index.php?action=catalogo">Ver Catálogo</a>
        </div>

        <h2 class="reservas-title">Mis Reservas y Compras</h2>

        <?php if (empty($historial)): ?>
            <p class="reservas-vacio">
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
                                <?php
                                $textoEstado = match($item['estado']) {
                                    'reserva'   => 'Pendiente de retiro',
                                    'vendido'   => 'Comprado / Finalizado',
                                    'cancelado' => 'Cancelado',
                                    default     => ucfirst($item['estado'])
                                };
                                ?>
                                <span class="estado-badge estado-<?= htmlspecialchars($item['estado'], ENT_QUOTES, 'UTF-8') ?>">
                                    <?= htmlspecialchars($textoEstado, ENT_QUOTES, 'UTF-8') ?>
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