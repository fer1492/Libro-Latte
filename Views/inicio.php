<?php
// Views/inicio.php
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
    <meta name="author" content="Libro&Latte: Mauricio, Nicolas, Julio, Fernando...">
    <meta name="description" content="Proyecto Semestral TH2: Libro&Latte">
    <title>Bienvenidos a Libro&Latte</title>
    
    <!-- Rutas apuntando a las carpetas dentro de Public -->
    <link rel="stylesheet" href="../Public/css/Style.css">
    <link rel="stylesheet" href="../Public/css/Media-Querry.css">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700&family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/e7c741f98a.js" crossorigin="anonymous"></script>
</head>
<body>
    
    <header>
        <div id="logo">
            <a href="<?php echo BASE_URL; ?>index.php?action=inicio">
                <img src="<?php echo BASE_URL; ?>Assets/Logo transparente.png" alt="Logo">
            </a>
        </div>

        <h1>Biblioteca Libro&Latte</h1>
        
        <div id="header-links">
            <nav>
                <ul>
                    <li><a class="header-links" href="Index.php?action=catalogo">Catálogo Disponible</a></li>
                    <li><a class="header-links" href="#favourites">Favoritos y Recomendaciones</a></li>
                    <li><a class="header-links" href="#Search">Búsqueda</a></li>
                    <?php if ($estaLogueado && !$esBibliotecario): ?>
                        <li><a class="header-links" href="Index.php?action=mis_reservas">Mis Reservas</a></li>
                    <?php endif; ?>
                    <?php if ($esBibliotecario): ?>
                        <li><a class="header-links" href="Index.php?action=formulario_libro">Agregar libro</a></li>
                        <li><a class="header-links" href="Index.php?action=panel_reservas">Panel Reservas</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div> 

        <!-- Menú de usuario ubicado de forma independiente y libre en el header -->
        <div id="user-menu" class="user-menu">
            <?php if ($estaLogueado): ?>
                <span class="saludo-usuario-header">
                    ¡Hola, <?= htmlspecialchars($_SESSION['usuario_nombre'] ?? 'Socio', ENT_QUOTES, 'UTF-8') ?>!
                </span>
            <?php endif; ?>
            <button id="button-user" type="button">
                <img id="user" src="Assets/icons/icono usuario.png" alt="user">
            </button>

            <div id="user-inactive">
                <?php if ($estaLogueado): ?>
                    <p style="font-size: 0.95rem; font-weight: bold; color: #4a2e18; margin: 0; text-align: center;">
                        ¡Hola, <?= htmlspecialchars(trim(($_SESSION['usuario_nombre'] ?? '') . ' ' . ($_SESSION['usuario_apellido'] ?? '')), ENT_QUOTES, 'UTF-8') ?>!
                    </p>
                    <span class="badge-rol">(<?= htmlspecialchars($_SESSION['usuario_rol'] ?? 'Socio', ENT_QUOTES, 'UTF-8') ?>)</span>
                    <hr class="line-user">
                    <?php if ($esBibliotecario): ?>
                        <a href="Index.php?action=panel_reservas" class="user-menu-link-btn">Panel Reservas</a>
                        <a href="Index.php?action=formulario_libro" class="user-menu-link-btn">Agregar Libro</a>
                    <?php else: ?>
                        <a href="Index.php?action=mis_reservas" class="user-menu-link-btn">Mis Reservas</a>
                    <?php endif; ?>
                    <hr class="line-user">
                    <a href="Index.php?action=logout" class="user-menu-link-btn btn-logout">Cerrar Sesión</a>
                <?php else: ?>
                    <p>Profile</p>
                    <hr class="line-user">
                    <button class="user-menu-link" id="user-menu-link-login" type="button">Inicio de Sesión</button>
                    <button class="user-menu-link" id="user-menu-link-register" type="button">Registro</button>
                <?php endif; ?>
            </div>
        </div> 
    </header>

    <main>
        <?php if ($estaLogueado): ?>
            <div class="banner-bienvenida">
                <span>
                    👋 ¡Hola, <strong><?= htmlspecialchars(trim(($_SESSION['usuario_nombre'] ?? '') . ' ' . ($_SESSION['usuario_apellido'] ?? '')), ENT_QUOTES, 'UTF-8') ?></strong>! Bienvenido a tu cuenta en Libro&Latte.
                </span>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['reserva']) && $_GET['reserva'] === 'ok'): ?>
            <div class="banner-bienvenida" style="background: #d4edda; border-color: #28a745; color: #155724;">
                <span>¡Tu reserva ha sido registrada con éxito! Pasa por la biblioteca para que el personal te entregue el libro.</span>
            </div>
        <?php endif; ?>

        <section id="about">
            <h2>Sobre Nosotros</h2>
            <p>Te damos la bienvenida a Libro&Latte, una librería joven que fue creada para brindarte la mejor experiencia entre vos, un libro y café.</p> 
            <div id="carousel">
                <button class="prev" id="leftCarret" onclick="plusSlides(-1)" type="button">&lt;</button>
                <div id="carousel-img">
                    <img id="image1" src="Assets/valledelacalma.png" alt="library image" class="img">
                    <img id="image2" src="Assets/elhobbit.png" alt="library image" class="img">
                    <img id="image3" src="Assets/condorito.png" alt="library image" class="img">
                    <img id="image4" src="Assets/elultimomohicano.png" alt="library image" class="img">
                    <img id="image5" src="Assets/deadpool.png" alt="library image" class="img">
                </div>
                <button class="next" id="rightCarret" onclick="plusSlides(1)" type="button">&gt;</button>
            </div>      
        </section>

        <section id="favourites">
            <h2>Favoritos y Recomendaciones</h2> 
            <hr class="line">
            
            <fieldset>
                <legend>Elige Tus Favoritos</legend>

                <div class="fieldset-radio">
                    <input type="radio" id="ficcion" name="categoria" class="categoria" value="ficcion" checked>
                    <label for="ficcion">Ficción</label>
                </div>
                <div class="fieldset-radio">
                    <input type="radio" id="no-ficcion" name="categoria" class="categoria" value="no-ficcion">
                    <label for="no-ficcion">No Ficción</label>
                </div>
                <div class="fieldset-radio">
                    <input type="radio" id="infantil-y-juvenil" name="categoria" class="categoria" value="infantil-y-juvenil">
                    <label for="infantil-y-juvenil">Infantil y Juvenil</label>
                </div>
                <div class="fieldset-radio">
                    <input type="radio" id="textos" name="categoria" class="categoria" value="textos">
                    <label for="textos">Textos</label>
                </div>
                <div class="fieldset-radio">
                    <input type="radio" id="manga" name="categoria" class="categoria" value="manga">
                    <label for="manga">Manga</label>
                </div>
                <div class="fieldset-radio">
                    <input type="radio" id="comic" name="categoria" class="categoria" value="comic">
                    <label for="comic">Cómic</label>
                </div>
            </fieldset>

            <div id="Favorite-items">
                <?php if (empty($libros)): ?>
                    <p id="sin-libros-general" style="text-align: center; color: #70452F; font-size: 1.2rem; font-family: 'Cinzel', serif; margin: 30px auto; width: 100%;">
                        Actualmente no disponemos de libros cargados en el sistema.
                    </p>
                <?php else: ?>
                    <?php foreach ($libros as $libro): ?>
                        <?php 
                            $catLibro = strtolower(trim($libro['categoria'] ?? 'ficcion'));
                            $esFiccion = ($catLibro === 'ficcion');
                        ?>
                        <div class="favourites-items <?= htmlspecialchars($catLibro, ENT_QUOTES, 'UTF-8') ?> <?= $esFiccion ? '' : 'hidden' ?>" data-categoria="<?= htmlspecialchars($catLibro, ENT_QUOTES, 'UTF-8') ?>">
                            <h3>
                                <?= htmlspecialchars($libro['titulo'], ENT_QUOTES, 'UTF-8') ?><br>
                                <span style="font-size: 1rem; color: #555;">De: <?= htmlspecialchars($libro['autor'], ENT_QUOTES, 'UTF-8') ?></span>
                            </h3>

                            <?php if (!empty($libro['descripcion'])): ?>
                                <p class="book-description">
                                    <?= htmlspecialchars($libro['descripcion'], ENT_QUOTES, 'UTF-8') ?>
                                </p>
                            <?php endif; ?>

                            <p class="stock-info" style="margin: 10px 0; font-size: 1.05rem;">
                                <strong>Precio:</strong> $<?= number_format((float)$libro['precio'], 2, ',', '.') ?> &nbsp;|&nbsp;
                                <strong>Stock:</strong> 
                                <?php if ((int)$libro['stock'] > 0): ?>
                                    <span style="color: #2e7d32; font-weight: bold;"><?= (int)$libro['stock'] ?> disponibles</span>
                                <?php else: ?>
                                    <span style="color: #c62828; font-weight: bold;">Sin stock</span>
                                <?php endif; ?>
                            </p>

                            <div class="acciones-libro" style="margin: 10px 0;">
                                <?php if ($esBibliotecario): ?>
                                    <span class="btn-admin-badge" style="display:inline-block; max-width: 200px; text-align: center;">Modo Administrador</span>
                                <?php elseif ((int)$libro['stock'] > 0): ?>
                                    <?php if ($estaLogueado): ?>
                                        <form method="POST" action="Index.php?action=reservar" style="display:inline-block;">
                                            <input type="hidden" name="isbn" value="<?= htmlspecialchars($libro['isbn'], ENT_QUOTES, 'UTF-8') ?>">
                                            <input type="hidden" name="cantidad" value="1">
                                            <button type="submit" class="buy">Reservar Ahora</button>
                                        </form>
                                    <?php else: ?>
                                        <button type="button" class="buy btn-requiere-registro" data-titulo="<?= htmlspecialchars($libro['titulo'], ENT_QUOTES, 'UTF-8') ?>">
                                            Reservar Ahora
                                        </button>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <button type="button" class="buy" style="background-color: #999; cursor: not-allowed;" disabled>
                                        Sin Stock
                                    </button>
                                <?php endif; ?>
                            </div>

                            <?php if (!empty($libro['imagen'])): ?>
                                <img src="<?= htmlspecialchars($libro['imagen'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($libro['titulo'], ENT_QUOTES, 'UTF-8') ?>" class="img-books">
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <p id="sin-libros-categoria-msg" class="hidden" style="text-align: center; color: #70452F; font-size: 1.2rem; font-family: 'Cinzel', serif; margin: 30px auto; width: 100%;">
                    Actualmente no disponemos de libros en esta categoría.
                </p>
            </div>
        </section>

        <section id="Search">
            <h2>Búsqueda por título, autor, código ISBN</h2> 
            <hr class="line">

            <form class="search-form" action="Index.php" method="GET">
                <input type="hidden" name="action" value="buscar_isbn">

                <input
                    type="search"
                    id="search-input"
                    name="isbn"
                    placeholder="Ingresa el código ISBN"
                    value="<?= htmlspecialchars($_GET['isbn'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                    required
                > 

                <button type="submit" id="search-button">Buscar</button>
            </form>

            <div id="search-result">
                <?php if (!empty($mensajeBusqueda)): ?>
                    <p class="mensaje-busqueda">
                        <?= htmlspecialchars($mensajeBusqueda, ENT_QUOTES, 'UTF-8') ?>
                    </p>
                <?php endif;?>

                <?php if (!empty($resultado)): ?>
                    <article class="resultado-libro">
                        <h3>
                            <?= htmlspecialchars($resultado['titulo'], ENT_QUOTES, 'UTF-8') ?>
                        </h3>

                        <p>
                            <strong>Autor:</strong>
                            <?= htmlspecialchars($resultado['autor'], ENT_QUOTES, 'UTF-8') ?>
                        </p>

                        <p>
                            <strong>Precio:</strong>
                            $<?= number_format((float)$resultado['precio'], 2, ',', '.') ?>
                        </p>

                        <p>
                            <strong>Stock Disponible:</strong>
                            <?= (int)$resultado['stock'] ?>
                        </p>

                        <div style="margin-top: 15px;">
                            <?php if ($esBibliotecario): ?>
                                <span class="btn-admin-badge" style="display:inline-block; max-width: 200px;">Modo Administrador</span>
                            <?php elseif ((int)$resultado['stock'] > 0): ?>
                                <?php if ($estaLogueado): ?>
                                    <form method="POST" action="Index.php?action=reservar" style="display:inline-block;">
                                        <input type="hidden" name="isbn" value="<?= htmlspecialchars($resultado['isbn'], ENT_QUOTES, 'UTF-8') ?>">
                                        <input type="hidden" name="cantidad" value="1">
                                        <button type="submit" class="buy">Reservar Ahora</button>
                                    </form>
                                <?php else: ?>
                                    <button type="button" class="buy btn-requiere-registro" data-titulo="<?= htmlspecialchars($resultado['titulo'], ENT_QUOTES, 'UTF-8') ?>">
                                        Reservar Ahora
                                    </button>
                                <?php endif; ?>
                            <?php else: ?>
                                <button type="button" class="buy" style="background-color: #999; cursor: not-allowed;" disabled>
                                    Sin Stock
                                </button>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endif; ?>
            </div>
        </section>

        <section id="our-contacts">
            <h2>Ponte en contacto con nosotros</h2>
            <hr class="line">
            <div id="info">
                <ol id="contact">
                    <li>Por Consultas:
                        <a class="tel" href="tel:+59822086787" target="_blank">(+598)22086787</a>
                    </li>
                    <li>Servicio Técnico de Cuenta:
                        <a class="tel" href="tel:+59822086787" target="_blank">(+598)22086787</a>
                    </li>
                    <li id="contact-staff">Contacto vía email:
                        <a id="mail" href="mailto:contacto@libro&latte.com" target="_blank">Atención Cliente</a> 
                    </li>
                </ol>

                <a class="adress" href="https://maps.app.goo.gl/uGDPaUuvHJdRLTxd7" target="_blank">
                    <img id="map" src="Assets/icons/mapa icono.png" alt="map">
                </a>
            </div> 
        </section>
    </main>

    <footer>LIBRO&LATTE</footer> 

    <!-- Contenedor general para modales flotantes -->
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

    <!-- Script JS desde la carpeta Public -->
    <script src="JS/index.js" defer></script>
    <a href="https://wa.me/59899123456?text=Hola,%20tengo%20una%20duda%20con%20el%20sistema%20de%20Libro-Latte" 
       target="_blank" 
       class="whatsapp-float" 
       title="Soporte por WhatsApp">
        💬
    </a>
</body>
</html>
