<!-- Views/inicio.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Libro&Latte: Mauricio, Nicolas, Julio, Fernando...">
    <meta name="description" content="Proyecto Semestral TH2: Libro&Latte">
    <title>Bienvenidos a Libro&Latte</title>
    
    <!-- Rutas corregidas apuntando a las carpetas dentro de Public -->
    <link rel="stylesheet" href="../Public/css/Style.css">
    <link rel="stylesheet" href="../Public/css/Media-Querry.css">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700&family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/e7c741f98a.js" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <div id="logo">
            <img src="../Public/Assets/Logo transparente.png" alt="logo-libro&latte">
        </div>

        <h1>Biblioteca Libro&Latte</h1>
        
        <div id="header-links">
            <nav>
                <ul>
                    <li><a class="header-links" href="#about">Sobre Nosotros</a></li>
                    <li><a class="header-links" href="#favourites">Favoritos y Recomendaciones</a></li>
                    <li><a class="header-links" href="#Search">Busqueda</a></li>
                    <li><a class="header-links" href="#our-contacts">Ponte en contacto con nosotros</a></li>
                </ul>
            </nav>
        </div>        

        <!-- Menú de usuario ubicado de forma independiente y libre en el header -->
        <div id="user-menu" class="user-menu">
            <button id="button-user" type="button">
                <img id="user" src="../Public/Assets/icons/icono usuario.png" alt="user">
            </button>

            <div id="user-inactive">
                <p>Profile</p>
                <hr class="line-user">
                <button class="user-menu-link" id="user-menu-link-login" type="button">Inicio de Sesion</button>
                <button class="user-menu-link" id="user-menu-link-register" type="button">Registro</button>
            </div>
        </div> 
    </header>

    <main>
        <section id="about">
            <h2>Sobre Nosotros</h2>
            <p>Te damos la bienvenida a Libro&Latte, una libreria joven que fue creada para brindarte la mejor experiencia entre vos, un libro y café.</p> 
            <div id="carousel">
                <button class="prev" id="leftCarret" onclick="plusSlides(-1)" type="button">&lt;</button>
                <div id="carousel-img">
                    <img id="image1" src="../Public/Assets/valledelacalma.png" alt="library image" class="img">
                    <img id="image2" src="../Public/Assets/elhobbit.png" alt="library image" class="img">
                    <img id="image3" src="../Public/Assets/condorito.png" alt="library image" class="img">
                    <img id="image4" src="../Public/Assets/elultimomohicano.png" alt="library image" class="img">
                    <img id="image5" src="../Public/Assets/deadpool.png" alt="library image" class="img">
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
                    <input type="radio" id="ficcion" name="categoria" class="categoria" value="ficcion">
                    <label for="ficcion">Ficcion</label>
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
                    <label for="comic">Comic</label>
                </div>
            </fieldset>

            <div id="Favorite-items">
                <div class="favourites-items ficcion hidden">
                    <h3>Proyecto Hail Mary<br>De: Andy Weir</h3>
                    <p class="book-description">Ryland Grace despierta completamente solo en una nave espacial, sin recordar quién es ni cómo llegó allí. Poco a poco descubre que tiene una misión crucial para salvar a la humanidad. Una historia de ciencia ficción que combina misterio, aventura, ciencia y momentos de gran tensión.</p>
                    <button type="button" class="buy buy-before-login">Compralo Ya!</button>
                    <button type="button" class="rent rent-before-login">Alquilalo Ahora!</button>
                    <img id="book1" src="../Public/Assets/Proyecto Hail MaryAndy Weir.png" alt="Proyecto Hail Mary" class="img-books">
                </div>

                <div class="favourites-items no-ficcion">
                    <h3>La generación ansiosa<br>De: Jonathan Haidt</h3>
                    <p class="book-description">Jonathan Haidt analiza cómo el uso constante de los teléfonos inteligentes y las redes sociales ha transformado la infancia y la adolescencia. A partir de investigaciones y datos, el autor explora sus posibles efectos sobre el bienestar, las relaciones sociales y la forma en que los jóvenes se desarrollan.</p>
                    <button type="button" class="buy buy-before-login">Compralo Ya!</button>
                    <button type="button" class="rent rent-before-login">Alquilalo Ahora!</button>
                    <img id="book2" src="../Public/Assets/la generacion ansiosa.png" alt="La Generacion Ansiosa" class="img-books">
                </div>

                <div class="favourites-items infantil-y-juvenil hidden">
                    <h3>Amari y los hermanos de la noche<br>De: B. B. Alston</h3>
                    <p class="book-description">Amari está decidida a encontrar a su hermano desaparecido y descubre un mundo secreto lleno de magia y criaturas extraordinarias. Para encontrar respuestas deberá enfrentarse a numerosos desafíos y demostrar su valentía. Una aventura fantástica llena de misterio, amistad y acción.</p>
                    <button type="button" class="buy buy-before-login">Compralo Ya!</button>
                    <button type="button" class="rent rent-before-login">Alquilalo Ahora!</button>
                    <img id="book3" src="../Public/Assets/Amari y los hermanos de la noche.png" alt="Amari y los hermanos de la noche" class="img-books">
                </div>

                <div class="favourites-items textos hidden">
                    <h3>El infinito en un junco<br>De: Irene Vallejo</h3>
                    <p class="book-description">Irene Vallejo realiza un recorrido por la historia de los libros y la lectura, desde las antiguas civilizaciones hasta nuestros días. A través de relatos históricos y anécdotas, muestra cómo los textos han acompañado a la humanidad y han permitido conservar nuestras ideas y conocimientos.</p>
                    <button type="button" class="buy buy-before-login">Compralo Ya!</button>
                    <button type="button" class="rent rent-before-login">Alquilalo Ahora!</button>
                    <img id="book4" src="../Public/Assets/El infinito en un junco.png" alt="El infinito en un junco" class="img-books">
                </div>

                <div class="favourites-items manga hidden">
                    <h3>Jujutsu Kaisen<br>De: Gege Akutami</h3>
                    <p class="book-description">Yuji Itadori lleva una vida normal hasta que entra en contacto con un objeto maldito que cambia su destino. Después de convertirse en el recipiente de una poderosa maldición, comienza a entrenar para combatir criaturas sobrenaturales. Un manga intenso que combina acción, terror, humor y personajes memorables.</p>
                    <button type="button" class="buy buy-before-login">Compralo Ya!</button>
                    <button type="button" class="rent rent-before-login">Alquilalo Ahora!</button>
                    <img id="book5" src="../Public/Assets/jujutsu-kaisen.png" alt="Jujutsu Kaisen" class="img-books">
                </div>

                <div class="favourites-items comic hidden">
                    <h3>DeadPool<br>De: Marvel</h3>
                    <p class="book-description">Wade Wilson es un mercenario que, después de someterse a un peligroso experimento, obtiene habilidades de regeneración y adopta la identidad de Deadpool. Con su particular sentido del humor, rompe constantemente las reglas y se enfrenta a enemigos mientras combina acción, violencia y situaciones absurdas. Un cómic ideal para quienes buscan superhéroes con un estilo diferente y mucho humor.</p>
                    <button type="button" class="buy buy-before-login">Compralo Ya!</button>
                    <button type="button" class="rent rent-before-login">Alquilalo Ahora!</button>
                    <img id="book6" src="../Public/Assets/deadpool.png" alt="DeadPool" class="img-books">
                </div>
            </div>
        </section>

        <section id="Search">
            <h2>Busqueda por titulo, autor, codigo ISBN</h2> 
            <hr class="line">
            <div class="search-form">
                <input type="search" id="search-input" placeholder="Busqueda">
                <button type="button" id="search-button">Buscar</button>
            </div>

            <div id="search-result"></div>
        </section>

        <section id="our-contacts">
            <h2>Ponte en contacto con nosotros</h2>
            <hr class="line">
            <div id="info">
                <ol id="contact">
                    <li>Por Consultas:
                        <a class="tel" href="tel:+59822086787" target="_blank">(+598)22086787</a>
                    </li>
                    <li>Servicio Tecnico de Cuenta:
                        <a class="tel" href="tel:+59822086787" target="_blank">(+598)22086787</a>
                    </li>
                    <li id="contact-staff">Contacto via mail:
                        <a id="mail" href="mailto:contacto@libro&latte.com" target="_blank">Atencion Cliente</a> 
                    </li>
                </ol>

                <a class="adress" href="https://maps.app.goo.gl/uGDPaUuvHJdRLTxd7" target="_blank">
                    <img id="map" src="../Public/Assets/icons/mapa icono.png" alt="map">
                </a>
            </div> 
        </section>
    </main>

    <footer>LIBRO&LATTE</footer> 

    <!-- Contenedor general para modales flotantes -->
    <div id="overlay" class="overlay">
        <?php require_once 'login.php'; ?>
        <?php require_once 'registro.php'; ?>
    </div>

    <!-- Script JS desde la carpeta Public -->
    <script src="../Public/JS/index.js"></script>
</body>
</html>