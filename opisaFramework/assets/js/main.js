//Select DOM items
const menuBtn = document.querySelector('.menu-btn');
const nav = document.getElementById('nav');
// Items form contact
const alert = document.getElementById('alert');
const nombrePersona = document.getElementById('nombrePersona');
const correoPersona = document.getElementById('correoPersona');
const telefonoPersona = document.getElementById('telefonoPersona');
const empresaPersona = document.getElementById('empresaPersona');
const mensajePersona = document.getElementById('mensajePersona');
const btnEnviarCorreo = document.getElementById('btnEnviarCorreo');
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


btnEnviarCorreo.addEventListener('click', enviarCorreo);

function enviarCorreo() {
    if (nombrePersona.value == '' || correoPersona.value == '' || telefonoPersona.value == '' || mensajePersona.value == '') {
        alert.style.display = "block";
    } else {
        console.log(location.href);
        $.ajax({
            url: 'Welcome/sendMail',
            async: 'true',
            cache: false,
            contentType: "application/x-www-form-urlencoded",
            global: true,
            ifModified: false,
            processData: true,
            data: {
                "nombrePersona": nombrePersona.value,
                "correoPersona": correoPersona.value,
                "telefonoPersona": telefonoPersona.value,
                "empresaPersona": empresaPersona.value,
                "mensajePersona": mensajePersona.value
            },
            beforeSend: function() {},
            success: function(result) {

                if (result == "0") {
                    alert.style.display = 'block';
                    alert.classList.remove('alert-success');
                    alert.classList.add('alert-primary');
                    alert.innerHTML = "Algo salio mal, al momento de mandar el correo";
                } else {
                    alert.style.display = 'block';
                    alert.classList.remove('alert-primary');
                    alert.classList.add('alert-success');
                    alert.innerHTML = "Se mando el correo exitosamente";
                }

            },
            error: function(object, error, anotherObject) {},
            timeout: 30000,
            type: "POST"
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const elementosCarrusel = document.querySelectorAll('.carousel');
    M.Carousel.init(elementosCarrusel, {
        duration: 150
    });
});