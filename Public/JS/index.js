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
    }

    // 2. Elementos de los modales
    const overlay = document.getElementById("overlay");
    const modalLogin = document.getElementById("modal-login");
    const modalRegister = document.getElementById("modal-register");
    const modalAviso = document.getElementById("modal-aviso-socio");

    function cerrarTodosLosModales() {
        if (overlay) overlay.classList.remove("overlay-open");
        document.querySelectorAll(".modal").forEach(function (m) {
            m.style.display = "none";
        });
        if (userMenu) userMenu.classList.remove("open");
    }

    function abrirModal(modal) {
        cerrarTodosLosModales();
        if (overlay && modal) {
            overlay.classList.add("overlay-open");
            modal.style.display = "flex";
        }
    }

    // Botones de cerrar (x)
    document.querySelectorAll(".close-button").forEach(function (button) {
        button.addEventListener("click", cerrarTodosLosModales);
    });

    // Cerrar al hacer clic fuera del modal
    if (overlay) {
        overlay.addEventListener("click", function (e) {
            if (e.target === overlay) {
                cerrarTodosLosModales();
            }
        });
    }

    // Abrir inicio de sesión desde el menú
    const linkLogin = document.getElementById("user-menu-link-login");
    if (linkLogin) {
        linkLogin.addEventListener("click", function (e) {
            e.preventDefault();
            abrirModal(modalLogin);
        });
    }

    // Abrir registro desde el menú
    const linkRegister = document.getElementById("user-menu-link-register");
    if (linkRegister) {
        linkRegister.addEventListener("click", function (e) {
            e.preventDefault();
            abrirModal(modalRegister);
        });
    }

    // Botón "Reservar Ahora" presionado por usuario invitado (sin cuenta)
    document.querySelectorAll(".btn-requiere-registro").forEach(function (btn) {
        btn.addEventListener("click", function () {
            const titulo = this.getAttribute("data-titulo") || "este libro";
            const txt = document.getElementById("aviso-socio-mensaje");
            if (txt) {
                txt.innerHTML = "Para reservar <strong>" + titulo + "</strong> y retirarlo en la biblioteca, necesitas una cuenta de socio. ¡Es rápido y gratis!";
            }
            abrirModal(modalAviso);
        });
    });

    // Cambiar de aviso a Registro o Login
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

    // 3. Filtrar libros dinámicos por categoría
    function actualizarCategoria() {
        const checkedRadio = document.querySelector('input[type="radio"][name="categoria"]:checked');
        if (!checkedRadio) return;

        const catVal = checkedRadio.value;
        const allBooks = document.querySelectorAll("div.favourites-items");

        allBooks.forEach(function (book) {
            book.classList.add("hidden");
        });

        const selectedBooks = document.querySelectorAll(
            `div.favourites-items.${CSS.escape(catVal)}`
        );

        selectedBooks.forEach(function (book) {
            book.classList.remove("hidden");
        });

        const msgSinLibros = document.getElementById("sin-libros-categoria-msg");
        if (msgSinLibros) {
            if (selectedBooks.length === 0) {
                msgSinLibros.classList.remove("hidden");
            } else {
                msgSinLibros.classList.add("hidden");
            }
        }
    }

    const radios = document.querySelectorAll('input[type="radio"][name="categoria"]');
    radios.forEach(function (radio) {
        radio.addEventListener("change", actualizarCategoria);
    });

    // Ejecutar al cargar la página para reflejar la categoría activa
    actualizarCategoria();

    // 4. Inicializar carrusel
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
