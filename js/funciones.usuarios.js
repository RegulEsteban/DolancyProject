$(function()
{
	$('#exampleUser').dataTable({
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ning&uacute;n dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
        bInfo: false, bLengthChange: false
    });
    
	$('#newUserForm').validate({
    	lang: 'es',
        rules: {
            usu_email: {
                required: true,
                email: true
            },
            usu_pass: {
                minlength: 5,
                required: true
            },
            usu_pass_rep: {
            	equalTo: "#usu_pass"
            }
        },
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function(error, element) {
            if(element.parent('.form-control').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });
    
});

$(document).on('click', "#saveUsu", saveUsu);

function saveUsu(e){
	var tabla = $("#exampleUser").DataTable();
	var isValid = $('#newUserForm').valid();
	var validator = $("#newUserForm").validate();
	
	if(isValid){
		$.post("funcionesJSON.php", { usu_pass: $('#usu_pass').val(), 
										employee_select: $('#employee_select').val(),
										usu_email: $('#usu_email').val(),
										saveNewUser: true}, function(respuesta){
											
			if(respuesta.error != null){
				notificacionError(respuesta.error);
			}else{
				tabla.row.add([respuesta.name, 
								respuesta.address,
								respuesta.phone,
								respuesta.email,
								respuesta.tipo,
								respuesta.activo,
								respuesta.accion])
				               .draw();
				validator.resetForm();
				notificacionSuccess("Usuario guardado.");
			}
		}, 'json');
	}else{
		return false;
	}
}

function notificacionSuccess(texto){
	var n = noty({
        text        : "<br><span class='glyphicon glyphicon-ok'></span> "+texto,
        type        : 'alert',
        dismissQueue: true,
        layout      : 'top',
        theme       : 'defaultTheme',
        type		: 'success',
        timeout     : 8000
    });
}