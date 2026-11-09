
<?php
// Views/catalogo.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$esBibliotecario = isset($_SESSION['usuario_rol']) &&
    strtolower(trim((string)$_SESSION['usuario_rol'])) === 'bibliotecario';

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
        /* =====================================
/* =====================================
   ESTRELLAS INTERACTIVAS DE RESEÑA
===================================== */
.estrellas-rating {
    display: flex;
    justify-content: center;
    gap: 4px;
    cursor: pointer;
    margin: 5px auto;
    unicode-bidi: bidi-override;
    direction: rtl; /* Invierte el orden lógico para que el hover pinte hacia la izquierda correctamente */
}

.estrellas-rating input {
    display: none;
}

.estrellas-rating label {
    font-size: 1.5rem;
    color: #d8c4ae; /* Color estrella vacía */
    transition: color 0.2s ease;
    direction: ltr; /* Mantiene la estrella orientada normalmente */
}

/* Pintar al pasar el mouse o al estar seleccionada de izquierda a derecha */
.estrellas-rating input:checked ~ label,
.estrellas-rating label:hover,
.estrellas-rating label:hover ~ label {
    color: #f5b301; /* Color estrella dorada */
}

        /* =====================================
           NAVEGACIÓN DEL CATÁLOGO
        ===================================== */

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


        /* =====================================
           DISTRIBUCIÓN DEL CATÁLOGO
        ===================================== */

        .catalogo-layout {
            display: grid;
            grid-template-columns: 230px minmax(0, 1fr);
            gap: 30px;
            align-items: start;
            margin-top: 30px;
        }

        .catalogo-contenido {
            min-width: 0;
        }


        /* =====================================
           FILTROS LATERALES
        ===================================== */

        .filtros-categorias {
            background-color: #fffaf3;
            border: 1px solid #d8c4ae;
            border-radius: 10px;
            padding: 20px;
            color: #432719;
            width: 100%;
            box-sizing: border-box;
        }

        .filtros-categorias h3 {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            color: #70452F;
            margin: 0 0 20px;
        }

        .filtros-categorias form {
            display: flex;
            flex-direction: column;
            align-items: stretch;
            gap: 15px;
        }

        .filtros-categorias label {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            font-size: 15px;
        }

        .filtros-categorias input[type="checkbox"] {
            accent-color: #70452F;
            width: 17px;
            height: 17px;
            cursor: pointer;
        }

        .filtros-categorias button {
            background-color: #70452F;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 10px;
            cursor: pointer;
            font-family: 'Cinzel', serif;
            transition: background 0.2s;
        }

        .filtros-categorias button:hover {
            background-color: #432719;
        }

        .filtros-categorias a {
            color: #70452F;
            text-align: center;
            font-size: 14px;
            text-decoration: underline;
        }


        /* =====================================
           MENSAJES INFORMATIVOS
        ===================================== */

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

        .alerta-ok {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alerta-err {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

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


        /* =====================================
           BOTONES DE RESERVA
        ===================================== */

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


        /* =====================================
           BOTONES DE ADMINISTRACIÓN
        ===================================== */

        .acciones-admin {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 15px;
        }

        .btn-editar-libro,
        .btn-eliminar-libro {
            display: block;
            width: 100%;
            padding: 10px 14px;
            border: none;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            font-family: 'Cinzel', serif;
            font-size: 0.9rem;
            cursor: pointer;
            box-sizing: border-box;
            transition: background 0.2s;
        }

        .btn-editar-libro {
            background-color: #8b7355;
            color: #fff;
        }

        .btn-editar-libro:hover {
            background-color: #6f4e37;
        }

        .btn-eliminar-libro {
            background-color: #a83232;
            color: #fff;
        }

        .btn-eliminar-libro:hover {
            background-color: #7d2020;
        }


        /* =====================================
           MODAL DE AVISO PARA VISITANTES
        ===================================== */

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


        /* =====================================
           DISEÑO RESPONSIVE
        ===================================== */

        @media (max-width: 768px) {

            .catalogo-layout {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .filtros-categorias {
                max-width: 100%;
            }

            .catalogo-header-nav {
                flex-wrap: wrap;
                justify-content: center;
            }
        }

    .categoria-opcion {
    display: flex;
    align-items: center;
    gap: 10px;
    width: 100%;
}

    .categoria-nombre {
    flex: 1;
}

    .categoria-cantidad {
    background: #eadccc;
    color: #70452F;
    border-radius: 12px;
    padding: 2px 9px;
    font-size: 13px;
    font-weight: bold;
}

    </style>

</head>

<body>

    <!-- =====================================
         ENCABEZADO
    ===================================== -->

    <header>

        <div id="logo">
            <a href="Index.php?action=inicio">
                <img src="Assets/Logo transparente.png" alt="logo-libro&latte">
            </a>
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

                <a href="Index.php?action=logout" style="background: #dc3545; color: white;">
                    Cerrar Sesión
                </a>

            <?php else: ?>

                <a href="#" id="nav-btn-login">Iniciar Sesión</a>

                <a href="#" id="nav-btn-register" style="background: #6f4e37; color: white;">
                    Registrarse
                </a>

            <?php endif; ?>

        </nav>

    </header>


    <!-- =====================================
         CATÁLOGO PRINCIPAL
    ===================================== -->

    <main class="catalogo">

        <h2>Nuestro Catálogo de Libros</h2>

        <!-- Mensajes del Sistema -->
        <?php if (isset($_GET['registro']) && $_GET['registro'] === 'ok'): ?>
            <div style="background: #d4edda; border-left: 5px solid #28a745; color: #155724; padding: 12px 20px; margin-bottom: 20px; border-radius: 6px;">
                🎉 <strong>¡Registro exitoso!</strong> Tu cuenta de socio ha sido creada y tu sesión ya está iniciada.
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['reserva']) && $_GET['reserva'] === 'ok'): ?>
            <div style="background: #d4edda; border-left: 5px solid #28a745; color: #155724; padding: 12px 20px; margin-bottom: 20px; border-radius: 6px;">
                📚 <strong>¡Reserva confirmada con éxito!</strong> Puedes consultar el estado en la sección <a href="Index.php?action=mis_reservas" style="color: #155724; font-weight: bold; text-decoration: underline;">Mis Reservas</a> y retirarlo en la biblioteca.
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['login']) && $_GET['login'] === 'ok'): ?>
            <div style="background: #d4edda; border-left: 5px solid #28a745; color: #155724; padding: 12px 20px; margin-bottom: 20px; border-radius: 6px;">
                👋 <strong>¡Bienvenido!</strong> Sesión iniciada correctamente.
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error_registro'])): ?>
            <?php 
                $errMap = [
                    'cedula_repetida' => 'La cédula ingresada ya está registrada.',
                    'email_repetido' => 'El correo electrónico ya está en uso.',
                    'password_corta' => 'La contraseña debe tener al menos 8 caracteres.',
                    'campos_vacios' => 'Completa todos los campos obligatorios.',
                    'email_invalido' => 'El correo electrónico no es válido.',
                    'fallo_bd' => 'No se pudo guardar el usuario en la base de datos.'
                ];
                $msg = $errMap[$_GET['error_registro']] ?? 'Ocurrió un error en el registro.';
            ?>
            <div style="background: #f8d7da; border-left: 5px solid #dc3545; color: #721c24; padding: 12px 20px; margin-bottom: 20px; border-radius: 6px;">
                ⚠️ <strong>Error en el registro:</strong> <?= htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error_login'])): ?>
            <div style="background: #f8d7da; border-left: 5px solid #dc3545; color: #721c24; padding: 12px 20px; margin-bottom: 20px; border-radius: 6px;">
                ⚠️ <strong>Error al ingresar:</strong> Correo o contraseña incorrectos.
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['aviso']) && $_GET['aviso'] === 'registro_requerido'): ?>
            <div style="background: #fff3cd; border-left: 5px solid #ffc107; color: #856404; padding: 12px 20px; margin-bottom: 20px; border-radius: 6px;">
                ℹ️ <strong>Para reservar:</strong> Debes registrarte como socio o iniciar sesión con tu cuenta.
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error']) && $_GET['error'] === 'admin_no_puede_reservar'): ?>
            <div style="background: #fff3cd; border-left: 5px solid #ffc107; color: #856404; padding: 12px 20px; margin-bottom: 20px; border-radius: 6px;">
                ℹ️ <strong>Rol administrativo:</strong> Las cuentas de administrador o bibliotecario no pueden realizar reservas de clientes.
            </div>
        <?php endif; ?>

        <div class="catalogo-layout">


            <!-- =====================================
                 FILTROS LATERALES
            ===================================== -->

            <aside class="filtros-categorias">

                <h3>Filtrar por categoría</h3>

                <form action="Index.php" method="GET">

                    <input type="hidden" name="action" value="catalogo">

    
    <?php foreach ($categoriasConCantidad as $categoriaInfo): ?>

    <?php
        $categoria = $categoriaInfo['categoria'];
        $cantidad = $categoriaInfo['cantidad'];
    ?>

    <label class="categoria-opcion">

        <input
            type="checkbox"
            name="categorias[]"
            value="<?= htmlspecialchars($categoria, ENT_QUOTES, 'UTF-8') ?>"
            <?= in_array($categoria, $categoriasSeleccionadas, true) ? 'checked' : '' ?>
        >

        <span class="categoria-nombre">
            <?= htmlspecialchars(ucfirst($categoria), ENT_QUOTES, 'UTF-8') ?>
        </span>

        <span class="categoria-cantidad">
            <?= (int)$cantidad ?>
        </span>

    </label>

<?php endforeach; ?>

                    <button type="submit">
                        Aplicar filtros
                    </button>

                    <a href="Index.php?action=catalogo">
                        Limpiar filtros
                    </a>

                </form>

            </aside>


            <!-- =====================================
                 CONTENIDO DE LOS LIBROS
            ===================================== -->

            <section class="catalogo-contenido">


                <!-- MENSAJE DE RESERVA EXITOSA -->

                <?php if (isset($_GET['reserva']) && $_GET['reserva'] === 'ok'): ?>

                    <div class="alerta-catalogo alerta-ok">
                        ¡Tu reserva ha sido registrada con éxito!
                        Pasa por la biblioteca para que el personal bibliotecario te entregue el libro.
                    </div>

                <?php endif; ?>


                <!-- MENSAJES DE GESTIÓN DE LIBROS -->

                <?php if (isset($_GET['gestion']) && $_GET['gestion'] === 'actualizado'): ?>

                    <div class="alerta-catalogo alerta-ok">
                        ¡Los datos del libro se actualizaron correctamente!
                    </div>

                <?php elseif (isset($_GET['gestion']) && $_GET['gestion'] === 'eliminado'): ?>

                    <div class="alerta-catalogo alerta-ok">
                        El libro fue eliminado del catálogo correctamente.
                    </div>

                <?php endif; ?>


                <!-- AVISO PARA VISITANTES -->

                <?php if (isset($_GET['aviso']) && $_GET['aviso'] === 'registro_requerido'): ?>

                    <div class="alerta-catalogo alerta-aviso">

                        📖 <strong>¡Atención!</strong>
                        Para reservar este libro necesitas una cuenta de socio.

                        <a href="#" class="trigger-modal-registro">Regístrate aquí</a>
                        o
                        <a href="#" class="trigger-modal-login">inicia sesión</a>.

                    </div>

                <?php endif; ?>


                <!-- MENSAJES DE ERROR -->

                <?php if (isset($_GET['error'])): ?>

                    <div class="alerta-catalogo alerta-err">

                        <?php if ($_GET['error'] === 'sin_stock'): ?>

                            No hay stock disponible para reservar este libro.

                        <?php elseif ($_GET['error'] === 'admin_no_puede_reservar'): ?>

                            Los administradores y bibliotecarios no pueden realizar reservas de libros.

                        <?php elseif ($_GET['error'] === 'reservas_pendientes'): ?>

                            No se puede eliminar este libro porque tiene reservas pendientes. Primero deben resolverse.

                        <?php elseif ($_GET['error'] === 'libro_no_encontrado'): ?>

                            No se encontró el libro solicitado.

                        <?php elseif ($_GET['error'] === 'eliminacion_fallida'): ?>

                            No se pudo eliminar el libro. Verificá que siga activo.

                        <?php elseif ($_GET['error'] === 'isbn_invalido'): ?>

                            El ISBN proporcionado no es válido.

                        <?php else: ?>

                            Ocurrió un inconveniente al procesar tu solicitud.

                        <?php endif; ?>

                    </div>

                <?php endif; ?>


                <!-- =====================================
                     GRILLA DE LIBROS
                ===================================== -->

                <div class="libros-grid">

                    <?php if (empty($libros)): ?>

                        <p class="sin-libros">
                            Actualmente no disponemos de libros disponibles.
                        </p>

                    <?php else: ?>

                        <?php foreach ($libros as $libro): ?>

                            <article class="libro">

                                <?php if (!empty($libro['imagen'])): ?>

                                    <img
                                        src="<?= htmlspecialchars($libro['imagen'], ENT_QUOTES, 'UTF-8') ?>"
                                        alt="<?= htmlspecialchars($libro['titulo'], ENT_QUOTES, 'UTF-8') ?>"
                                    >

                                <?php endif; ?>


                                <h3>
                                    <?= htmlspecialchars($libro['titulo'], ENT_QUOTES, 'UTF-8') ?>
                                </h3>


                                <p>
                                    <strong>Autor:</strong>
                                    <?= htmlspecialchars($libro['autor'], ENT_QUOTES, 'UTF-8') ?>
                                </p>


                                <p>
                                    <strong>Precio:</strong>
                                    $<?= number_format((float)$libro['precio'], 2, ',', '.') ?>
                                </p>


                                <p class="disponible">
                                    <strong>Disponible en Stock:</strong>
                                    <?= (int)$libro['stock'] ?>
                                </p>


                                <?php if (!empty($libro['descripcion'])): ?>

                                    <p class="descripcion">
                                        <?= htmlspecialchars($libro['descripcion'], ENT_QUOTES, 'UTF-8') ?>
                                    </p>

                                <?php endif; ?>
                                <?php if (!empty($libro['descripcion'])): ?>

            <p class="descripcion">
                <?= htmlspecialchars($libro['descripcion'], ENT_QUOTES, 'UTF-8') ?>
            </p>

        <?php endif; ?>

        <!-- =====================================
             SECCIÓN DE RESEÑAS DEL LIBRO
        ===================================== -->
        <div class="seccion-resenas" style="margin-top: 15px; border-top: 1px solid #d8c4ae; padding-top: 10px;">
            <h4 style="font-family: 'Cinzel', serif; color: #70452F; font-size: 1rem; margin-bottom: 8px;">Reseñas de lectores</h4>

            <div class="lista-resenas" style="max-height: 150px; overflow-y: auto; margin-bottom: 10px; font-size: 0.9rem;">
                <?php 
                    // Llamamos a la función del controlador para obtener las reseñas de este ISBN
                    $resenasLibro = $this->obtenerResenas($libro['isbn']);
                ?>

                <?php if (empty($resenasLibro)): ?>
                    <p style="color: #777; font-style: italic; font-size: 0.85rem;">Sé el primero en dejar una reseña.</p>
                <?php else: ?>
                    <?php foreach ($resenasLibro as $resena): ?>
                        <div style="background: #fffaf3; border: 1px solid #ebdcd0; padding: 6px 8px; border-radius: 4px; margin-bottom: 6px;">
                            <strong><?= htmlspecialchars($resena['usuario'], ENT_QUOTES, 'UTF-8') ?></strong> 
                            <span style="color: #b58100;">(<?= (int)$resena['calificacion'] ?> ⭐)</span>
                            <p style="margin: 3px 0 0 0; color: #444;"><?= htmlspecialchars($resena['comentario'], ENT_QUOTES, 'UTF-8') ?></p>
                            <small style="color: #888; font-size: 0.75rem;"><?= $resena['fecha'] ?? '' ?></small>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Formulario para dejar reseña (Solo si está logueado y no es bibliotecario) -->
<!-- Formulario para dejar reseña (Solo si está logueado y no es bibliotecario) -->
            <?php if ($estaLogueado && !$esBibliotecario): ?>
                <form action="Index.php?action=guardar_resena" method="POST" style="display: flex; flex-direction: column; gap: 6px;">
                    
                    <!-- Input oculto indispensable para saber el ISBN del libro -->
                    <input type="hidden" name="isbn" value="<?= htmlspecialchars($libro['isbn'], ENT_QUOTES, 'UTF-8') ?>">

                    <div style="font-size: 0.85rem; color: #70452F; font-weight: bold;">Tu calificación:</div>
                    <div class="estrellas-rating">
                        <input type="radio" id="star5-<?= $libro['isbn'] ?>" name="calificacion" value="5" required />
                        <label for="star5-<?= $libro['isbn'] ?>" title="5 estrellas">★</label>
                        
                        <input type="radio" id="star4-<?= $libro['isbn'] ?>" name="calificacion" value="4" />
                        <label for="star4-<?= $libro['isbn'] ?>" title="4 estrellas">★</label>
                        
                        <input type="radio" id="star3-<?= $libro['isbn'] ?>" name="calificacion" value="3" />
                        <label for="star3-<?= $libro['isbn'] ?>" title="3 estrellas">★</label>
                        
                        <input type="radio" id="star2-<?= $libro['isbn'] ?>" name="calificacion" value="2" />
                        <label for="star2-<?= $libro['isbn'] ?>" title="2 estrellas">★</label>
                        
                        <input type="radio" id="star1-<?= $libro['isbn'] ?>" name="calificacion" value="1" />
                        <label for="star1-<?= $libro['isbn'] ?>" title="1 estrellas">★</label>
                    </div>

                    <textarea name="comentario" placeholder="Escribe tu opinión..." required rows="2" style="padding: 5px; border-radius: 4px; border: 1px solid #d8c4ae; font-size: 0.85rem; resize: none;"></textarea>

                    <button type="submit" style="background-color: #70452F; color: white; border: none; padding: 6px; border-radius: 4px; cursor: pointer; font-family: 'Cinzel', serif; font-size: 0.8rem;">
                        Publicar Reseña
                    </button>
                </form>
            <?php endif; ?>
            </div>

                   
                                <!-- ACCIONES PARA BIBLIOTECARIOS -->

                                <?php if ($esBibliotecario): ?>

                                    <div class="acciones-admin">

                                        <!-- EDITAR LIBRO -->

                                        <a
                                            href="Index.php?action=editar_libro&isbn=<?= urlencode($libro['isbn']) ?>"
                                            class="btn-editar-libro"
                                        >
                                            Editar libro
                                        </a>


                                        <!-- ELIMINAR LIBRO -->

                                        <form
                                            method="POST"
                                            action="Index.php?action=eliminar_libro"
                                            onsubmit="return confirm('¿Estás seguro de que deseas eliminar este libro del catálogo?');"
                                        >

                                            <input
                                                type="hidden"
                                                name="isbn"
                                                value="<?= htmlspecialchars($libro['isbn'], ENT_QUOTES, 'UTF-8') ?>"
                                            >

                                            <button type="submit" class="btn-eliminar-libro">
                                                Eliminar libro
                                            </button>

                                        </form>

                                    </div>


                                <!-- ACCIONES PARA CLIENTES -->

                                <?php elseif ((int)$libro['stock'] > 0): ?>

                                    <?php if ($estaLogueado): ?>

                                        <!-- CLIENTE AUTENTICADO -->

                                        <form method="POST" action="Index.php?action=reservar">

                                            <input
                                                type="hidden"
                                                name="isbn"
                                                value="<?= htmlspecialchars($libro['isbn'], ENT_QUOTES, 'UTF-8') ?>"
                                            >

                                            <input type="hidden" name="cantidad" value="1">

                                            <button type="submit" class="btn-reservar-card">
                                                Reservar libro
                                            </button>

                                        </form>

                                    <?php else: ?>

                                        <!-- VISITANTE SIN CUENTA -->

                                        <button
                                            type="button"
                                            class="btn-reservar-card btn-requiere-registro"
                                            data-titulo="<?= htmlspecialchars($libro['titulo'], ENT_QUOTES, 'UTF-8') ?>"
                                        >
                                            Reservar libro
                                        </button>

                                    <?php endif; ?>


                                <!-- SIN STOCK -->

                                <?php else: ?>

                                    <button
                                        type="button"
                                        class="btn-reservar-card"
                                        style="background: #999; cursor: not-allowed;"
                                        disabled
                                    >
                                        Sin Stock
                                    </button>

                                <?php endif; ?>

                            </article>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </div>

            </section>

        </div>

    </main>


    <!-- =====================================
         PIE DE PÁGINA
    ===================================== -->

    <footer>
        LIBRO&LATTE
    </footer>


    <!-- =====================================
         MODALES
    ===================================== -->

    <div id="overlay" class="overlay">

        <!-- MODAL DE AVISO PARA VISITANTES -->

        <div id="modal-aviso-socio" class="modal">

            <button class="close-button" type="button">x</button>

            <h3>¡Conviértete en Socio!</h3>

            <p id="aviso-socio-mensaje">
                Para reservar y retirar libros en
                <strong>Libro&Latte</strong> necesitas registrarte
                con tu cuenta de socio. ¡Es rápido y gratis!
            </p>

            <button
                type="button"
                class="btn-modal-opcion btn-modal-registro"
                id="btn-ir-modal-registro"
            >
                Quiero Registrarme
            </button>

            <button
                type="button"
                class="btn-modal-opcion btn-modal-login"
                id="btn-ir-modal-login"
            >
                Ya tengo cuenta (Iniciar Sesión)
            </button>

        </div>


        <?php require_once __DIR__ . '/login.php'; ?>

        <?php require_once __DIR__ . '/registro.php'; ?>

    </div>


    <!-- =====================================
         JAVASCRIPT DE LOS MODALES
    ===================================== -->

    <script>

        document.addEventListener("DOMContentLoaded", function () {

            const overlay = document.getElementById("overlay");

            const modalAviso = document.getElementById("modal-aviso-socio");

            const modalLogin = document.getElementById("modal-login");

            const modalRegister = document.getElementById("modal-register");


            // CERRAR MODALES

            function cerrarModales() {

                if (overlay) {
                    overlay.classList.remove("overlay-open");
                }

                if (modalAviso) {
                    modalAviso.style.display = "none";
                }

                if (modalLogin) {
                    modalLogin.style.display = "none";
                }

                if (modalRegister) {
                    modalRegister.style.display = "none";
                }

            }


            // ABRIR MODAL

            function abrirModal(modal) {

                cerrarModales();

                if (overlay && modal) {

                    overlay.classList.add("overlay-open");

                    modal.style.display = "flex";

                }

            }


            // BOTONES DE CERRAR

            document.querySelectorAll(".close-button").forEach(btn => {

                btn.addEventListener("click", cerrarModales);

            });


            // CERRAR AL HACER CLIC EN EL FONDO

            if (overlay) {

                overlay.addEventListener("click", function (e) {

                    if (e.target === overlay) {
                        cerrarModales();
                    }

                });

            }


            // RESERVAR SIN ESTAR REGISTRADO

            document.querySelectorAll(".btn-requiere-registro").forEach(btn => {

                btn.addEventListener("click", function () {

                    const titulo = this.getAttribute("data-titulo") || "este libro";

                    const txt = document.getElementById("aviso-socio-mensaje");

                    if (txt) {

                        txt.innerHTML =
                            "Para reservar <strong>" +
                            titulo +
                            "</strong> y retirarlo en la biblioteca, necesitas una cuenta de socio. ¡Es rápido y gratis!";

                    }

                    abrirModal(modalAviso);

                });

            });


            // IR AL REGISTRO

            const btnIrRegistro = document.getElementById("btn-ir-modal-registro");

            if (btnIrRegistro) {

                btnIrRegistro.addEventListener("click", function () {

                    abrirModal(modalRegister);

                });

            }


            // IR AL LOGIN

            const btnIrLogin = document.getElementById("btn-ir-modal-login");

            if (btnIrLogin) {

                btnIrLogin.addEventListener("click", function () {

                    abrirModal(modalLogin);

                });

            }


            // LINKS DEL ENCABEZADO

            const navLogin = document.getElementById("nav-btn-login");

            if (navLogin) {

                navLogin.addEventListener("click", (e) => {

                    e.preventDefault();

                    abrirModal(modalLogin);

                });

            }


            const navRegister = document.getElementById("nav-btn-register");

            if (navRegister) {

                navRegister.addEventListener("click", (e) => {

                    e.preventDefault();

                    abrirModal(modalRegister);

                });

            }


            // LINKS DE LAS ALERTAS

            document.querySelectorAll(".trigger-modal-registro").forEach(el => {

                el.addEventListener("click", (e) => {

                    e.preventDefault();

                    abrirModal(modalRegister);

                });

            });


            document.querySelectorAll(".trigger-modal-login").forEach(el => {

                el.addEventListener("click", (e) => {

                    e.preventDefault();

                    abrirModal(modalLogin);

                });

            });

        });

    </script>

</body>

</html>
