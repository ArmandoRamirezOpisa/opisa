$(document).ready(function(){

	// Modifica el encabezado cuando hace scroll
	$(window).scroll(function(){
		if( $(this).scrollTop() > 114 ){
			$('#menu-nav').addClass('menu-scroll');
            $('#top-contenedor').slideDown('slow');
		} else {
			$('#menu-nav').removeClass('menu-scroll');
            $('#top-contenedor').slideUp('slow');
		}
	});


	// Función para enviar formulario de contcto

	$("#frmContacto").submit(function() {
    	event.preventDefault();

    	var data = {
            nombre   : $("#nombre").val(),
            correo   : $("#correo").val(),
            telefono : $("#telefono").val(),
            empresa  : $("#empresa").val(),
            mensaje  : $("#mensaje").val()
	    };

        $.ajax({
            type: "POST",
            url: "enviar-correo.php",
            data: data,
            success: function(){
            	$('.alert').slideDown('slow' , function() {
            		setTimeout(function() {
		                $('.alert').slideUp('slow');
		                $("#frmContacto").find(".form-control").val("");
		            },2500);
            	});
            }
        });

        return false;
    });

});
