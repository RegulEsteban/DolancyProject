$(function()
{
	$('#exampleEmployee').dataTable({
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
    
	$('#newEmployeeForm').validate({
    	lang: 'es',
        rules: {
            employee_name: {
                minlength: 2,
                required: true
            },
            employee_lastname: {
                minlength: 2,
                required: true
            },
            employee_matname: {
                minlength: 2
            },
            employee_address: {
                minlength: 2,
                required: true
            },
            employee_email: {
                required: true,
                email: true
            },
            employee_phone: {
                minlength: 10,
                maxlength: 10,
                required: true
            },
            employee_type: {
            	required: true
            },
            employee_branch: {
            	required: true
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

$(document).on('click', "#saveEmployee", saveEmployee);

function saveEmployee(e){
	var tabla = $("#exampleEmployee").DataTable();
	var isValid = $('#newEmployeeForm').valid();
	if(isValid){
		
		$.post("funcionesJSON.php", { employee_name: $('#employee_name').val(), 
										employee_lastname: $('#employee_lastname').val(),
										employee_matname: $('#employee_matname').val(),
										employee_email: $('#employee_email').val(),
										employee_phone: $('#employee_phone').val(),
										employee_address: $('#employee_address').val(),
										employee_type: $('#employee_type').val(),
										employee_branch: $('#employee_branch').val(),
										saveNewEmployee: true}, function(respuesta){
			if(respuesta.error != null){
				$("#modalTitle").html("<span class='glyphicon glyphicon-thumbs-down'></span> "+respuesta.error);
				$('#myModal').modal('show');
			}else{
				tabla.row.add([$('#employee_name').val()+" "+$('#employee_lastname').val()+" "+$('#employee_matname').val(), 
								$('#employee_address').val(),
								$('#employee_phone').val(),
								$('#employee_email').val(),
								$('#employee_type option:selected').text(),
								$('#employee_branch option:selected').text(),
								"<a href='#' class='editEmployee' ide = "+respuesta.id+"><span class='glyphicon glyphicon-pencil'></span> Editar</a> | <a href='#' class='removeEmployee' ide = "+respuesta.id+"><span class='glyphicon glyphicon-trash'></span> Eliminar</a>"])
				               .draw();
				alert("Empleado guardado.")
				validator.resetForm();
			}
		}, 'json');
	}else{
		return false;
	}
}
