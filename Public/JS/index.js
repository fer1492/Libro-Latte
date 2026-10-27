document.addEventListener("DOMContentLoaded", function() {
    console.log("JS cargado correctamente."); // Para verificar en F12 -> Console

    // 1. Abrir menu de usuario
    const btnUser = document.getElementById("button-user");
    const userMenu = document.getElementById("user-menu");
    
    if (btnUser && userMenu) {
        btnUser.addEventListener("click", function(e) {
            e.stopPropagation(); // Evita interferencias de otros clics
            userMenu.classList.toggle("open");
            console.log("Clic en el botón de usuario detectado.");
        });
    } else {
        console.warn("No se encontró #button-user o #user-menu en el DOM.");
    }

    // 2. Abrir overlay con menú login
    const linkLogin = document.getElementById("user-menu-link-login");
    if (linkLogin) {
        linkLogin.addEventListener("click", function() {
            document.getElementById("overlay").classList.add("overlay-open");
            document.getElementById("modal-register").style.display = "none";
            document.getElementById("modal-login").style.display = "flex";
            if (userMenu) userMenu.classList.remove("open");
        });
    }

    // 3. Abrir overlay con menú register
    const linkRegister = document.getElementById("user-menu-link-register");
    if (linkRegister) {
        linkRegister.addEventListener("click", function() {
            document.getElementById("overlay").classList.add("overlay-open");
            document.getElementById("modal-login").style.display = "none";
            document.getElementById("modal-register").style.display = "flex";
            if (userMenu) userMenu.classList.remove("open");
        });
    }

    // 4. Cerrar con cruz (equis)
    document.querySelectorAll(".close-button").forEach(button => {
        button.addEventListener("click", function() {
            document.getElementById("overlay").classList.remove("overlay-open");

            document.querySelectorAll(".modal").forEach(modal => {
                modal.style.display = "none";
            });

            if (userMenu) {
                userMenu.classList.remove("open");
            }
        });
    });

    // 5. Favoritos radio-button catalogo por categoria
    const radios = document.querySelectorAll('input[type=radio][name="categoria"]');
    radios.forEach(radio => {
        radio.addEventListener("change", () => {
            const allBooks = document.querySelectorAll("div.favourites-items");
            allBooks.forEach(book => book.classList.add("hidden"));
            
            const seasonbooks = document.querySelectorAll(`div.favourites-items.${radio.value}`);
            seasonbooks.forEach(book => book.classList.remove("hidden"));
        });
    });

    // 6. Inicializar carrusel de forma segura una vez cargado el DOM
    showSlides(slideIndex);
});

// --- Carousel Globals ---
let slideIndex = 1;

function plusSlides(n) {
    slideIndex = slideIndex + n;
    showSlides(slideIndex);
}

function showSlides(n) {
    let slides = document.getElementsByClassName("img");
    if (slides.length > 0) {
        if (n > slides.length) {
            slideIndex = 1;
        }
        if (n < 1) {
            slideIndex = slides.length;
        }
        for (let i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        slides[slideIndex - 1].style.display = "block";
    }
}