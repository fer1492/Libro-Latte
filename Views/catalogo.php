<?php
// Views/catalogo.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$esBibliotecario = isset($_SESSION['usuario_rol']) && in_array(strtolower(trim((string)$_SESSION['usuario_rol'])), ['bibliotecario', 'admin', 'root']);
$estaLogueado = isset($_SESSION['usuario_cedula']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo - Libro&Latte</title>
    <link rel="stylesheet" href="css/Style.css">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700&family=Cormorant+Garamond:wght@400;600&display=swap" rel="stylesheet">
    <style>
        .catalogo-header-nav {
            display: flex;
            gap: 15px;
            align-items: center;
        }
        .catalogo-header-nav a {
            color: #f7ede2;
            text-decoration: none;
            font-size: 1.05rem;
            font-family: 'Cinzel', serif;
            padding: 6px 12px;
            border-radius: 4px;
            background: rgba(0,0,0,0.15);
            transition: background 0.2s;
        }
        .catalogo-header-nav a:hover {
            background: rgba(0,0,0,0.35);
        }
        .alerta-catalogo {
            max-width: 850px;
            margin: 20px auto;
            padding: 14px 22px;
            border-radius: 8px;
            text-align: center;
            font-size: 1.15rem;
            font-weight: 600;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        }
        .alerta-ok { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alerta-err { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .alerta-aviso { 
            background: #fff3cd; 
            color: #856404; 
            border: 1px solid #ffeeba; 
        }
        .alerta-aviso a {
            color: #533f03;
            text-decoration: underline;
            font-weight: bold;
            margin: 0 5px;
            cursor: pointer;
        }
        .btn-reservar-card {
            background-color: #6f4e37;
            color: #fff;
            border: none;
            padding: 10px 16px;
            border-radius: 5px;
            cursor: pointer;
            font-family: 'Cinzel', serif;
            font-size: 0.95rem;
            margin-top: 12px;
            width: 100%;
            transition: background 0.2s;
        }
        .btn-reservar-card:hover {
            background-color: #4a2e18;
        }
        .btn-admin-badge {
            background-color: #8b7355;
            color: #fff;
            border: none;
            padding: 10px 16px;
            border-radius: 5px;
            font-family: 'Cinzel', serif;
            font-size: 0.9rem;
            margin-top: 12px;
            width: 100%;
            cursor: default;
            opacity: 0.85;
            text-align: center;
            display: block;
            box-sizing: border-box;
        }
        /* Modal aviso para clientes no registrados */
        #modal-aviso-socio {
            display: none;
            flex-direction: column !important;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            padding: 30px 25px 25px 25px;
            border-radius: 12px;
            text-align: center;
            width: 380px;
            max-width: 90vw;
            box-shadow: 0 10px 30px rgba(0,0,0,0.4);
            position: relative;
            box-sizing: border-box;
            z-index: 1001;
            font-family: 'Cormorant Garamond', serif;
        }
        #modal-aviso-socio .close-button {
            position: absolute;
            top: 10px;
            right: 15px;
            border: none;
            background: transparent;
            font-size: 22px;
            cursor: pointer;
            color: #70452F;
            font-weight: bold;
            line-height: 1;
        }
        #modal-aviso-socio h3 {
            font-family: 'Cinzel', serif;
            color: #70452F;
            margin: 10px 0 15px 0;
            font-size: 1.6rem;
            width: 100%;
            display: block;
        }
        #modal-aviso-socio p {
            font-size: 1.15rem;
            color: #555;
            margin: 0 0 20px 0;
            line-height: 1.45;
            width: 100%;
            display: block;
        }
        .btn-modal-opcion {
            display: block;
            width: 100%;
            padding: 12px 15px;
            margin: 6px 0;
            border-radius: 6px;
            text-decoration: none;
            font-family: 'Cinzel', serif;
            font-size: 0.95rem;
            font-weight: 600;
            box-sizing: border-box;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-modal-registro {
            background-color: #70452F;
            color: #ffffff;
            border: none;
        }
        .btn-modal-registro:hover {
            background-color: #553322;
        }
        .btn-modal-login {
            background-color: #f7ede2;
            color: #70452F;
            border: 1.5px solid #70452F;
        }
        .btn-modal-login:hover {
            background-color: #ebdcd0;
        }
    </style>
</head>
<body>
    <header>
        <div id="logo">
            <img src="Assets/Logo transparente.png" alt="logo-libro&latte">
        </div>

        <h1>Biblioteca Libro&Latte</h1>

        <nav class="catalogo-header-nav">
            <a href="Index.php?action=inicio">Inicio</a>
            <?php if ($estaLogueado && !$esBibliotecario): ?>
                <a href="Index.php?action=mis_reservas">Mis Reservas</a>
            <?php endif; ?>
            <?php if ($esBibliotecario): ?>
                <a href="Index.php?action=panel_reservas">Panel Reservas</a>
                <a href="Index.php?action=formulario_libro">Agregar Libro</a>
            <?php endif; ?>
            <?php if ($estaLogueado): ?>
                <span style="color: #ffd8a8; font-family: 'Cinzel', serif; font-size: 0.95rem; margin-left: 10px;">
                    ¡Hola, <?= htmlspecialchars($_SESSION['usuario_nombre'] ?? 'Socio', ENT_QUOTES, 'UTF-8') ?>!
                </span>
                <a href="Index.php?action=logout" style="background: #dc3545; color: white;">Cerrar Sesión</a>
            <?php else: ?>
                <a href="#" id="nav-btn-login">Iniciar Sesión</a>
                <a href="#" id="nav-btn-register" style="background: #6f4e37; color: white;">Registrarse</a>
            <?php endif; ?>
        </nav>
    </header>

    <main class="catalogo">
        <h2>Nuestro Catálogo de Libros</h2>

        <!-- Mensajes informativos amigables -->
        <?php if (isset($_GET['reserva']) && $_GET['reserva'] === 'ok'): ?>
            <div class="alerta-catalogo alerta-ok">
                ¡Tu reserva ha sido registrada con éxito! Pasa por la biblioteca para que el personal bibliotecario te entregue el libro.
            </div>
        <?php elseif (isset($_GET['aviso']) && $_GET['aviso'] === 'registro_requerido'): ?>
            <div class="alerta-catalogo alerta-aviso">
                📖 <strong>¡Atención!</strong> Para reservar este libro necesitas una cuenta de socio. 
                <a href="#" class="trigger-modal-registro">Regístrate aquí</a> o 
                <a href="#" class="trigger-modal-login">inicia sesión</a>.
            </div>
        <?php elseif (isset($_GET['error'])): ?>
            <div class="alerta-catalogo alerta-err">
                <?php if ($_GET['error'] === 'sin_stock'): ?>
                    No hay stock disponible para reservar este libro.
                <?php elseif ($_GET['error'] === 'admin_no_puede_reservar'): ?>
                    Los administradores y bibliotecarios no pueden realizar reservas de libros.
                <?php else: ?>
                    Ocurrió un inconveniente al procesar tu solicitud.
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="libros-grid">
            <?php if (empty($libros)): ?>
                <p class="sin-libros">
                    Actualmente no disponemos de libros disponibles.
                </p>
            <?php else: ?>
                <?php foreach ($libros as $libro): ?>
                    <article class="libro">
                        <?php if (!empty($libro['imagen'])): ?>
                            <img src="<?= htmlspecialchars($libro['imagen'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($libro['titulo'], ENT_QUOTES, 'UTF-8') ?>">
                        <?php endif; ?>

                        <h3><?= htmlspecialchars($libro['titulo'], ENT_QUOTES, 'UTF-8') ?></h3>

                        <p><strong>Autor:</strong> <?= htmlspecialchars($libro['autor'], ENT_QUOTES, 'UTF-8') ?></p>

                        <p><strong>Precio:</strong> $<?= number_format((float)$libro['precio'], 2, ',', '.') ?></p>

                        <p class="disponible"><strong>Disponible en Stock:</strong> <?= (int)$libro['stock'] ?></p>

                        <?php if (!empty($libro['descripcion'])): ?>
                            <p class="descripcion"><?= htmlspecialchars($libro['descripcion'], ENT_QUOTES, 'UTF-8') ?></p>
                        <?php endif; ?>

                        <?php if ($esBibliotecario): ?>
                            <span class="btn-admin-badge">Modo Administrador</span>

                        <?php elseif ((int)$libro['stock'] > 0): ?>
                            <?php if ($estaLogueado): ?>
                                <!-- Cliente autenticado: procesa la reserva -->
                                <form method="POST" action="Index.php?action=reservar">
                                    <input type="hidden" name="isbn" value="<?= htmlspecialchars($libro['isbn'], ENT_QUOTES, 'UTF-8') ?>">
                                    <input type="hidden" name="cantidad" value="1">
                                    <button type="submit" class="btn-reservar-card">Reservar libro</button>
                                </form>
                            <?php else: ?>
                                <!-- Visitante sin cuenta: abre invitación amigable a registrarse -->
                                <button type="button" class="btn-reservar-card btn-requiere-registro" data-titulo="<?= htmlspecialchars($libro['titulo'], ENT_QUOTES, 'UTF-8') ?>">
                                    Reservar libro
                                </button>
                            <?php endif; ?>

                        <?php else: ?>
                            <button type="button" class="btn-reservar-card" style="background: #999; cursor: not-allowed;" disabled>Sin Stock</button>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>

    <footer>LIBRO&LATTE</footer> 

    <!-- Contenedor de modales para el catálogo -->
    <div id="overlay" class="overlay">
        <!-- Modal informativo amigable antes de registrarse -->
        <div id="modal-aviso-socio" class="modal">
            <button class="close-button" type="button">x</button>
            <h3>¡Conviértete en Socio!</h3>
            <p id="aviso-socio-mensaje">
                Para reservar y retirar libros en <strong>Libro&Latte</strong> necesitas registrarte con tu cuenta de socio. ¡Es rápido y gratis!
            </p>
            <button type="button" class="btn-modal-opcion btn-modal-registro" id="btn-ir-modal-registro">
                Quiero Registrarme
            </button>
            <button type="button" class="btn-modal-opcion btn-modal-login" id="btn-ir-modal-login">
                Ya tengo cuenta (Iniciar Sesión)
            </button>
        </div>

        <?php require_once __DIR__ . '/login.php'; ?>
        <?php require_once __DIR__ . '/registro.php'; ?>
    </div>

    <!-- Scripts de modales para Catálogo -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const overlay = document.getElementById("overlay");
            const modalAviso = document.getElementById("modal-aviso-socio");
            const modalLogin = document.getElementById("modal-login");
            const modalRegister = document.getElementById("modal-register");

            function cerrarModales() {
                if (overlay) overlay.classList.remove("overlay-open");
                if (modalAviso) modalAviso.style.display = "none";
                if (modalLogin) modalLogin.style.display = "none";
                if (modalRegister) modalRegister.style.display = "none";
            }

            function abrirModal(modal) {
                cerrarModales();
                if (overlay && modal) {
                    overlay.classList.add("overlay-open");
                    modal.style.display = "flex";
                }
            }

            // Botones de cerrar (x)
            document.querySelectorAll(".close-button").forEach(btn => {
                btn.addEventListener("click", cerrarModales);
            });

            // Cerrar al hacer clic en el fondo oscuro
            if (overlay) {
                overlay.addEventListener("click", function (e) {
                    if (e.target === overlay) cerrarModales();
                });
            }

            // Cuando un visitante no logueado hace clic en "Reservar libro"
            document.querySelectorAll(".btn-requiere-registro").forEach(btn => {
                btn.addEventListener("click", function () {
                    const titulo = this.getAttribute("data-titulo") || "este libro";
                    const txt = document.getElementById("aviso-socio-mensaje");
                    if (txt) {
                        txt.innerHTML = "Para reservar <strong>" + titulo + "</strong> y retirarlo en la biblioteca, necesitas una cuenta de socio. ¡Es rápido y gratis!";
                    }
                    abrirModal(modalAviso);
                });
            });

            // Opciones del modal de aviso
            const btnIrRegistro = document.getElementById("btn-ir-modal-registro");
            if (btnIrRegistro) {
                btnIrRegistro.addEventListener("click", function () {
                    abrirModal(modalRegister);
                });
            }

            const btnIrLogin = document.getElementById("btn-ir-modal-login");
            if (btnIrLogin) {
                btnIrLogin.addEventListener("click", function () {
                    abrirModal(modalLogin);
                });
            }

            // Links directos desde el header o alertas
            const navLogin = document.getElementById("nav-btn-login");
            if (navLogin) navLogin.addEventListener("click", (e) => { e.preventDefault(); abrirModal(modalLogin); });

            const navRegister = document.getElementById("nav-btn-register");
            if (navRegister) navRegister.addEventListener("click", (e) => { e.preventDefault(); abrirModal(modalRegister); });

            document.querySelectorAll(".trigger-modal-registro").forEach(el => {
                el.addEventListener("click", (e) => { e.preventDefault(); abrirModal(modalRegister); });
            });
            document.querySelectorAll(".trigger-modal-login").forEach(el => {
                el.addEventListener("click", (e) => { e.preventDefault(); abrirModal(modalLogin); });
            });
        });
    </script>
</body>
</html>
