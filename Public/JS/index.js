
document.addEventListener("DOMContentLoaded", function () {
    console.log("JS cargado correctamente.");

    // 1. Menú de usuario
    const btnUser = document.getElementById("button-user");
    const userMenu = document.getElementById("user-menu");

    if (btnUser && userMenu) {
        btnUser.addEventListener("click", function (e) {
            e.stopPropagation();
            userMenu.classList.toggle("open");
        });
    } else {
        console.warn("Falta #button-user o #user-menu.");
    }

    // 2. Elementos de los modales
    const overlay = document.getElementById("overlay");
    const modalLogin = document.getElementById("modal-login");
    const modalRegister = document.getElementById("modal-register");

    // Abrir inicio de sesión
    const linkLogin = document.getElementById("user-menu-link-login");

    if (linkLogin && overlay && modalLogin && modalRegister) {
        linkLogin.addEventListener("click", function (e) {
            e.preventDefault();
            overlay.classList.add("overlay-open");
            modalRegister.style.display = "none";
            modalLogin.style.display = "flex";

            if (userMenu) userMenu.classList.remove("open");
        });
    }

    // Abrir registro
    const linkRegister = document.getElementById("user-menu-link-register");

    if (linkRegister && overlay && modalLogin && modalRegister) {
        linkRegister.addEventListener("click", function (e) {
            e.preventDefault();
            overlay.classList.add("overlay-open");
            modalLogin.style.display = "none";
            modalRegister.style.display = "flex";

            if (userMenu) userMenu.classList.remove("open");
        });
    }

    // 3. Cerrar modales
    document.querySelectorAll(".close-button").forEach(function (button) {
        button.addEventListener("click", function () {
            if (overlay) overlay.classList.remove("overlay-open");

            document.querySelectorAll(".modal").forEach(function (modal) {
                modal.style.display = "none";
            });

            if (userMenu) userMenu.classList.remove("open");
        });
    });

    // 4. Filtrar libros por categoría
    const radios = document.querySelectorAll(
        'input[type="radio"][name="categoria"]'
    );

    radios.forEach(function (radio) {
        radio.addEventListener("change", function () {
            const allBooks = document.querySelectorAll("div.favourites-items");

            allBooks.forEach(function (book) {
                book.classList.add("hidden");
            });

            const selectedBooks = document.querySelectorAll(
                `div.favourites-items.${CSS.escape(radio.value)}`
            );

            selectedBooks.forEach(function (book) {
                book.classList.remove("hidden");
            });
        });
    });

    // 5. Inicializar carrusel
    showSlides(slideIndex);
});

// Carrusel   
let slideIndex = 1;

function plusSlides(n) {
    showSlides(slideIndex += n);
}

function showSlides(n) {
    const slides = document.getElementsByClassName("img");

    if (slides.length === 0) return;

    if (n > slides.length) slideIndex = 1;
    if (n < 1) slideIndex = slides.length;

    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }

    slides[slideIndex - 1].style.display = "block";
}



