//Select DOM items
const menuBtn = document.querySelector('.menu-btn');
const nav = document.getElementById('nav');
//Set initial state of menu
let showMenu = false;

menuBtn.addEventListener('click', toggleMenu);

function toggleMenu() {
    if (!showMenu) {
        menuBtn.classList.add('close');
        nav.classList.toggle('hide-mobile');
        showMenu = true;
    } else {
        menuBtn.classList.remove('close');
        nav.classList.add('hide-mobile');
        showMenu = false;
    }
}