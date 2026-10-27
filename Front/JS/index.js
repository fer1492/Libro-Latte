//Abrir menu de usuario
document.getElementById("button-user").addEventListener("click", function() {
    document.getElementById("user-menu").classList.toggle("open");
});

// Abrir overlay con menú login
document.getElementById("user-menu-link-login").addEventListener("click", function() {

    document.getElementById("overlay").classList.add("overlay-open");

    // Ocultar registro
    document.getElementById("modal-register").style.display = "none";

    // Mostrar login
    document.getElementById("modal-login").style.display = "flex";

});


// Abrir overlay con menú register
document.getElementById("user-menu-link-register").addEventListener("click", function() {

    document.getElementById("overlay").classList.add("overlay-open");

    // Ocultar login
    document.getElementById("modal-login").style.display = "none";

    // Mostrar registro
    document.getElementById("modal-register").style.display = "flex";

});

//Cerrar con cruz (equis)
document.querySelectorAll(".close-button").forEach(button => {
    button.addEventListener("click", function() {
        document
            .getElementById("overlay")
            .classList.remove("overlay-open");

        document.querySelectorAll(".modal").forEach(modal => {
            modal.style.display = "none";
        });

        document
            .getElementById("user-menu")
            .classList.remove("open");
    });

});

//Carousel
let slideIndex = 1;

//mostrar 1 imagen
showSlides(slideIndex);

//botones > y <
function plusSlides(n) {
    slideIndex = slideIndex + n;
    showSlides(slideIndex);
}

//Para listar
function showSlides(n) {
    let slides = document.getElementsByClassName("img");
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

//favoritos radio-button catalogo por categoria
document.addEventListener("DOMContentLoaded", function() {
    const radios = document.querySelectorAll('input[type=radio][name="categoria"]');
    radios.forEach(radio => (radio.addEventListener("change", () => {
        const allBooks = document.querySelectorAll("div.favourites-items");
        allBooks.forEach(book => (book.classList.add("hidden")));
        const seasonbooks = document.querySelectorAll(`div.favourites-items.${radio.value}`);
        seasonbooks.forEach(book => ((book.classList.remove("hidden"))));
    }))) 
});

//burguer-menu
//document.addEventListener("DOMContentLoaded", function() {
    //document.getElementById("menu-burguer-menu").addEventListener("click", function() {
        //document.getElementById("header-links").classList.toggle("open")
    //})
//});

//cerrar burguer con otro click
//document.getElementById("open-burger-menu").addEventListener('click', event => {
    //if (event._isClickWithInMenu) return;
    //document.getElementById("header-link").classList.remove("open")
//});
//document.getElementById("menu-burger-button").addEventListener('click', event => {
    //event._isClickWithInMenu = true;
//});
//document.body.addEventListener('click', event => {
    //if (event._isClickWithInMenu) return;
    //document.getElementById("header-links").classList.remove("open")
//});
